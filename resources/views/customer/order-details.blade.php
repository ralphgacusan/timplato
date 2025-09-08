<x-customer-layout>

    @section('title', 'Order Details - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">
    @endpush

    @php
        $subtotal = $order->items->sum(fn($i) => $i->quantity * $i->product->price);
    @endphp

    <div class="checkout-main-container container-fluid py-5">
        <div class="row g-4">

            <!-- Left: Delivery & Order -->
            <div class="col-lg-7">
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
                                            <div class="fw-semibold">{{ $item->product->name }}</div>
                                            <div class="text-muted" style="font-size:0.95rem;">
                                                {{ $item->product->description ?? 'No description' }}</div>
                                        </td>
                                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                                        <td>{{ $item->quantity }}x</td>
                                        <td>₱{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                                    </tr>
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
            <div class="col-lg-5">
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

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        {{-- {{ route('customer.cancelOrder', $order->order_id) }} --}}
                        <form action="/" method="POST" class="flex-fill">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-dark w-100">Cancel Order</button>
                        </form>
                        {{-- {{ route('customer.contactSeller', $order->order_id) }} --}}
                        <a href="/" class="btn btn-primary flex-fill">Contact Seller</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-customer-layout>
