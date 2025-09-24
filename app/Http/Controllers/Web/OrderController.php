<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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



}
