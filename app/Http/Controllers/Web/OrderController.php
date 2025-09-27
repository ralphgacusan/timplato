<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Services\PayMongoService;

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



    // Checkout page for full cart
    public function checkoutCart()
    {
        $user = Auth::user();
        $cart = Cart::with('items.product.primaryImage')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
        }

        return view('customer.checkout', ['items' => $cart->items]);
    }

    // Checkout page for single product (Buy Now)
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

        return view('customer.checkout', ['items' => $items]);
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

        $subtotal = $items->sum(fn($i) => $i['price'] * $i['quantity']);

        // Delivery fee
        $deliveryFees = [
            'Premium Delivery' => 100,
            'Named Day Delivery' => 150,
            'Standard Delivery' => 0,
        ];
        $deliveryFee = $deliveryFees[$request->deliveryMethod] ?? 0;

        // Voucher/discount logic
        $discount = 0;
        $voucher = strtoupper($request->coupon ?? '');
        if ($voucher === 'ALDEN50') {
            $discount = 50;
        } elseif ($voucher === 'DEENICE10P') {
            $discount = ($subtotal + $deliveryFee) * 0.10;
        } elseif ($voucher === 'JOMSPOGI100') {
            $discount = 100;
        } elseif ($voucher === 'BAYUCAN20P') {
            $discount = ($subtotal + $deliveryFee) * 0.20;
        } elseif ($voucher === 'GACUSAN30') {
            $discount = ($subtotal + $deliveryFee) * 0.30;
        }

        $totalAmount = $subtotal + $deliveryFee - $discount;

        // Check stock availability before creating order
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock_quantity < $item['quantity']) { // use correct column
                return redirect()->back()->with('error', $product->name . ' does not have enough stock.');
            }
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'current_status' => 'pending',
            'payment_method' => $request->paymentMethod,
            'discount_amount' => $discount,  // <-- changed from 'discount'
            'voucher_code' => $voucher ?: null, // this is fine
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // // Decrement stock and increment sold
            // Product::where('product_id', $item['product_id'])->decrement('stock_quantity', $item['quantity']);

            // Product::where('product_id', $item['product_id'])->increment('sold', $item['quantity']);
        }

        // PayMongo if payment method is not Cash on Delivery
        if ($request->paymentMethod !== 'COD') {
            return $this->redirectToPaymongo($order->total_amount, $order->order_id, $request->paymentMethod);
        }



        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
        $orderedProductIds = $items->pluck('product_id');

        $cart->items()->whereIn('product_id', $orderedProductIds)->delete();
    }

        return redirect()->route('customer.home')->with('success', 'Order placed successfully!');
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

        return redirect()->back()->with('success', 'Cancel request submitted. Waiting for admin approval.');
        // dd($request->all());
    }

    // ADMIN SIDE
    public function showOrderManagement(Request $request)
    {
        $query = Order::with(['user', 'rider', 'courier', 'items.product']);

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
        return redirect()->back()->with('success', 'Order cancellation approved.');
    }

    // Reject Cancel Request
    public function rejectCancel(Order $order)
    {
        $order->update(['current_status' => 'pending']); // or previous status
        return redirect()->back()->with('success', 'Order cancellation rejected.');
    }

    // Update current status
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

        $order->update(['current_status' => $request->current_status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
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



}
