<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   
use App\Models\Review;           
use Illuminate\Support\Facades\Validator;     


class ReviewController extends Controller
{
     /**
     * Store a new review
     */
public function store(Request $request, $product_id)
{
    $validator = Validator::make($request->all(), [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Please select a rating before submitting.')
            ->with('open_review_modal', $product_id);
    }

    Review::create([
        'product_id' => $product_id,
        'user_id'    => Auth::id(),
        'rating'     => $request->rating,
        'comment'    => $request->comment,
    ]);

    return back()
        ->with('success', 'Review submitted successfully!')
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
