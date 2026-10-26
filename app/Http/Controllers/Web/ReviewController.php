<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   
use App\Models\Product;
use App\Models\Review;           
use Illuminate\Support\Facades\Validator;     


class ReviewController extends Controller
{
     /**
     * Store a new review
     */
public function store(Request $request, $product_id)
{
    $product = Product::findOrFail($product_id);

    $validator = Validator::make($request->all(), [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Please check the rating and comment and try again.')
            ->with('open_review_modal', $product_id);
    }

    $validated = $validator->validated();

    Review::create([
        'product_id' => $product->product_id,
        'user_id'    => Auth::id(),
        'rating'     => $validated['rating'],
        'comment'    => $validated['comment'] ?? null,
    ]);

    return back()
        ->with('success', 'Review submitted successfully. Reviews are displayed as plain text; HTML and scripts cannot run.')
        ->with('open_review_modal', $product_id);
}


    /**
     * Display reviews for a product
     */
    // public function index($product_id)
    // {
    //     $reviews = Review::with('user')
    //         ->where('product_id', $product_id)
    //         ->latest()
    //         ->get();

    //     return view('reviews.index', compact('reviews'));
    // }
}
