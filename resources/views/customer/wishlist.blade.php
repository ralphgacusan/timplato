<x-customer-layout>

    @section('title', 'Wishlist - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/wishlist.css') }}">
    @endpush

    <div class="wishlist-container">
        <!-- Heading -->
        <h1 class="wishlist-heading">My Wishlist</h1>

        <div class="wishlist-list">
            @forelse($wishlistItems as $item)
                <a href="{{ route('customer.specific-product', $item->product->product_id) }}" class="wishlist-item-link">
                    <div class="wishlist-item">
                        <img src="{{ $item->product->images->where('is_primary', 1)->first()
                            ? asset('images/' . $item->product->images->where('is_primary', 1)->first()->image_url)
                            : asset('images/no-image.png') }}"
                            alt="{{ $item->product->name }}" class="wishlist-img">

                        <div class="wishlist-info">
                            <div class="wishlist-title">{{ $item->product->name }}</div>
                            <div class="wishlist-desc">{{ $item->product->description ?? 'No description available' }}
                            </div>
                            <span class="wishlist-price">₱{{ number_format($item->product->price, 2) }}</span>
                        </div>

                        <div class="wishlist-actions">
                            {{-- <form action="{{ route('customer.add-to-cart', $item->product->product_id) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="wishlist-cart-btn">Add to Cart</button>
                            </form> --}}

                            <form action="{{ route('customer.wishlist.remove', $item->product->product_id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="wishlist-remove-btn">Remove</button>
                            </form>
                        </div>
                    </div>
                </a>
                <hr>
            @empty
                <p>No products in your wishlist.</p>
            @endforelse
        </div>

    </div>

</x-customer-layout>
