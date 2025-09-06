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
                {{ $product->category->name ?? 'No Category' }} &nbsp;|&nbsp; SKU: {{ $product->id }}
            </div>
            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#189; &nbsp; 4.5 | 2017 Reviews</div>
            <div class="product-price">₱{{ number_format($product->price, 2) }}</div>

            <!-- Stock Info -->
            <div class="product-stock">
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
                <button class="buy-btn">Buy Now</button>
                <button class="add-cart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#fff"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 6h15l-1.68 8.39a2 2 0 0 1-1.97 1.61H8.65a2 2 0 0 1-1.97-1.61L5 6z" />
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                    </svg>
                    <span>Add to Cart</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews Section (dummy) -->
    <div class="reviews-section">
        <h3>Customer Reviews (9)</h3>
        <div class="review-card">
            <div class="review-name">John D.</div>
            <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <div class="review-body">Excellent pans! Nonstick works perfectly and easy to clean.</div>
        </div>
        <div class="review-card">
            <div class="review-name">Jane S.</div>
            <div class="review-stars">&#9733;&#9733;&#9733;&#9733;</div>
            <div class="review-body">Good quality but a bit pricey. Overall very satisfied.</div>
        </div>
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

        // Quantity
        let quantity = 1;

        function changeQuantity(val) {
            quantity += val;
            if (quantity < 1) quantity = 1;
            document.getElementById('quantityValue').textContent = quantity;
        }
    </script>

</x-customer-layout>
