<x-customer-layout>

    @section('title', 'Order Details - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    @php
        $subtotal = $order->items->sum(fn($i) => $i->quantity * $i->product->price);
    @endphp

    <div class="checkout-main-container container-fluid py-5">
        <div class="row g-4">

            <!-- Left: Delivery & Order -->
            <div class="col-lg-8">
                <!-- Delivery Address -->
                <div class="checkout-section checkout-section-address mb-4 p-4 rounded shadow-sm">
                    <div class="mb-2 fw-semibold">Delivery Address</div>
                    <div>
                        <span class="fw-semibold">{{ $order->user->getFullName() }}</span> |
                        <span class="text-muted">{{ $order->user->phone ?? '+63' }}</span> |
                        {{ $order->user->getFullAddress() ?? 'Address not set' }}
                        <span class="badge bg-secondary">Default</span>
                    </div>
                </div>

                <!-- Products Ordered -->
                <div class="checkout-section mb-4 p-4 rounded shadow-sm" style="background:#fff;">
                    <div class="fw-semibold mb-2 checkout-product-header">Products Ordered</div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="checkoutProductsTable">
                            <thead>
                                <tr style="background:#f7f7fa;">
                                    <th></th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Item Subtotal</th>
                                    @if ($order->current_status === 'completed' || $order->current_status === 'delivered')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="width:70px;">
                                            <div style="width:60px;height:60px;background:#e3eafc;border-radius:8px;">
                                                @php
                                                    $primaryImage = $item->product->primaryImage->image_url ?? null;
                                                @endphp
                                                <img src="{{ $primaryImage ? asset('images/' . $primaryImage) : asset('images/no-image.png') }}"
                                                    alt="{{ $item->product->name }}"
                                                    style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('customer.specific-product', $item->product->product_id) }}"
                                                style="text-decoration:none; color:inherit;">
                                                <div class="fw-semibold">{{ $item->product->name }}</div>
                                            </a>
                                            <div class="text-muted" style="font-size:0.95rem;">
                                                {{ $item->product->description ?? 'No description' }}
                                            </div>
                                        </td>
                                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                                        <td>{{ $item->quantity }}x</td>
                                        <td>₱{{ number_format($item->quantity * $item->product->price, 2) }}</td>

                                        @if ($order->current_status === 'completed' || $order->current_status === 'delivered')
                                            <td>
                                                @php
                                                    $alreadyReviewed = $item->product
                                                        ->reviews()
                                                        ->where('user_id', Auth::id())
                                                        ->exists();
                                                @endphp

                                                @if (!$alreadyReviewed)
                                                    <button class="btn btn-outline-secondary addReviewBtn"
                                                        data-target="reviewModalOverlay-{{ $item->product->product_id }}">
                                                        Review
                                                    </button>
                                                @else
                                                    <span class="text-success">Reviewed</span>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>

                                    @if ($order->current_status === 'completed' || $order->current_status === 'delivered')
                                        @if (!$alreadyReviewed)
                                            <!-- Modal only if review not yet submitted -->
                                            <div class="modal-overlay"
                                                id="reviewModalOverlay-{{ $item->product->product_id }}"
                                                style="display:none;">
                                                <div class="modal-card">
                                                    <form
                                                        action="{{ route('customer.reviews.store', $item->product->product_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <div class="modal-product">
                                                                <img src="{{ $primaryImage ? asset('images/' . $primaryImage) : asset('images/no-image.png') }}"
                                                                    alt="{{ $item->product->name }}"
                                                                    class="modal-product-img">
                                                                <div>
                                                                    <div class="modal-product-title">
                                                                        {{ $item->product->name }}</div>
                                                                    <div class="modal-product-desc">
                                                                        {{ $item->product->description ?? 'No description' }}
                                                                    </div>
                                                                    <div class="modal-product-price">
                                                                        ₱{{ number_format($item->product->price, 2) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="modal-rating-row">
                                                                <span class="modal-rating-label">Rating:</span>
                                                                <div class="modal-stars"
                                                                    id="modalStars-{{ $item->product->product_id }}">
                                                                </div>

                                                                <input type="hidden" name="rating"
                                                                    id="modalRatingInput-{{ $item->product->product_id }}">

                                                                @error('rating')
                                                                    <div class="mt-2 text-sm text-danger">
                                                                        {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="modal-review-row">
                                                                <textarea name="comment" class="modal-review-text" placeholder="Enter Review"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="modal-btn modal-cancel"
                                                                data-target="reviewModalOverlay-{{ $item->product->product_id }}">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="modal-btn modal-submit">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-3 text-end fw-semibold">
                        Order Total: <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Payment Details + Status -->
            <div class="col-lg-4">
                <div class="checkout-section checkout-section-details p-4 rounded shadow-sm">


                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Payment Method:</div>
                        <div>{{ $order->payment_method }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Delivery Method:</div>
                        <div>{{ $order->delivery_method ?? 'Standard Delivery' }}</div>
                    </div>

                    <div class="fw-semibold mb-2">Payment Details:</div>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal:</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2"><span>Discount:</span>
                        <span>₱{{ number_format($order->discount_amount ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 fw-semibold"><span>Total Payment:</span>
                        <span>₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2"><span>Order Status::</span>
                        <span>{{ $order->current_status }}</span>
                    </div>

                    <!-- Dynamic Buttons -->
                    <div class="order-actions-main d-flex gap-2 justify-content-end">
                        @php $status = $order->current_status; @endphp

                        @if ($status === 'pending')
                            <form action="/" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-dark">Cancel Order</button>
                            </form>
                        @elseif (in_array($status, ['confirmed', 'processing']))
                            <a href="/" class="btn btn-warning">Track Order</a>
                        @elseif (in_array($status, ['shipped', 'to_receive']))
                            <a href="/" class="btn btn-warning">Request Return/Refund</a>
                            <form action="/" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Order Received</button>
                            </form>
                        @elseif (in_array($status, ['delivered', 'completed']))
                            {{-- <a href="javascript:void(0);" class="btn btn-outline-secondary" id="addReviewBtn">Leave a
                                Review</a> --}}
                            <a href="/" class="btn btn-success">Buy Again</a>
                        @elseif ($status === 'cancelled')
                            <a href="/" class="btn btn-success">Buy Again</a>
                        @elseif (in_array($status, ['returned', 'refunded']))
                            <a href="/" class="btn btn-success">Buy Again</a>
                        @endif
                    </div>

                </div>
            </div>

        </div>



        @push('scripts')
            @verbatim
                <script>
                    document.addEventListener('DOMContentLoaded', function() {


                        document.querySelectorAll('.addReviewBtn').forEach(button => {
                            button.addEventListener('click', function() {
                                const modalId = this.dataset.target;
                                const modal = document.getElementById(modalId);
                                if (modal) {
                                    modal.style.display = 'flex';
                                    document.body.style.overflow = 'hidden';
                                }

                                // setup stars dynamically for this modal 
                                const starsContainer = modal.querySelector('.modal-stars');
                                const ratingInput = modal.querySelector('input[name="rating"]');
                                if (starsContainer && starsContainer.childElementCount === 0) {
                                    let currentRating = 0;
                                    for (let i = 1; i <= 5; i++) {
                                        const star = document.createElement('span');
                                        star.classList.add('modal-star');
                                        star.textContent = '☆';
                                        star.dataset.value = i;

                                        star.addEventListener('click', function() {
                                            currentRating = i;
                                            ratingInput.value = i; // store rating in hidden input 
                                            updateStars(starsContainer, currentRating);
                                        });

                                        star.addEventListener('mouseover', function() {
                                            updateStars(starsContainer, i);
                                        });

                                        star.addEventListener('mouseout', function() {
                                            updateStars(starsContainer, currentRating);
                                        });

                                        starsContainer.appendChild(star);
                                    }
                                }
                            });
                        });

                        // cancel modal 
                        document.querySelectorAll('.modal-cancel').forEach(button => {
                            button.addEventListener('click', function() {
                                const modalId = this.dataset.target;
                                const modal = document.getElementById(modalId);
                                if (modal) {
                                    modal.style.display = 'none';
                                    document.body.style.overflow = '';
                                }
                            });
                        });

                        // clicking outside closes modal 
                        document.querySelectorAll('.modal-overlay').forEach(modal => {
                            modal.addEventListener('click', function(e) {
                                if (e.target === modal) {
                                    modal.style.display = 'none';
                                    document.body.style.overflow = '';
                                }
                            });
                        });

                        function updateStars(container, rating) {
                            container.querySelectorAll('.modal-star').forEach((star, idx) => {
                                star.textContent = idx < rating ? '★' : '☆';
                            });
                        }
                    });
                </script>
            @endverbatim
        @endpush



    </div>

</x-customer-layout>
