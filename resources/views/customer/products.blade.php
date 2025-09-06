<x-customer-layout>

    @section('title', 'Products - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/products.css') }}">
    @endpush

    <div class="main-content">
        <!-- Product Search Bar -->
        <div class="product-search-bar">
            <input type="text" id="searchInput" placeholder="Search">
            <select id="categorySelect">
                <option value="">Category</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <select id="orderSelect">
                <option value="">Sort by</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="name">Name</option>
            </select>
            <button onclick="filterProducts()">Search</button>
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
                                <button class="buy-btn">Buy Now</button>
                                <button class="add-cart-btn"><i data-lucide="shopping-cart"></i></button>
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
