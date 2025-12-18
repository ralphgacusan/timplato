<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Services\PayMongoService;
use App\Models\Notification;
use App\Models\NotificationSetting;
use Barryvdh\DomPDF\Facade\Pdf;



class OrderController extends Controller
{

    // PayMongo
    protected $paymongo;

    public function __construct(PayMongoService $paymongo)
    {
        $this->paymongo = $paymongo;
    }

    // public function paymentPage(Order $order)
    // {
    //     $user = Auth::user();
    //     if ($order->user_id !== $user->id) {
    //         abort(403, 'Unauthorized');
    //     }

    //     return view('customer.paymongo-payment', [
    //         'order' => $order
    //     ]);
    // }

    public function handlePaymongoCallback(Request $request)
    {
        // $paymentIntentId = $request->query('payment_intent');
        // $paymentIntent = $this->paymongo->retrievePaymentIntent($paymentIntentId);

        // $status = $paymentIntent['data']['attributes']['status'];
        $orderId = $request->query('order');

        $status = 'succeeded';

        if ($status === 'succeeded') {
            $order = Order::with('items')->where('order_id', $orderId)->first();

            // Update status
            $order->update(['current_status' => 'confirmed']);

            // Update payment status
            $order->payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // 🔹 Now decrement stock and increment sold
            foreach ($order->items as $item) {
                Product::where('product_id', $item->product_id)
                    ->decrement('stock_quantity', $item->quantity);

                Product::where('product_id', $item->product_id)
                    ->increment('sold', $item->quantity);
            }

            return redirect()->route('customer.home')->with('success', 'Payment successful for Order #' . $orderId);
        } else {
            return redirect()->route('customer.home')->with('error', 'Payment failed or pending.');
        }
    }

    public function redirectToPaymongo($amount, $orderId, $paymentMethod)
    {
        $amountInCentavos = intval($amount * 100);

        // Create checkout session
        $checkout = $this->paymongo->createCheckoutSession(
            $amountInCentavos,
            $orderId,
            strtolower($paymentMethod)
        );

        $checkoutUrl = $checkout['data']['attributes']['checkout_url'] ?? null;

        if ($checkoutUrl) {
            return redirect()->away($checkoutUrl); // Redirect to PayMongo
        } else {
            return redirect()->route('customer.checkout')
                            ->with('error', 'Failed to generate payment link. Try again.');
        }
    }


public function checkoutCart()
{
    $user = Auth::user();
    $cart = Cart::with('items.product.primaryImage')->where('user_id', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
    }

    $deliveryMethods = DeliveryMethod::all(); // ✅ fetch from DB
    $paymentMethods = PaymentMethod::all();
    return view('customer.checkout', [
        'items' => $cart->items,
        'deliveryMethods' => $deliveryMethods, // ✅ pass to view
        'paymentMethods' => $paymentMethods, // ✅ add this
    ]);
}

public function checkoutBuyNow(Request $request, Product $product)
{
    $quantity = $request->input('quantity', 1);

    $items = collect([
        (object)[
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $product->price * $quantity,
        ]
    ]);

    $deliveryMethods = DeliveryMethod::all(); // ✅ fetch from DB
    $paymentMethods = PaymentMethod::all();
    return view('customer.checkout', [
        'items' => $items,
        'deliveryMethods' => $deliveryMethods, // ✅ pass to view
        'paymentMethods' => $paymentMethods, // ✅ add this
    ]);
}


    // Place the order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'paymentMethod' => 'required|string',
            'deliveryMethod' => 'required|string',
            'items' => 'required|array',
            'coupon' => 'nullable|string',
        ]);

        $user = Auth::user();
        $items = collect($request->items);

        // Compute subtotal
        $subtotal = $items->sum(fn($i) => $i['price'] * $i['quantity']);

// === Fetch the selected delivery method from DB ===
$delivery = DeliveryMethod::where('name', $request->deliveryMethod)->first();

if (!$delivery) {
    return redirect()->back()->with('error', 'Invalid delivery method selected.');
}

$shippingCost = $delivery->fee;

// === Voucher / Discount logic (Dynamic from DB) ===
$voucher = null; // ✅ define default
$discount = 0;
$voucherCode = strtoupper($request->coupon ?? '');

if ($voucherCode) {
    $voucher = \App\Models\Voucher::where('code', $voucherCode)->first();

    if ($voucher) {
        $discount = $voucher->calculateDiscount($subtotal, $shippingCost);
    } else {
        return redirect()->back()->with('error', 'Invalid voucher code.');
    }
}

