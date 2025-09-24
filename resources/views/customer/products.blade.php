<x-customer-layout>

    @section('title', 'Products - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/products.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <div class="main-content">
        <!-- Product Search Bar -->
        <div class="product-search-bar">
            <form action="{{ route('customer.products') }}" method="GET" style="display: flex; width: 100%; gap: 16px;">

                {{-- Sort By --}}
                <select name="sort" class="pm-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price (Low-High)
                    </option>
                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price (High-Low)
                    </option>
                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date Added (Newest)
                    </option>
                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date Added (Oldest)
                    </option>
                </select>

                {{-- Category --}}
                <select name="category" class="pm-category" onchange="this.form.submit()">
                    <option value="">Category</option>
                    @foreach (\App\Models\Category::whereNull('parent_id')->get() as $mainCategory)
                        <option value="{{ $mainCategory->name }}"
                            {{ request('category') == $mainCategory->name ? 'selected' : '' }}>
                            {{ $mainCategory->name }}
                        </option>
                        @foreach ($mainCategory->children as $subCategory)
                            <option value="{{ $subCategory->name }}"
                                {{ request('category') == $subCategory->name ? 'selected' : '' }}>
                                └ {{ $subCategory->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                {{-- Search --}}
                <input type="text" name="search" class="pm-search" placeholder="Search"
                    value="{{ request('search') }}">
                <button type="submit" class="pm-add-btn">Search</button>
            </form>
        </div>

        <!-- Product Cards Container -->
        <div class="products-container" id="productsContainer">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <a href="{{ route('customer.specific-product', $product) }}" class="link">
                        <div class="product-card">
                            <div class="product-image-container">
                                @php
                                    $primaryImage = $product->images->where('is_primary', 1)->first();
                                @endphp
                                <img src="{{ $primaryImage ? asset('images/' . $primaryImage->image_url) : asset('images/no-image.png') }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
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
                                        <i data-lucide="shopping-cart"></i>
                                    </button>
                                </form>

                                <!-- Wishlist -->
                                @php
                                    $isInWishlist = auth()->check()
                                        ? auth()->user()->wishlistItems->contains('product_id', $product->product_id)
                                        : false;
                                @endphp

                                <form action="{{ route('customer.wishlist.add', $product) }}" method="POST"
                                    class="wishlist-form">
                                    @csrf
                                    <button type="submit" class="wishlist-btn {{ $isInWishlist ? 'added' : '' }}"
                                        title="{{ $isInWishlist ? 'Already in Wishlist' : 'Add to Wishlist' }}"
                                        {{ $isInWishlist ? 'disabled' : '' }}>
                                        <i data-lucide="heart" class="{{ $isInWishlist ? 'filled' : '' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <p>No products available.</p>
            @endif
        </div>
        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $products->appends(request()->only(['search', 'category', 'sort']))->links('pagination::bootstrap-5') }}
        </div>
    </div>

</x-customer-layout>
