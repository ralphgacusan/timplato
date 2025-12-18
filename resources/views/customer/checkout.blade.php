<x-customer-layout>

    @section('title', 'Checkout - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">
    @endpush

    @php
        $subtotal = $items->sum(fn($i) => $i->quantity * $i->product->price);
    @endphp

    <div class="checkout-main-container container-fluid py-5">
        <div class="row g-4">

            <!-- Left: Delivery & Order -->
            <div class="col-lg-7">
                <!-- Delivery Address -->

                <a href="{{ route('auth.user-profile') }}" class="text-decoration-none text-reset">

                    <div class="checkout-section checkout-section-address mb-4 p-4 rounded shadow-sm">
                        <div class="mb-2 fw-semibold">Delivery Details</div>
                        <div>
                            <span class="fw-semibold">{{ Auth::user()->getFullName() }}</span> |

                            {{-- Phone check --}}
                            @if (!empty(Auth::user()->phone))
                                <span class="text-muted">{{ Auth::user()->phone }}</span> |
                            @else
                                <span class="text-danger fw-semibold">⚠ Please provide a phone number</span>
                            @endif

                            {{-- Address check --}}
                            @if (!empty(Auth::user()->getFullAddress()))
                                {{ Auth::user()->getFullAddress() }}
                                <span class="badge bg-secondary">Default</span>
                            @else
                                <br>
                                <span class="text-danger fw-semibold">⚠ Please provide a delivery address</span>
                            @endif
                        </div>
                    </div>
                </a>


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
                                    <th>Qty</th>
                                    <th>Item Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr onclick="window.location='{{ route('customer.specific-product', $item->product->product_id) }}';"
                                        style="cursor:pointer;">
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
                                            <div class="fw-semibold">{{ $item->product->name }}</div>
                                            <div class="text-muted"
                                                style="font-size:0.95rem; 
                              white-space: nowrap; 
                              overflow: hidden; 
                              text-overflow: ellipsis; 
                              max-width: 300px;">
                                                {{ $item->product->description ?? 'No description' }}
                                            </div>

                                        </td>
                                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                                        </td>
                                        <td>{{ $item->quantity }}x</td>
                                        <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-end fw-semibold">Order Total:
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Right: Payment Details + Payment Method -->
            <div class="col-lg-5">
                <form action="{{ route('customer.placeOrder') }}" method="POST"
                    class="checkout-section checkout-section-details p-4 rounded shadow-sm">
                    @csrf

                    <!-- Hidden Inputs for Items -->
                    @foreach ($items as $index => $item)
                        <input type="hidden" name="items[{{ $index }}][product_id]"
                            value="{{ $item->product->product_id }}">
                        <input type="hidden" name="items[{{ $index }}][quantity]"
                            value="{{ $item->quantity }}">
                        <input type="hidden" name="items[{{ $index }}][price]"
                            value="{{ $item->product->price }}">
                    @endforeach

                    <div class="fw-semibold mb-2">Payment Details:</div>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal:</span>
                        <span>{{ $settings['currency'] }}{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <!-- Delivery Methods -->
                    <div class="mb-2">Choose a delivery method</div>

                    @foreach ($deliveryMethods as $method)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="deliveryMethod"
                                id="delivery{{ $method->id }}" value="{{ $method->name }}"
                                data-fee="{{ $method->fee }}" {{ $loop->last ? 'checked' : '' }}>
                            <label class="form-check-label" for="delivery{{ $method->id }}">
                                {{ $method->name }}
                                <span
                                    class="ms-2">{{ $method->fee > 0 ? $settings['currency'] . number_format($method->fee) : 'FREE' }}</span>
                                <span class="text-muted ms-2">{{ $method->description }}</span>
                            </label>
                        </div>
                    @endforeach


                    <!-- Payment Methods -->
                    <div class="fw-semibold mt-4 mb-2">Payment Method</div>

                    @foreach ($paymentMethods as $method)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod"
                                id="payment{{ $method->name }}" value="{{ $method->name }}"
                                {{ $loop->first ? 'checked' : '' }}> {{-- ✅ Default select first --}}
                            <label class="form-check-label" for="payment{{ $method->name }}">
                                {{ $method->name }}
                                @if ($method->description)
                                    <span class="text-muted">{{ $method->description }}</span>
                                @endif
                            </label>
                        </div>
                    @endforeach

                    <!-- Coupon -->
                    <div class="input-group mb-2 mt-3">
                        <input type="text" class="form-control" placeholder="Coupon/Voucher" id="voucherInput"
                            name="coupon">
                        <button class="btn btn-primary" type="button" id="applyVoucherBtn">Add</button>
                    </div>
                    <div id="voucherMessage" style="height: 20px; margin-bottom: 10px; font-size: 0.9rem;"></div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span> <span id="discountAmount">{{ $settings['currency'] }}0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 fw-semibold">
                        <span>Total Payment:</span>
                        <span id="totalPayment">{{ $settings['currency'] }}{{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if (!Auth::user()->getFullAddress() || !Auth::user()->phone)
                        <button class="btn btn-warning w-100 fw-semibold" disabled>
                            PLACE ORDER
                        </button>
                    @else
                        <button class="btn btn-warning w-100 fw-semibold">
                            PLACE ORDER
                        </button>
                    @endif

                </form>
            </div>
        </div>

        <!-- JS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const subtotal = {{ $subtotal }};
                const currency = "{{ $settings['currency'] }}"; // ✅ Pass PHP currency to JS
                let deliveryFee = 0;
                let discount = 0;

                const deliveryRadios = document.querySelectorAll('input[name="deliveryMethod"]');
                const totalPaymentEl = document.getElementById('totalPayment');
                const discountEl = document.getElementById('discountAmount');
                const voucherInput = document.getElementById('voucherInput');
                const applyVoucherBtn = document.getElementById('applyVoucherBtn');
                const voucherMessageEl = document.getElementById('voucherMessage');

                function updateTotal() {
                    const total = subtotal + deliveryFee - discount;
                    totalPaymentEl.textContent =
                        `${currency}${total.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2})}`;
                    discountEl.textContent =
                        `-${currency}${discount.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2})}`;
                }

                // Delivery fee change
                deliveryRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        deliveryFee = parseFloat(radio.dataset.fee);
                        updateTotal();
                    });
                });

                applyVoucherBtn.addEventListener('click', async () => {
                    const code = voucherInput.value.trim().toUpperCase();
                    if (!code) {
                        voucherMessageEl.textContent = "Please enter a voucher code.";
                        voucherMessageEl.style.color = 'red';
                        return;
                    }

                    try {
                        const url =
                            `/voucher/validate?code=${encodeURIComponent(code)}&subtotal=${encodeURIComponent(subtotal)}&shipping=${encodeURIComponent(deliveryFee)}`;
                        const res = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();

                        if (!res.ok) {
                            voucherMessageEl.textContent = data.message || 'Invalid response from server.';
                            voucherMessageEl.style.color = 'red';
                            discount = 0;
                        } else if (data.valid) {
                            discount = parseFloat(data.discount) || 0;
                            voucherMessageEl.textContent = `Voucher "${data.code}" applied successfully!`;
                            voucherMessageEl.style.color = 'green';
                        } else {
                            discount = 0;
                            voucherMessageEl.textContent = data.message || 'Invalid voucher code.';
                            voucherMessageEl.style.color = 'red';
                        }
                        updateTotal();
                    } catch (err) {
                        console.error('Voucher validation error:', err);
                        voucherMessageEl.textContent = "Something went wrong. Please try again.";
                        voucherMessageEl.style.color = 'red';
                    }
                });

                // Initialize total
                updateTotal();
            });
        </script>


    </div>

</x-customer-layout>