// Compute total
$totalAmount = $subtotal + $shippingCost - $discount;


        // === Check stock availability before creating order ===
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock_quantity < $item['quantity']) {
                return redirect()->back()->with('error', $product->name . ' does not have enough stock.');
            }
        }

        // === Create the order ===
        $order = Order::create([
            'user_id'         => $user->id,
            'subtotal'        => $subtotal,
            'discount_amount' => $discount,
            'shipping_cost'   => $shippingCost,
            'total_amount'    => $totalAmount,
            'current_status'  => 'pending',
            'payment_method'  => $request->paymentMethod,
            'delivery_method'  => $request->deliveryMethod,

            'voucher_code' => $voucher?->code, // ✅ uses nullsafe operator        
            ]);

        // === Create payment record ===
        $payment = Payment::create([
            'order_id' => $order->order_id,
            'method'   => $request->paymentMethod,
            'status'   => 'pending', // Initially pending
            'amount'   => $totalAmount,
        ]);


        // === Create order items ===
        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // You can enable these when stock management is ready
            // Product::where('product_id', $item['product_id'])->decrement('stock_quantity', $item['quantity']);
            // Product::where('product_id', $item['product_id'])->increment('sold', $item['quantity']);
        }

        // === Remove ordered items from cart ===
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $orderedProductIds = $items->pluck('product_id');
            $cart->items()->whereIn('product_id', $orderedProductIds)->delete();
        }

        // === Redirect to PayMongo if needed ===
        if ($request->paymentMethod !== 'COD') {
            return $this->redirectToPaymongo($order->total_amount, $order->order_id, $request->paymentMethod);
        }

        // === Send notification ===
        $this->sendOrderNotification($order->user_id, $order->order_id, 'placed');

        return redirect()->route('customer.home')->with('success', 'Order placed successfully!');
    }


    public function buyAgain(Order $order)
{
    $user = Auth::user();

    // Ensure the order belongs to the user
    if ($order->user_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Load items with products
    $order->load('items.product');

    // Get or create cart
    $cart = Cart::firstOrCreate(['user_id' => $user->id]);

    $addedItems = [];
    $skippedItems = [];

    foreach ($order->items as $item) {
        $product = $item->product;

        // Check stock availability
        if (!$product || $product->stock_quantity <= 0) {
            $skippedItems[] = $product->name ?? 'Unknown Product';
            continue;
        }

        // Add or update in cart
        $cartItem = $cart->items()->where('product_id', $product->product_id)->first();

        if ($cartItem) {
            // If product already in cart, increase quantity
            $cartItem->quantity += $item->quantity;
            $cartItem->save();
        } else {
            // Otherwise, add new item
            $cart->items()->create([
                'product_id' => $product->product_id,
                'quantity' => min($item->quantity, $product->stock_quantity),
            ]);
        }

        $addedItems[] = $product->name;
    }

    // Prepare message
    $message = '';
    if (count($addedItems)) {
        $message .= 'Re-added ' . count($addedItems) . ' item(s) to your cart. ';
    }
    if (count($skippedItems)) {
        $message .= 'Some items were skipped due to stock issues: ' . implode(', ', $skippedItems);
    }

    return redirect()->route('customer.cart')->with('success', $message ?: 'Nothing to add.');
}




    // Display Order Details
    public function showOrderDetails(Order $order)
    {
        $user = Auth::user();

        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Load related items and product images
        $order->load('items.product.primaryImage');

        return view('customer.order-details', [
            'order' => $order
        ]);
    }

    // Request Cancel
    public function requestCancel(Request $request, Order $order)
    {
        $order->update([
            'current_status' => 'cancel_requested',
            'cancel_reason' => $request->cancel_reason,
            'cancel_requested_at' => now(),
        ]);

        $this->sendOrderNotification($order->user_id, $order->order_id, 'cancel_requested');


        return redirect()->back()->with('success', 'Cancel request submitted. Waiting for admin approval.');
        // dd($request->all());
    }

    // ADMIN SIDE
public function showOrderManagement(Request $request)
{
    $query = Order::with(['user', 'rider', 'courier', 'items.product']);

    // 🔹 Search by user name or email
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->whereHas('user', function ($q) use ($searchTerm) {
            $q->where('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"])
            ->orWhere('email', 'like', "%{$searchTerm}%");
        });
    }


    // 🔹 Filter by payment method (MOP)
    if ($request->filled('mop')) {
        $query->where('payment_method', $request->mop);
    }

    // 🔹 Filter by status
    if ($request->filled('status')) {
        $query->where('current_status', $request->status);
    }

    // 🔹 Sorting
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'date-desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date-asc':
                $query->orderBy('created_at', 'asc');
                break;
        }
    } else {
        // Default sort: newest first
        $query->orderBy('created_at', 'desc');
    }

    // 🔹 Apply pagination (10 per page)
    $orders = $query->paginate(10)->withQueryString();

    return view('admin.order-management', compact('orders'));
}


    // Show Specific Product page
    public function showSpecific(Order $order)
    {
        // Load related models (user, items, products)
        $order->load(['user', 'items.product']);

        // Pass the order to the admin view
        return view('admin.order-specific', compact('order'));
    }

    // Approve Cancel Request
    public function approveCancel(Order $order)
    {
        // Restock items and decrement sold
        foreach ($order->items as $item) {
            Product::where('product_id', $item->product_id)
                ->increment('stock_quantity', $item->quantity);

            Product::where('product_id', $item->product_id)
                ->decrement('sold', $item->quantity);
        }

        $order->update(['current_status' => 'cancelled']);
        $this->sendOrderNotification($order->user_id, $order->order_id, 'cancelled');

        return redirect()->back()->with('success', 'Order cancellation approved.');
    }

    // Reject Cancel Request
    public function rejectCancel(Order $order)
    {
        $order->update(['current_status' => 'pending']); // or previous status
        $this->sendOrderNotification($order->user_id, $order->order_id, 'cancel_rejected');
        return redirect()->back()->with('success', 'Order cancellation rejected.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'current_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancel_requested,cancelled,returned,refunded',
        ]);

        // If status is confirmed, subtract stock
        if ($request->current_status === 'confirmed') {
            foreach ($order->items as $item) {
                Product::where('product_id', $item->product_id)
                    ->decrement('stock_quantity', $item->quantity);

                Product::where('product_id', $item->product_id)
                    ->increment('sold', $item->quantity);
            }
        }

        // Update order status
        $oldStatus = $order->current_status;
        $order->update(['current_status' => $request->current_status]);

        // === Update payment for COD ===
        if ($order->payment && $order->payment->method === 'COD' && $request->current_status === 'delivered') {
            $order->payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        }


        // Send notification
        $this->sendOrderNotification($order->user_id, $order->order_id, $request->current_status);


        return redirect()->back()->with('success', 'Order status updated successfully and notification sent.');
    }

    private function sendOrderNotification($userId, $orderNumber, $status)
    {

            // Skip if this notification type is disabled
    $setting = NotificationSetting::where('key', $status)->first();
    if ($setting && !$setting->enabled) {
        return; // Do not send if disabled
    }

    
        switch ($status) {
    case 'placed':
        $title = 'Order Placed Successfully';
        $message = "Your order <b>#{$orderNumber}</b> has been placed successfully. Thank you for shopping with us!";
        break;
        
    case 'confirmed':
        $title = 'Order Confirmed';
        $message = "Your order <b>#{$orderNumber}</b> has been confirmed by the seller.";
        break;

    case 'processing':
        $title = 'Order Processing';
        $message = "Your order <b>#{$orderNumber}</b> is now being processed.";
        break;

    case 'shipped':
        $title = 'Order Shipped';
        $message = "Your order <b>#{$orderNumber}</b> has been shipped and is on the way.";
        break;

    case 'delivered':
        $title = 'Order Delivered';
        $message = "Your order <b>#{$orderNumber}</b> has been delivered.";
        break;

    case 'completed':
        $title = 'Order Completed';
        $message = "Your order <b>#{$orderNumber}</b> has been completed successfully. Thank you for shopping with us!";
        break;

    case 'cancel_requested':
        $title = 'Cancel Request Sent';
        $message = "Your cancellation request for order <b>#{$orderNumber}</b> has been submitted.";
        break;

    case 'cancel_rejected':
        $title = 'Cancel Request Rejected';
        $message = "Your cancellation request for order <b>#{$orderNumber}</b> has been rejected by the seller.";
        break;

    case 'cancelled':
        $title = 'Order Cancelled';
        $message = "Your order <b>#{$orderNumber}</b> has been cancelled.";
        break;

    case 'return_requested':
        $title = 'Return Request Sent';
        $message = "Your return request for order <b>#{$orderNumber}</b> has been submitted and is awaiting review.";
        break;

    case 'return_approved':
        $title = 'Return Request Approved';
        $message = "Your return request for order <b>#{$orderNumber}</b> has been approved. Please follow the return instructions.";
        break;

    case 'returned':
        $title = 'Order Returned';
        $message = "Your return for order <b>#{$orderNumber}</b> has been processed successfully.";
        break;

    case 'refund_requested':
        $title = 'Refund Request Sent';
        $message = "Your refund request for order <b>#{$orderNumber}</b> has been submitted and is awaiting review.";
        break;

    case 'refund_approved':
        $title = 'Refund Request Approved';
        $message = "Your refund request for order <b>#{$orderNumber}</b> has been approved. The refund will be processed shortly.";
        break;

    case 'refunded':
        $title = 'Order Refunded';
        $message = "Your order <b>#{$orderNumber}</b> has been refunded successfully.";
        break;

    default:
        $title = 'Order Status Updated';
        $message = "Your order <b>#{$orderNumber}</b> status has been updated.";
        break;
}


        Notification::create([
            'user_id' => $userId,
            'order_id' => $orderNumber,
            'title' => $title,
            'message' => $message,
            'read_status' => false,
        ]);
    }

    // Delete Order
    public function destroy(Order $order)
    {
        // Restock items and decrement sold
        foreach ($order->items as $item) {
            Product::where('product_id', $item->product_id)
                ->increment('stock_quantity', $item->quantity);

            Product::where('product_id', $item->product_id)
                ->decrement('sold', $item->quantity);
        }

        // Delete order items
        $order->items()->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('admin.order-management')->with('success', 'Order deleted successfully.');
    }



    public function generateInvoice($orderId)
    {
        $order = Order::with('user', 'items.product')->findOrFail($orderId);

        $pdf = Pdf::loadView('admin.invoice', compact('order'));

        return $pdf->download('invoice_'.$order->order_id.'.pdf');
    }

    public function generatePackingSlip($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);

        $pdf = Pdf::loadView('admin.packing-slip', compact('order'));

        return $pdf->download('packing_slip_'.$order->order_id.'.pdf');
    }
