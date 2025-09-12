<x-customer-layout>

    @section('title', 'Product Detail - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/specific-product.css') }}">
    @endpush

    <div class="product-page-container">
        <!-- Image Section -->
        <div class="product-image-section">
            <div class="main-product-image-container">
                <img id="mainProductImage"
                    src="{{ asset('images/' . ($product->primaryImage?->image_url ?? 'no-image.png')) }}"
                    alt="{{ $product->name }}" class="main-product-image">
            </div>

            <div class="product-image-slider" id="productImageSlider">
                @foreach ($product->images as $image)
                    <img src="{{ asset('images/' . $image->image_url) }}"
                        class="slider-thumb {{ $image->is_primary ? 'selected' : '' }}" onclick="selectImage(this)">
                @endforeach
            </div>
        </div>

        <!-- Details Section -->
        <div class="product-details-section">
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-brand">
                {{ $product->category->name ?? 'No Category' }} &nbsp;|&nbsp; ID: {{ $product->product_id }}
            </div>
            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#189; &nbsp; 4.5 | 2017 Reviews</div>
            <div class="product-price">₱{{ number_format($product->price, 2) }}</div>

            <!-- Stock Info -->
            <div class="product-stock">
                {{-- TO FIX DISPLAY SOLD FEAUTURE --}}
                <span>Sold: {{ $product->sold_quantity ?? 0 }}</span> |
                <span>Left: {{ $product->stock_quantity }}</span> |
                <span class="stock-status {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            <!-- Product Description -->
            <div class="product-description">
                <h4>Description</h4>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Quantity Section -->
            <div class="quantity-section">
                <span>Quantity</span>
                <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                <span class="quantity-value" id="quantityValue">1</span>
                <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
            </div>

            <!-- Action Buttons -->
            <div class="product-buttons">
                <!-- Buy Now Form -->
                <form action="{{ route('customer.checkout.buyNow', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="buy-btn">Buy Now</button>
                </form>

                <!-- Add to Cart Form -->
                <form action="{{ route('customer.add-to-cart', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-cart-btn">
                        <i data-lucide="shopping-cart"></i> <span>Add to Cart</span>
                    </button>
                </form>

                @php
                    $isInWishlist = auth()->check()
                        ? auth()->user()->wishlistProducts->contains($product->product_id)
                        : false;
                @endphp



                <form action="{{ route('customer.wishlist.add', $product) }}" method="POST" class="wishlist-form">
                    @csrf
                    <button type="submit" class="wishlist-btn {{ $isInWishlist ? 'added' : '' }}"
                        title="{{ $isInWishlist ? 'Already in Wishlist' : 'Add to Wishlist' }}"
                        {{ $isInWishlist ? 'disabled' : '' }}>
                        <i data-lucide="heart" class="{{ $isInWishlist ? 'filled' : '' }}"></i>
                        <span
                            class="wishlist-text">{{ $isInWishlist ? 'Added to Wishlist' : 'Add to Wishlist' }}</span>
                    </button>
                </form>


            </div>


        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h3>Customer Reviews ({{ $totalReviews }})</h3>

        @if ($totalReviews > 0)
            <div class="rating-summary mb-4">
                <span class="rating-average">
                    {{ number_format($averageRating, 1) }} / 5
                </span>
                <span class="rating-stars">
                    {!! str_repeat('&#9733;', floor($averageRating)) !!}
                    @if ($averageRating - floor($averageRating) >= 0.5)
                        &#189; {{-- half star --}}
                    @endif
                    {!! str_repeat('&#9734;', 5 - ceil($averageRating)) !!}
                </span>
            </div>
        @endif

        @forelse ($product->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    {{ $review->user->getFullName() ?? 'Anonymous' }}
                    <span class="review-stars">
                        {!! str_repeat('&#9733;', $review->rating) !!}
                        {!! str_repeat('&#9734;', 5 - $review->rating) !!}
                    </span>
                </div>
                <div class="review-body">
                    {{ $review->comment ?? 'No comment provided.' }}
                </div>
                <div class="review-date">
                    Reviewed on {{ $review->created_at->format('F j, Y') }}
                </div>
            </div>
        @empty
            <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
        @endforelse
    </div>


    <script>
        // Image slider
        function selectImage(img) {
            document.getElementById('mainProductImage').src = img.src;
            document.querySelectorAll('.slider-thumb').forEach(function(thumb) {
                thumb.classList.remove('selected');
            });
            img.classList.add('selected');
        }

        let quantity = 1;

        function changeQuantity(val) {
            quantity += val;
            if (quantity < 1) quantity = 1;

            // Update display
            document.getElementById('quantityValue').textContent = quantity;

            // Update hidden input
            document.getElementById('quantityInput').value = quantity;
        }
    </script>

</x-customer-layout>
