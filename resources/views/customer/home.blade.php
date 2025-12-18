<x-customer-layout>

    @section('title', 'Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
        <style>
            .home-section {
                margin: 60px auto;
                max-width: 1400px;
                padding: 0 50px;
            }

            .section-title {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 25px;
                text-align: left;
                color: #0a143b;
            }

            .carousel-container {
                position: relative;
            }

            .carousel-inner-custom {
                display: flex;
                gap: 25px;
                overflow-x: auto;
                scroll-behavior: smooth;
                padding: 5px;
            }

            .carousel-inner-custom::-webkit-scrollbar {
                display: none;
            }

            /* === Product Card === */
            .card-item {
                flex: 0 0 240px;
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                display: flex;
                flex-direction: column;
                height: 370px;
                /* fixed height */
            }

            .card-item:hover {
                transform: translateY(-6px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            }

            .card-item img {
                width: 100%;
                height: 180px;
                object-fit: cover;
            }

            /* === Card Body === */
            .card-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 12px 10px 14px;
                text-align: center;
            }

            /* === Title & Text === */
            .card-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 6px;
                color: #0a143b;
                line-height: 1.3;
                min-height: 38px;
                /* ensures alignment if names vary */
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* clamp to 2 lines */
                -webkit-box-orient: vertical;
            }

            .card-price {
                color: #212529;
                font-weight: 700;
                margin-bottom: 8px;
                font-size: 1rem;
            }

            .card-date,
            .card-sold {
                font-size: 0.9rem;
                color: #6C757D;
                margin-bottom: 6px;
            }


            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            .buy-btn {
                background-color: #4A8FE7;
                color: white;
                border: none;
                border-radius: 8px;
                padding: 6px 14px;
                font-weight: 600;
                transition: background 0.2s;
            }

            .buy-btn:hover {
                background-color: #3a7ad1;
            }

            .icon-btn {
                background-color: #FF914D;
                color: white;
                border: none;
                border-radius: 8px;
                padding: 6px 10px;
                transition: background 0.2s;
            }

            .icon-btn:hover {
                background-color: #E67E3D;
            }

            .carousel-nav {
                position: absolute;
                top: 45%;
                transform: translateY(-50%);
                background: #ffffff;
                border: none;
                border-radius: 50%;
                width: 38px;
                height: 38px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                cursor: pointer;
                font-size: 1.3rem;
                color: #0a143b;
                transition: background 0.2s;
            }

            .carousel-nav:hover {
                background: #f0f0f0;
            }

            .carousel-prev {
                left: -20px;
            }

            .carousel-next {
                right: -20px;
            }

            /* Hide horizontal scrollbar for all carousels */
            .carousel-inner-custom {
                overflow-x: auto;
                scroll-behavior: smooth;
                -ms-overflow-style: none;
                /* Hide scrollbar in IE and Edge */
                scrollbar-width: none;
                /* Hide scrollbar in Firefox */
            }

            /* Hide scrollbar in Chrome, Safari, and Opera */
            .carousel-inner-custom::-webkit-scrollbar {
                display: none;
            }

            .card-date {
                font-size: 0.9rem;
                color: #6C757D;
                margin-bottom: 10px;
            }

            .card-sold {
                font-size: 0.9rem;
                color: #6C757D;
                margin-bottom: 10px;
            }

            /* === Product Card Buttons Container === */
            .card-item .product-buttons {
                margin-top: auto;
                display: flex;
                gap: 8px;
                width: 100%;
                justify-content: center;
                padding: 6px 4px;
                box-sizing: border-box;
            }

            /* Common button base */
            .card-item .product-buttons button {
                height: 42px;
                border-radius: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                border: none;
                transition: background 0.25s ease, transform 0.2s ease;
            }

            /* === Buy Now Button === */
            .card-item .buy-btn {
                flex: 1;
                min-width: 100px;
                background-color: #4A8FE7;
                color: #fff;
                font-weight: 600;
                font-size: 0.95rem;
            }

            .card-item .buy-btn:hover {
                background-color: #3a7ad1;
                transform: scale(1.03);
            }

            /* === Add to Cart Button === */
            .card-item .add-cart-btn {
                width: 42px;
                background-color: #9EB7E5;
                color: #fff;
            }

            .card-item .add-cart-btn:hover {
                background-color: #7da1d1;
                transform: scale(1.08);
            }

            /* === Wishlist Button === */
            .card-item .wishlist-btn {
                width: 42px;
                background-color: #FF914D;
                color: #fff;
                border-radius: 10px;
            }

            .card-item .wishlist-btn:hover {
                background-color: #E67E3D;
                transform: scale(1.08);
            }

            /* === Wishlist Added State === */
            .card-item .wishlist-btn.added {
                background-color: #E67E3D;
                cursor: default;
                pointer-events: none;
            }

            .card-item .wishlist-btn.added i {
                stroke: #fff;
                fill: #fff;
            }

            /* === Icon Sizes === */
            .card-item .add-cart-btn i,
            .card-item .wishlist-btn i {
                width: 20px;
                height: 20px;
                stroke-width: 2;
            }

            /* === CATEGORY CARD === */
            .category-card {
                flex: 0 0 200px;
                background: #ffffff;
                border-radius: 18px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                cursor: pointer;
                height: 270px;
            }

            .category-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            }

            /* Category image */
            .category-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
                border-bottom: 1px solid #f1f1f1;
            }

            /* Category body */
            .category-card .card-body {
                padding: 12px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            /* Category title */
            .category-card .card-title {
                font-size: 1rem;
                font-weight: 700;
                color: #0a143b;
                margin-top: 6px;
                margin-bottom: 6px;
                line-height: 1.3;
            }

            /* Parent category badge */
            .category-card .parent-badge {
                display: inline-block;
                background: #4A8FE7;
                color: #fff;
                font-size: 0.8rem;
                padding: 4px 10px;
                border-radius: 20px;
                font-weight: 500;
                margin-top: 4px;
            }

            /* Hover accent for badge */
            .category-card:hover .parent-badge {
                background: #3a7ad1;
            }



            /* Responsive adjustments */
            @media (max-width: 768px) {
                .category-card {
                    flex: 0 0 160px;
                    height: 240px;
                }

                .category-card img {
                    height: 130px;
                }

                .category-card .card-title {
                    font-size: 0.9rem;
                }
            }

            .product-link {
                text-decoration: none;
                color: inherit;
                display: block;
            }

            .category-link {
                text-decoration: none;
                color: inherit;
                display: block;
            }




            /* === Responsive Design === */
            @media (max-width: 992px) {
                .home-section {
                    padding: 0 25px;
                }

                .card-item {
                    flex: 0 0 200px;
                }

                .section-title {
                    text-align: center;
                }
            }

            @media (max-width: 576px) {
                .card-item {
                    flex: 0 0 160px;
                }

                .card-item img {
                    height: 140px;
                }

                .carousel-nav {
                    display: none;
                }
            }
        </style>
    @endpush

    @guest
        <div class="hero-section">
            <div class="heroGrid">
                <div class="heroImageCol">
                    <img src="{{ asset('Assets/heroPlate.png') }}" alt="hero header image" class="heroImage">
                </div>
                <div class="heroTextCol">
                    <h1 class="heroTitle">{{ $heroGuest->title ?? 'WELCOME TO' }}</h1>
                    <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="" class="heroLogo">
                    <p class="heroSubtitle">
                        {{ $heroGuest->content ?? '' }}
                    </p>
                </div>
                <div class="shopNow">
                    <a href="{{ route('customer.products') }}" class="shop-now-btn">Shop Now</a>
                </div>
            </div>
        </div>
    @endguest

    @auth
        <div class="hero-section" style="padding-top: 150px;">
            <div class="heroGrid">
                <div class="heroTextCol">
                    <h1 class="heroTitle" style="font-size: 40px; font-weight: 800;">
                        {{ $heroAuth->title ?? 'WELCOME BACK,' }}
                        {{ trim(Auth::user()->first_name . ' ' . Auth::user()->last_name) ?: 'Customer' }}!
                    </h1>
                    <p class="heroSubtitle">
                        {{ $heroAuth->content ?? '' }}
                    </p>
                    <div class="shopNow">
                        <a href="{{ route('customer.products') }}" class="shop-now-btn">Start Shopping</a>
                    </div>
                </div>
                <div class="heroImageCol">
                    <img src="{{ asset('Assets/heroPlate.png') }}" alt="hero header image" class="heroImage">
                </div>
            </div>
        </div>
    @endauth



    <div class="promo-carousel">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse ($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        @if ($banner->link)
                            <a href="{{ $banner->link }}">
                                <img class="d-block w-100" src="{{ asset($banner->image) }}"
                                    alt="{{ $banner->title }}">
                            </a>
                        @else
                            <img class="d-block w-100" src="{{ asset($banner->image) }}" alt="{{ $banner->title }}">
                        @endif
                    </div>
                @empty
                    {{-- Default fallback slides if no banners exist --}}
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('Assets/timplatoLandingBanner.png') }}"
                            alt="Default banner">
                    </div>
                @endforelse
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    {{-- ===== CATEGORY SLIDER ===== --}}
    <section class="home-section">
        <h2 class="section-title">Shop by Category</h2>
        <div class="carousel-container position-relative">
            <button class="carousel-nav carousel-prev" onclick="scrollCarousel('category-carousel', -1)">‹</button>
            <div class="carousel-inner-custom" id="category-carousel">
                @foreach ($categories as $category)
                    <div class="category-card">
                        <a href="{{ route('customer.products', [
                            'search' => '',
                            'category' => $category->name,
                            'min_price' => '',
                            'max_price' => '',
                            'sort_name' => '',
                            'sort_price' => '',
                            'sort_date' => '',
                        ]) }}"
                            class="category-link">
                            @php
                                // Check if this is a main category (has children)
                                if ($category->children->isNotEmpty()) {
                                    // Get the first subcategory
                                    $firstSubcategory = $category->children->first();

                                    // Get the last product under that subcategory (with images)
                                    $lastProduct = $firstSubcategory
                                        ->products()
                                        ->with('images')
                                        ->latest('product_id')
                                        ->first();

                                    // Get the primary image of that product
                                    $primaryImage = $lastProduct
                                        ? $lastProduct->images->where('is_primary', 1)->first()
                                        : null;
                                } else {
                                    // For subcategories (no children), get the first product directly
                                    $firstProduct = $category->products()->with('images')->first();
                                    $primaryImage = $firstProduct
                                        ? $firstProduct->images->where('is_primary', 1)->first()
                                        : null;
                                }
                            @endphp

                            <img src="{{ $primaryImage ? asset('images/' . $primaryImage->image_url) : asset('Assets/timplatoLandingBanner.png') }}"
                                alt="{{ $category->name }}">

                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                @if ($category->parent)
                                    <span class="parent-badge">{{ $category->parent->name }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="carousel-nav carousel-next" onclick="scrollCarousel('category-carousel', 1)">›</button>
        </div>
    </section>



    {{-- ===== BEST SELLERS ===== --}}
    <section class="home-section">
        <h2 class="section-title">Best Sellers</h2>
        <div class="carousel-container position-relative">
            <button class="carousel-nav carousel-prev" onclick="scrollCarousel('best-sellers', -1)">‹</button>
            <div class="carousel-inner-custom" id="best-sellers">
                @foreach ($bestSellers as $product)
                    @php
                        $primaryImage = $product->images->where('is_primary', 1)->first();
                    @endphp
                    <div class="card-item">
                        <a href="{{ route('customer.specific-product', $product) }}" class="product-link">
                            <img src="{{ $primaryImage ? asset('images/' . $primaryImage->image_url) : asset('images/no-image.png') }}"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-price">₱{{ number_format($product->price, 2) }}</p>
                                <p class="card-sold">Sold: {{ $product->sold ?? 0 }}</p>
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
                                        <button type="submit" class="icon-btn">
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
                                        <button type="submit" class="icon-btn {{ $isInWishlist ? 'added' : '' }}"
                                            title="{{ $isInWishlist ? 'Already in Wishlist' : 'Add to Wishlist' }}"
                                            {{ $isInWishlist ? 'disabled' : '' }}>
                                            <i data-lucide="heart" class="{{ $isInWishlist ? 'filled' : '' }}"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="carousel-nav carousel-next" onclick="scrollCarousel('best-sellers', 1)">›</button>
        </div>
    </section>

    {{-- ===== NEW ARRIVALS ===== --}}
    <section class="home-section">
        <h2 class="section-title">New Arrivals</h2>
        <div class="carousel-container position-relative">
            <button class="carousel-nav carousel-prev" onclick="scrollCarousel('new-arrivals', -1)">‹</button>
            <div class="carousel-inner-custom" id="new-arrivals">
                @foreach ($newArrivals as $product)
                    @php
                        $primaryImage = $product->images->where('is_primary', 1)->first();
                    @endphp
                    <div class="card-item">
                        <a href="{{ route('customer.specific-product', $product) }}" class="product-link">

                            <img src="{{ $primaryImage ? asset('images/' . $primaryImage->image_url) : asset('images/no-image.png') }}"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-price">₱{{ number_format($product->price, 2) }}</p>
                                <p class="card-date">Added on {{ $product->created_at->format('M d, Y') }}</p>
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
                                        <button type="submit" class="icon-btn">
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
                                        <button type="submit" class="icon-btn {{ $isInWishlist ? 'added' : '' }}"
                                            title="{{ $isInWishlist ? 'Already in Wishlist' : 'Add to Wishlist' }}"
                                            {{ $isInWishlist ? 'disabled' : '' }}>
                                            <i data-lucide="heart" class="{{ $isInWishlist ? 'filled' : '' }}"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
            <button class="carousel-nav carousel-next" onclick="scrollCarousel('new-arrivals', 1)">›</button>
        </div>
    </section>



    @push('scripts')
        <script>
            function scrollCarousel(id, direction) {
                const carousel = document.getElementById(id);
                const scrollAmount = 300;
                carousel.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        </script>
    @endpush

</x-customer-layout>