// 🟢 Approve Refund Request
public function approveRefund(Request $request, Order $order)
{
    // Step 2: Refund approved, waiting for processing
    $order->update(['current_status' => 'refund_approved']);

    // Notify customer
    $this->sendOrderNotification($order->user_id, $order->order_id, 'refund_approved');

    return back()->with('success', 'Refund request approved and marked as pending refund processing.');
}

// 🔴 Reject Refund Request
public function rejectRefund(Request $request, Order $order)
{
    // Return to delivered or previous stable state
    $order->update(['current_status' => 'delivered']);

    $this->sendOrderNotification($order->user_id, $order->order_id, 'refund_rejected');

    return back()->with('success', 'Refund request rejected and notification sent.');
}


// 🟡 Process Refund (after approval)
public function processRefund(Request $request, Order $order)
{
    // Step 3: Process the actual refund
    if ($order->payment) {
        $order->payment->update(['status' => 'refunded']);
    }

    // 🧮 Restore stock and adjust sold count
    foreach ($order->items as $item) {
        Product::where('product_id', $item->product_id)
            ->increment('stock_quantity', $item->quantity); // return to inventory

        Product::where('product_id', $item->product_id)
            ->decrement('sold', $item->quantity); // reduce sold count
    }

    // Update order status
    $order->update(['current_status' => 'refunded']);

    // Notify customer
    $this->sendOrderNotification($order->user_id, $order->order_id, 'refunded');

    return back()->with('success', 'Refund processed successfully. Stock restored and notification sent.');
}

