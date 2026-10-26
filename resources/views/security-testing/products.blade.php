@extends('security-testing.layout')

@section('title', 'Kitchen essentials | Timplato')

@section('content')
    @if ($queryError ?? false)
        <div class="notice notice--error shop-query-error" role="alert">{{ $queryError }}</div>
    @endif
    <section class="shop-hero">
        <div class="shop-hero__copy">
            <p class="eyebrow">The Timplato kitchen edit</p>
            <h1>Small details.<br>Better everyday meals.</h1>
            <p>Useful, beautiful essentials for everything from quick breakfasts to long Sunday lunches.</p>
            <a class="button button--light" href="#product-grid">Explore the collection <span aria-hidden="true">↓</span></a>
        </div>
        <div class="shop-hero__note">
            <span class="shop-hero__sparkle" aria-hidden="true">✳</span>
            <span>Considered tools<br>for everyday cooking</span>
        </div>
    </section>

    <section class="shop-section" aria-labelledby="collection-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Find your next favorite</p>
                <h2 id="collection-title">Kitchen essentials</h2>
            </div>
            <label class="search-box" for="product-search">
                <span aria-hidden="true">⌕</span>
                <input id="product-search" type="search" placeholder="Search the collection" autocomplete="off">
            </label>
        </div>

        <div class="collection-meta">
            <p><span id="product-count">{{ count($products) }}</span> pieces to make home cooking feel good</p>
            <span>Thoughtfully picked · Everyday prices</span>
        </div>

        <div class="product-grid" id="product-grid">
            @forelse ($products as $product)
                <article class="product-card" id="product-card-{{ $product['id'] }}" data-product-name="{{ strtolower($product['name']) }}" data-product-category="{{ strtolower($product['category'] ?? '') }}">
                    <a class="product-card__image-link" href="{{ route('security-testing.product', ['id' => $product['id']]) }}" aria-label="View {{ $product['name'] }}">
                        <div class="product-card__image-wrap">
                            @if (!empty($product['category']))
                                <span class="product-card__tag">{{ $product['category'] }}</span>
                            @endif
                            <img class="product-card__image" src="{{ asset($product['image'] ?: 'images/products/4piece_plate_set_1.jpg') }}" alt="{{ $product['name'] }}" loading="lazy">
                        </div>
                    </a>
                    <div class="product-card__content">
                        <p class="product-card__category">{{ $product['category'] ?? 'Kitchen essentials' }}</p>
                        <h3><a href="{{ route('security-testing.product', ['id' => $product['id']]) }}">{{ $product['name'] }}</a></h3>
                        <p class="product-card__description">{{ $product['description'] ?? 'A practical favorite, ready for the everyday.' }}</p>
                        <div class="product-card__bottom">
                            <span class="product-price">₱{{ number_format((float) ($product['price'] ?? 0), 2) }}</span>
                            <span class="stock-note">{{ (int) ($product['stock'] ?? 0) > 0 ? 'In stock' : 'Sold out' }}</span>
                        </div>
                        <div class="product-card__actions">
                            <a class="button button--outline" href="{{ route('security-testing.product', ['id' => $product['id']]) }}">View details</a>
                            <form action="{{ route('security-testing.cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="action" value="add">
                                <button class="button button--primary" type="submit" id="add-to-cart-{{ $product['id'] }}" {{ (int) ($product['stock'] ?? 0) < 1 ? 'disabled' : '' }}>
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state empty-state--wide">
                    <span class="empty-state__icon" aria-hidden="true">✳</span>
                    <h3>The shelves are taking a little break.</h3>
                    <p>Check back soon for more kitchen favorites.</p>
                </div>
            @endforelse
        </div>
        <p class="search-empty" id="search-empty" hidden>No pieces match that search. Try another name or category.</p>
    </section>

    <section class="shop-callout">
        <span class="shop-callout__icon" aria-hidden="true">✦</span>
        <div>
            <p class="eyebrow">A little care goes a long way</p>
            <h2>Make room for the moments that matter.</h2>
            <p>Explore reliable pieces designed to make your kitchen feel a little more like home.</p>
        </div>
        <a class="button button--outline" href="{{ route('security-testing.cart') }}">Visit your cart</a>
    </section>

    <script>
        (() => {
            const search = document.getElementById('product-search');
            const cards = Array.from(document.querySelectorAll('.product-card'));
            const count = document.getElementById('product-count');
            const empty = document.getElementById('search-empty');
            if (!search) return;
            search.addEventListener('input', () => {
                const query = search.value.trim().toLocaleLowerCase();
                let visible = 0;
                cards.forEach(card => {
                    const match = (card.dataset.productName + ' ' + card.dataset.productCategory).includes(query);
                    card.hidden = !match;
                    if (match) visible += 1;
                });
                count.textContent = visible.toString();
                empty.hidden = visible > 0 || cards.length === 0;
            });
        })();
    </script>
@endsection
