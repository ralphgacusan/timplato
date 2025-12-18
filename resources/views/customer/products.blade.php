<x-customer-layout>

    @section('title', 'Products - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/products.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <div class="main-content">

        <!-- Top Search Bar -->
        {{-- <div class="top-search-bar">
            <form action="{{ route('customer.products') }}" method="GET" class="d-flex">
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div> --}}

        <div class="products-page">
            <!-- Product Search and Filter Bar -->
            <div class="product-search-bar" style="width: 100%; margin-bottom: 16px;">

                <aside class="filters-sidebar">
                    <form id="filterForm" action="{{ route('customer.products') }}" method="GET">

                        <!-- Search Bar at top -->
                        <div class="sidebar-search-bar">
                            <input type="text" name="search" placeholder="Search products..."
                                value="{{ request('search') }}">
                        </div>

                        <!-- Main Categories -->
                        <div class="filter-group">
                            <h4>Main Categories</h4>
                            @foreach (\App\Models\Category::whereNull('parent_id')->get() as $mainCategory)
                                <div>
                                    <label>
                                        <input type="checkbox" name="main_category[]" value="{{ $mainCategory->name }}"
                                            {{ is_array(request('main_category')) && in_array($mainCategory->name, request('main_category')) ? 'checked' : '' }}>
                                        {{ $mainCategory->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Sub Categories -->
                        <div class="filter-group">
                            <h4>Sub Categories</h4>
                            @foreach (\App\Models\Category::whereNotNull('parent_id')->get() as $subCategory)
                                <div>
                                    <label>
                                        <input type="checkbox" name="sub_category[]" value="{{ $subCategory->name }}"
                                            {{ is_array(request('sub_category')) && in_array($subCategory->name, request('sub_category')) ? 'checked' : '' }}>
                                        {{ $subCategory->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price -->
                        <div class="filter-group">
                            <h4>Price</h4>
                            <input type="number" name="min_price" placeholder="Min ₱"
                                value="{{ request('min_price') }}" min="0">
                            <input type="number" name="max_price" placeholder="Max ₱"
                                value="{{ request('max_price') }}" min="0">
                        </div>

                        <!-- Sort -->
                        <div class="filter-group">
                            <h4>Sort By</h4>
                            <select name="sort_name" onchange="autoSubmit()">
                                <option value="">Name</option>
                                <option value="az" {{ request('sort_name') == 'az' ? 'selected' : '' }}>A–Z
                                </option>
                                <option value="za" {{ request('sort_name') == 'za' ? 'selected' : '' }}>Z–A
                                </option>
                            </select>

                            <select name="sort_price" onchange="autoSubmit()">
                                <option value="">Price</option>
                                <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>Low–High
                                </option>
                                <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>High–Low
                                </option>
                            </select>

                            <select name="sort_date" onchange="autoSubmit()">
                                <option value="">Date</option>
                                <option value="newest" {{ request('sort_date') == 'newest' ? 'selected' : '' }}>Newest
                                </option>
                                <option value="oldest" {{ request('sort_date') == 'oldest' ? 'selected' : '' }}>Oldest
                                </option>
                            </select>

                            <!-- New: Sort by Rating -->
                            <select name="sort_rating" onchange="autoSubmit()">
                                <option value="">Rating</option>
                                <option value="desc" {{ request('sort_rating') == 'desc' ? 'selected' : '' }}>Highest
                                    First</option>
                                <option value="asc" {{ request('sort_rating') == 'asc' ? 'selected' : '' }}>Lowest
                                    First</option>
                            </select>

                            <!-- New: Sort by Sold -->
                            <select name="sort_sold" onchange="autoSubmit()">
                                <option value="">Sold</option>
                                <option value="desc" {{ request('sort_sold') == 'desc' ? 'selected' : '' }}>Most Sold
                                </option>
                                <option value="asc" {{ request('sort_sold') == 'asc' ? 'selected' : '' }}>Least Sold
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="apply-filters-btn">Apply Filters</button>
                        <a href="{{ route('customer.products') }}" class="clear-filters-btn">Reset Filters</a>
                    </form>
                </aside>


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
                                            ? auth()
                                                ->user()
                                                ->wishlistItems->contains('product_id', $product->product_id)
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

        </div>
        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $products->appends(request()->only(['search', 'category', 'sort']))->links('pagination::bootstrap-5') }}
        </div>


        <script>
            let timer;

            function autoSubmit() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            }
        </script>

    </div>

</x-customer-layout>
