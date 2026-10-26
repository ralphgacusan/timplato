@extends('security-testing.layout')

@section('title', ($product['name'] ?? 'Product details').' | Timplato')

@section('content')
    @if (empty($product))
        <section class="empty-state product-missing">
            <span class="empty-state__icon" aria-hidden="true">✧</span>
            <h1>We couldn't find that piece.</h1>
            @if ($queryError ?? false)
                <p role="alert">{{ $queryError }}</p>
            @else
                <p>It may have moved to another kitchen.</p>
            @endif
            <a class="button button--primary" href="{{ route('security-testing.products') }}">Back to the collection</a>
        </section>
    @else
    @php
        $averageRating = collect($reviews)->avg('rating') ?: 0;
        $productImage = !empty($product['image']) ? $product['image'] : 'images/products/4piece_plate_set_1.jpg';
    @endphp

    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <a href="{{ route('security-testing.products') }}">Shop</a><span aria-hidden="true">/</span>
        <span>{{ $product['name'] }}</span>
    </nav>

    @if (isset($feedback) || session()->has('feedback') || ($queryError ?? false))
        <div class="notice {{ ($queryError ?? false) ? 'notice--error' : '' }}" role="status">{{ $feedback ?? session('feedback') ?? $queryError }}</div>
    @endif
    <section class="product-detail" aria-labelledby="product-title">
        <div class="product-detail__visual">
            <div class="product-detail__image-frame">
                <img src="{{ asset($productImage) }}" alt="{{ $product['name'] }}">
                <span class="image-caption">A considered favorite for your kitchen</span>
            </div>
            <div class="product-detail__image-note"><span aria-hidden="true">✳</span> Useful things, made for daily life</div>
        </div>

        <div class="product-detail__info">
            <p class="eyebrow">{{ $product['category'] ?? 'The Timplato kitchen edit' }}</p>
            <h1 id="product-title">{{ $product['name'] }}</h1>
            <div class="rating-summary">
                <span class="rating-stars" aria-label="{{ number_format((float) $averageRating, 1) }} out of 5 stars">
                    @for ($star = 1; $star <= 5; $star++)
                        <span class="{{ $star <= round($averageRating) ? 'is-filled' : '' }}" aria-hidden="true">★</span>
                    @endfor
                </span>
                <a href="#reviews">{{ number_format((float) $averageRating, 1) }} <span>·</span> {{ count($reviews) }} reviews</a>
            </div>
            <p class="product-detail__price">₱{{ number_format((float) ($product['price'] ?? 0), 2) }}</p>
            <p class="product-detail__description">{{ $product['description'] ?? 'A reliable everyday piece, thoughtfully picked to make home cooking feel good.' }}</p>
            <div class="product-detail__availability">
                <span class="availability-dot"></span>
                {{ (int) ($product['stock'] ?? 0) > 0 ? 'Ready for your kitchen' : 'Currently unavailable' }}
            </div>

            <div class="purchase-actions">
                <form action="{{ route('security-testing.cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="action" value="add">
                    <button class="button button--outline button--wide" type="submit" {{ (int) ($product['stock'] ?? 0) < 1 ? 'disabled' : '' }}>Add to cart</button>
                </form>
                <form action="{{ route('security-testing.cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="action" value="buy">
                    <button class="button button--primary button--wide" type="submit" {{ (int) ($product['stock'] ?? 0) < 1 ? 'disabled' : '' }}>Buy now</button>
                </form>
            </div>

            <div class="product-perks">
                <div><span aria-hidden="true">◇</span><p><strong>Everyday ready</strong><br>Pieces for real kitchens</p></div>
                <div><span aria-hidden="true">♡</span><p><strong>Picked with care</strong><br>Good details, less fuss</p></div>
            </div>
        </div>
    </section>

    <section class="review-section" id="reviews" aria-labelledby="reviews-title">
        <div class="review-section__heading">
            <div>
                <p class="eyebrow">From the people who cook with it</p>
                <h2 id="reviews-title">Customer reviews</h2>
            </div>
            <div class="review-section__score">
                <strong>{{ number_format((float) $averageRating, 1) }}</strong>
                <span>out of 5<br>{{ count($reviews) }} reviews</span>
            </div>
        </div>

        <div class="review-layout">
            <div class="review-list" id="review-list">
                @forelse ($reviews as $review)
                    <article class="review-card" id="review-{{ $review['id'] }}">
                        <div class="review-card__top">
                            <div>
                                <h3>{!! $review['author'] !!}</h3>
                                <p>{{ $review['created_at'] ?? 'Recently shared' }}</p>
                            </div>
                            <span class="review-card__stars" aria-label="{{ (int) ($review['rating'] ?? 0) }} out of 5 stars">
                                @for ($star = 1; $star <= 5; $star++)
                                    <span class="{{ $star <= (int) ($review['rating'] ?? 0) ? 'is-filled' : '' }}" aria-hidden="true">★</span>
                                @endfor
                            </span>
                        </div>
                        <div class="review-card__body">{!! $review['comment'] !!}</div>
                    </article>
                @empty
                    <div class="empty-state empty-state--reviews">
                        <span class="empty-state__icon" aria-hidden="true">✧</span>
                        <h3>No reviews just yet.</h3>
                        <p>Be the first to share how this piece fits into your kitchen.</p>
                    </div>
                @endforelse
            </div>

            <aside class="review-compose">
                <p class="eyebrow">Your turn</p>
                <h3>Share your experience</h3>
                <p>Tell other home cooks what you think about this kitchen essential.</p>
                <form class="review-form" action="{{ route('security-testing.reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <div class="field">
                        <label for="author">Your name</label>
                        <input id="author" name="author" type="text" placeholder="How should we credit you?" value="{{ data_get(session('security_lab_user', []), 'name', '') }}" required>
                    </div>
                    <div class="field">
                        <label for="rating">Your rating</label>
                        <select id="rating" name="rating" required>
                            <option value="">Choose a rating</option>
                            <option value="5">★★★★★ — Loved it</option>
                            <option value="4">★★★★☆ — Really good</option>
                            <option value="3">★★★☆☆ — It's good</option>
                            <option value="2">★★☆☆☆ — Could be better</option>
                            <option value="1">★☆☆☆☆ — Not for me</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="comment">Your review</label>
                        <textarea id="comment" name="comment" rows="5" placeholder="What did you like? How do you use it?" required></textarea>
                    </div>
                    <button class="button button--primary button--wide" type="submit" id="submit-review">Post review</button>
                </form>
            </aside>
        </div>

        <details class="reset-disclosure">
            <summary>Reset this product's review data</summary>
            <div class="reset-disclosure__body">
                <p>This training action clears the reviews for this product.</p>
                <form action="{{ route('security-testing.reviews.reset') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <button class="button button--danger" type="submit">Clear reviews</button>
                </form>
            </div>
        </details>
    </section>
    @endif
@endsection
