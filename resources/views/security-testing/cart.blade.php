@extends('security-testing.layout')

@section('title', 'Your cart | Timplato')

@section('content')
    <section class="page-intro page-intro--compact">
        <p class="eyebrow">Your kitchen edit</p>
        <h1>Shopping cart</h1>
        <p>Take a last look at the pieces you picked. Your everyday favorites are just a step away.</p>
    </section>

@if (isset($feedback) || session()->has('feedback') || ($queryError ?? false))
    <div class="notice {{ ($queryError ?? false) ? 'notice--error' : '' }} cart-feedback" role="status">{{ $feedback ?? $message ?? session('feedback') ?? $queryError }}</div>
@endif
    <section class="cart-layout" aria-label="Shopping cart">
        <div class="cart-items">
            @forelse ($items as $item)
                <article class="cart-item" id="cart-item-{{ $item['id'] }}">
                    <a class="cart-item__image" href="{{ route('security-testing.product', ['id' => $item['id']]) }}">
                        <img src="{{ asset($item['image'] ?: 'images/products/4piece_plate_set_1.jpg') }}" alt="{{ $item['name'] }}">
                    </a>
                    <div class="cart-item__details">
                        <p class="product-card__category">{{ $item['category'] ?? 'Kitchen essentials' }}</p>
                        <h2><a href="{{ route('security-testing.product', ['id' => $item['id']]) }}">{{ $item['name'] }}</a></h2>
                        <p class="cart-item__description">{{ $item['description'] ?? 'Made for the moments that happen every day.' }}</p>
                        <div class="quantity-actions" aria-label="Cart actions for {{ $item['name'] }}">
                            <form action="{{ route('security-testing.cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" aria-label="Remove {{ $item['name'] }} from cart">×</button>
                            </form>
                            <span aria-live="polite">{{ $item['quantity'] }}</span>
                            <form action="{{ route('security-testing.cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" aria-label="Add one {{ $item['name'] }}">+</button>
                            </form>
                        </div>
                    </div>
                    <strong class="cart-item__price">₱{{ number_format((float) $item['price'] * (int) $item['quantity'], 2) }}</strong>
                </article>
            @empty
                <div class="empty-state">
                    <span class="empty-state__icon" aria-hidden="true">♡</span>
                    <h2>Your cart is waiting for something lovely.</h2>
                    <p>Take a look around and find a few things that make everyday cooking easier.</p>
                    <a class="button button--primary" href="{{ route('security-testing.products') }}">Explore the shop</a>
                </div>
            @endforelse
        </div>

        <aside class="cart-summary" aria-labelledby="summary-title">
            <p class="eyebrow">Almost yours</p>
            <h2 id="summary-title">Order summary</h2>
            <div class="summary-row"><span>Items</span><span>{{ collect($items)->sum('quantity') }}</span></div>
            <div class="summary-row"><span>Delivery</span><span class="summary-muted">Calculated at checkout</span></div>
            <div class="summary-row summary-row--total"><span>Subtotal</span><strong>₱{{ number_format((float) $total, 2) }}</strong></div>
            <p class="summary-note">Delivery options and payment are part of this training storefront.</p>
            <form action="{{ route('security-testing.cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $items[0]['id'] ?? 0 }}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="action" value="checkout">
                <button class="button button--primary button--wide" type="submit" {{ empty($items) ? 'disabled' : '' }}>Continue to checkout</button>
            </form>
            <a class="cart-continue" href="{{ route('security-testing.products') }}">← Continue shopping</a>
        </aside>
    </section>
@endsection
