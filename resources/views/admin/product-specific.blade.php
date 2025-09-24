<x-admin-layout>
    @section('title', $product->name . ' - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/product-add.css') }}">
    @endpush

    <div class="add-product-content">
        <h2>Product Details</h2>
        <div class="add-product-grid">

            <!-- LEFT CARD: All product details -->
            <div class="add-product-section add-product-desc">
                <h3>Product Information</h3>

                <div class="quantity-restock-row">
                    <div class="input-group">
                        <label>Product ID</label>
                        <p>{{ $product->product_id }}</p>
                    </div>
                    <div class="input-group">
                        <label>Product Name</label>
                        <p>{{ $product->name }}</p>
                    </div>
                </div>

                <label>Product Description</label>
                <p class="description-text">{{ $product->description }}</p>

                <div class="quantity-restock-row">
                    <div class="input-group">
                        <label>Created At</label>
                        <p>{{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="input-group">
                        <label>Updated At</label>
                        <p>{{ $product->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <h4>Stocks and Pricing</h4>

                <div class="quantity-restock-row">
                    <div class="input-group">
                        <label>Quantity</label>
                        <p>{{ $product->stock_quantity }}</p>
                    </div>
                    <div class="input-group">
                        <label>Restock Level</label>
                        <p>{{ $product->restock_level }}</p>
                    </div>
                </div>

                <div class="quantity-restock-row">
                    <div class="input-group">
                        <label>Price</label>
                        <p>₱ {{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="input-group">

                    </div>
                </div>

                <h4>Category</h4>

                <div class="quantity-restock-row">
                    <div class="input-group">
                        <label>Product Category</label>
                        <p>{{ $product->main_category }}</p>
                    </div>
                    <div class="input-group">
                        @if ($product->category && $product->category->parent_id)
                            <label>Product Sub-Category</label>
                            <p>{{ $product->sub_category }}</p>
                        @endif
                    </div>
                </div>




            </div>

            <!-- RIGHT COLUMN: stack images + reviews -->
            <div class="add-product-right">

                <!-- RIGHT TOP: Image Section -->
                <div class="add-product-section product-image-section">
                    <h3>Product Images</h3>
                    <div class="main-product-image-container">
                        <img id="mainProductImage"
                            src="{{ asset('images/' . ($product->primaryImage?->image_url ?? 'no-image.png')) }}"
                            alt="{{ $product->name }}" class="main-product-image">
                    </div>

                    <div class="product-image-slider" id="productImageSlider">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('images/' . $image->image_url) }}"
                                class="slider-thumb {{ $image->is_primary ? 'selected' : '' }}"
                                onclick="selectImage(this)">
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT BOTTOM: Dynamic Reviews Section -->
                <div class="add-product-section add-product-reviews">
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

                    <!-- Reviews wrapper with scroll -->
                    <div class="reviews-scroll">
                        @forelse ($product->reviews as $review)
                            <div class="review-card">
                                <div class="review-header">
                                    <span>{{ $review->user->getFullName() ?? 'Anonymous' }}</span>
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
                            <p class="text-gray-600">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Image slider functionality
            function selectImage(img) {
                document.getElementById('mainProductImage').src = img.src;
                document.querySelectorAll('.slider-thumb').forEach(function(thumb) {
                    thumb.classList.remove('selected');
                });
                img.classList.add('selected');
            }
        </script>
    @endpush
</x-admin-layout>
