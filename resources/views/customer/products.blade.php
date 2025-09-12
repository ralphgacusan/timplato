<x-customer-layout>

    @section('title', 'Products - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/products.css') }}">
    @endpush

    <div class="main-content">
        <!-- Product Search Bar -->
        <!-- Product Search Bar -->
        <div class="product-search-bar">
            <form action="{{ route('customer.filter-products') }}" method="GET"
                style="display: flex; width: 100%; gap: 16px;">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">

                <select name="category">
                    <option value="" {{ old('category', request('category')) === '' ? 'selected' : '' }}>Category
                    </option>
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->category_id }}"
                            {{ (string) old('category', request('category')) === (string) $category->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>






                <select name="sort">
                    <option value="">Sort by</option>
                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price: Low to High
                    </option>
                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to
                        Low</option>
                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Newest First
                    </option>
                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Oldest First
                    </option>
                </select>

                <button type="submit">Search</button>
            </form>
        </div>


        <!-- Product Cards Container -->
        <div class="products-container" id="productsContainer">
            @if (isset($products) && $products->count() > 0)
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

                                <!-- Dynamic Wishlist Button -->
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
                <p>{{ $message ?? 'No products available.' }}</p>
            @endif
        </div>
    </div>

</x-customer-layout>
