@extends('security-testing.layout')

@section('title', $product['name'].' - Timplato')

@section('content')
    <section class="product-page-container lab-product-page">
        <div class="product-image-section">
            <div class="main-product-image-container">
                <img src="{{ asset('images/products/rice_bowl_with_local_designs_1.jpg') }}"
                    alt="{{ $product['name'] }}" class="lab-product-image">
            </div>
        </div>

        <div class="product-details-section">
            <h1 class="product-title">{{ $product['name'] }}</h1>
            <div class="product-brand">Catalog item #{{ $product['id'] }}</div>
            <div class="product-rating">{{ count($reviews) }} Customer Reviews</div>
            <div class="product-description">
                <h4>Product Details</h4>
                <p>Share your experience with this product and read what other customers think.</p>
            </div>

            <form class="loginForm lab-review-form" action="{{ route('security-testing.reviews.store') }}" method="POST">
                @csrf
                <div class="formGroup">
                    <label class="formLabel" for="author">Your name</label>
                    <input class="formInput" id="author" name="author" type="text" placeholder="Enter your name">
                </div>
                <div class="formGroup">
                    <label class="formLabel" for="comment">Your review</label>
                    <textarea class="formInput" id="comment" name="comment" placeholder="Share your experience"></textarea>
                </div>
                <p class="lab-fixture-note">Review comments are displayed as submitted.</p>
                <button class="formButton" type="submit">Submit Review</button>
            </form>
        </div>
    </section>

    <section class="reviews-section">
        <h3>Customer Reviews ({{ count($reviews) }})</h3>
        @forelse ($reviews as $review)
            <article class="review-card">
                <div class="review-header">{{ $review['author'] }}</div>
                <div class="review-body">{!! $review['comment'] !!}</div>
                <div class="review-date">{{ $review['created_at'] }}</div>
            </article>
        @empty
            <p>No reviews yet. Be the first to review this product!</p>
        @endforelse

        <form class="lab-reset-form" action="{{ route('security-testing.reviews.reset') }}" method="POST">
            @csrf
            <button type="submit">Clear Reviews</button>
        </form>
    </section>

    @include('security-testing.database')
@endsection
