<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // Show Cart Page
    public function cartPage()
{
    $userId = Auth::id();

    // Get the cart for the user
    $cart = Cart::with(['items.product.primaryImage'])->where('user_id', $userId)->first();

    // Optional: If user has no cart yet, create an empty one
    if (!$cart) {
        $cart = Cart::create(['user_id' => $userId]);
    }

    return view('customer.cart', compact('cart'));
}

public function addToCart(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $userId = Auth::id();

    // Find or create the cart for the user
    $cart = Cart::firstOrCreate(['user_id' => $userId]);

    // Check if product already exists in this user's cart
    $cartItem = CartItem::where('cart_id', $cart->cart_id)
        ->where('product_id', $product->product_id)
        ->first();

    if ($cartItem) {
        // If exists, just add to quantity
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        // Otherwise create new cart item
        CartItem::create([
            'cart_id'    => $cart->cart_id,
            'product_id' => $product->product_id,
            'quantity'   => $request->quantity
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart successfully.');
}

public function updateQuantity(Request $request, CartItem $cartItem)
{
    $action = $request->action; // "increase" or "decrease"

    if ($action === 'increase') {
        $cartItem->quantity += 1;
    } elseif ($action === 'decrease' && $cartItem->quantity > 1) {
        $cartItem->quantity -= 1;
    }

    $cartItem->save();

    // Return JSON with updated quantity and total
    return response()->json([
        'quantity' => $cartItem->quantity,
        'total' => number_format($cartItem->quantity * $cartItem->product->price, 2),
    ]);
}

public function remove($cartItemId)
{
    $cartItem = CartItem::findOrFail($cartItemId);
    $cartItem->delete();

    return response()->json(['success' => true]);
}






}
