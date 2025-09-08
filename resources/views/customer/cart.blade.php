<x-customer-layout>
    @section('title', 'Cart - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/cart.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <div class="cart-main-container">

        <!-- Cart Products -->
        <div class="cart-products-section">
            @if ($cart->items->count() > 0)
                @foreach ($cart->items as $item)
                    <div class="cart-product-card">
                        <div class="cart-product-img">
                            <img src="{{ $item->product->primaryImage ? asset('images/' . $item->product->primaryImage->image_url) : asset('images/no-image.png') }}"
                                alt="{{ $item->product->name }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                        </div>
                        <div class="cart-product-details">
                            <div class="cart-product-title">{{ $item->product->name }}</div>
                            <div class="cart-product-subtitle">{{ Str::limit($item->product->description, 30) }}</div>
                            <div class="cart-product-price">₱{{ number_format($item->product->price, 2) }}</div>

                            <div class="cart-qty-row">
                                <button class="cart-qty-btn cart-qty-minus"
                                    data-id="{{ $item->cart_item_id }}">-</button>
                                <span class="cart-qty-value"
                                    id="qty-{{ $item->cart_item_id }}">{{ $item->quantity }}</span>
                                <button class="cart-qty-btn cart-qty-plus"
                                    data-id="{{ $item->cart_item_id }}">+</button>
                                <span class="cart-qty-total"
                                    id="total-{{ $item->cart_item_id }}">₱{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </div>

                            <div class="cart-actions-row">
                                {{-- {{ route('customer.remove-cart-item', $item->cart_item_id) }} --}}
                                <form class="cart-remove-form" data-id="{{ $item->cart_item_id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><span
                                            class="icon-trash"></span> Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Your cart is empty.</p>
            @endif
        </div>

        <!-- Cart Summary -->
        <div class="cart-summary-section">
            <div class="cart-summary-title">Cart Totals:</div>
            <div class="cart-summary-row">
                Subtotal: <span
                    class="cart-summary-value">₱{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</span>
            </div>
            <div class="cart-summary-row">Delivery: <span class="cart-summary-value">FREE</span></div>
            <hr>
            {{-- <div class="cart-summary-row">
                <input type="text" class="cart-coupon-input" placeholder="Coupon/Voucher">
                <button class="cart-coupon-btn btn btn-secondary">Add</button>
            </div>
            <div class="cart-summary-row">
                Discount: <span class="cart-summary-value">₱0.00</span>
            </div> --}}
            <div class="cart-summary-row cart-summary-total">
                Order Total: <span
                    class="cart-summary-value">₱{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</span>
            </div>
            <!-- Checkout button -->
            <div class="cart-checkout-row">
                <a href="{{ route('customer.checkout') }}" class="cart-checkout-btn btn btn-primary">CHECKOUT</a>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.cart-qty-btn').click(function(e) {
                    e.preventDefault();

                    let cartItemId = $(this).data('id');
                    let action = $(this).hasClass('cart-qty-plus') ? 'increase' : 'decrease';

                    $.ajax({
                        url: '/cart/update-quantity/' + cartItemId,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            action: action
                        },
                        success: function(response) {
                            // Update quantity and total in UI
                            $('#qty-' + cartItemId).text(response.quantity);
                            $('#total-' + cartItemId).text('₱' + response.total);

                            // Update cart subtotal and order total
                            let subtotal = 0;
                            $('.cart-qty-total').each(function() {
                                subtotal += parseFloat($(this).text().replace('₱', '')
                                    .replace(/,/g, ''));
                            });
                            $('.cart-summary-value').first().text('₱' + subtotal.toLocaleString(
                                'en-US', {
                                    minimumFractionDigits: 2
                                }));
                            $('.cart-summary-total .cart-summary-value').text('₱' + subtotal
                                .toLocaleString('en-US', {
                                    minimumFractionDigits: 2
                                }));
                        }
                    });
                });
            });

            $(document).ready(function() {
                // Remove cart item
                $('.cart-remove-form').submit(function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let cartItemId = form.data('id');

                    $.ajax({
                        url: '/cart/remove/' + cartItemId, // Your route for removing cart item
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Remove the product card from UI
                            form.closest('.cart-product-card').remove();

                            // Update cart subtotal and order total
                            let subtotal = 0;
                            $('.cart-qty-total').each(function() {
                                subtotal += parseFloat($(this).text().replace('₱', '')
                                    .replace(/,/g, ''));
                            });
                            $('.cart-summary-value').first().text('₱' + subtotal.toLocaleString(
                                'en-US', {
                                    minimumFractionDigits: 2
                                }));
                            $('.cart-summary-total .cart-summary-value').text('₱' + subtotal
                                .toLocaleString('en-US', {
                                    minimumFractionDigits: 2
                                }));

                            // Show empty message if no items left
                            if ($('.cart-product-card').length === 0) {
                                $('.cart-products-section').html('<p>Your cart is empty.</p>');
                            }
                        }
                    });
                });
            });
        </script>

    </div>
</x-customer-layout>
