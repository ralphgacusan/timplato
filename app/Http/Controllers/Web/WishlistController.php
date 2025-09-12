<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Add a product to wishlist
    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
                          ->where('product_id', $productId)
                          ->first();

        if ($exists) {
            return redirect()->back()->with('message', 'Product already in wishlist!');
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    // Remove a product from wishlist
    public function remove(Request $request, $productId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        }

        return redirect()->back()->with('message', 'Product not found in wishlist.');
    }

    // Show the user's wishlist
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $wishlistItems = Wishlist::with('product')
                                 ->where('user_id', $user->id)
                                 ->get();

        return view('customer.wishlist', compact('wishlistItems'));
    }

    // Check if a product is in the wishlist (useful for showing heart icon)
    public static function isInWishlist($productId)
    {
        $user = Auth::user();

        if (!$user) return false;

        return Wishlist::where('user_id', $user->id)
                       ->where('product_id', $productId)
                       ->exists();
    }
}