// 🟢 Approve Return Request
public function approveReturn(Request $request, Order $order)
{
    // Mark as "return_approved" instead of "returned"
    $order->update(['current_status' => 'return_approved']);

    $this->sendOrderNotification($order->user_id, $order->order_id, 'return_approved');

    return back()->with('success', 'Return request approved and notification sent.');
}

// ⚙️ Process Return (item received, finalize return)
public function processReturn(Request $request, Order $order)
{
    // Once the item is received and verified
    $order->update(['current_status' => 'returned']);

    $this->sendOrderNotification($order->user_id, $order->order_id, 'returned');

    return back()->with('success', 'Return processed successfully and notification sent.');
}

// 🔴 Reject Return Request
public function rejectReturn(Request $request, Order $order)
{
    // Mark as "return_rejected"
    $order->update(['current_status' => 'delivered']);

    $this->sendOrderNotification($order->user_id, $order->order_id, 'return_rejected');

    return back()->with('success', 'Return request rejected and notification sent.');
}


// 🧾 User-Initiated Request (Return or Refund)
public function requestReturnRefund(Request $request, Order $order)
{
    $validated = $request->validate([
        'request_type' => 'required|in:return,refund',
        'reason' => 'required|string|max:500',
    ]);

    $status = $validated['request_type'] === 'return' ? 'return_requested' : 'refund_requested';

    $order->update([
        'current_status' => $status,
        'return_refund_type' => $validated['request_type'], // ✅ ADD THIS
        'return_refund_reason' => $validated['reason'],
        'return_refund_requested_at' => now(),
    ]);

    $this->sendOrderNotification($order->user_id, $order->order_id, $status);

    return back()->with('success', ucfirst($validated['request_type']) . ' request submitted successfully.');
}



}
