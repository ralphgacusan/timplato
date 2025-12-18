<x-admin-layout>
    @section('title', 'Order Details - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/order-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    @php
        $subtotal = $order->items->sum(fn($i) => $i->quantity * $i->product->price);
    @endphp

    <div class="order-management-content">
        <h2>Order Details - #{{ $order->order_id }}</h2>

        <div class="row g-4">

            <!-- Left: Customer & Ordered Items -->
            <div class="col-lg-8">

                <!-- Customer Info -->
                <div class="checkout-section checkout-section-address mb-4 p-4 rounded shadow-sm">
                    <div class="mb-2 fw-semibold">Customer Information</div>
                    <div>
                        <span class="fw-semibold">{{ $order->user->getFullName() }}</span> |
                        <span class="text-muted">{{ $order->user->phone ?? '+63' }}</span> |
                        {{ $order->user->getFullAddress() ?? 'Address not set' }}
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-primary">{{ $order->payment_method }}</span>
                        <span class="badge bg-secondary">{{ $order->delivery_method ?? 'Standard Delivery' }}</span>
                        <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $order->current_status)) }}</span>
                    </div>
                </div>

                <!-- Products Ordered -->
                <div class="checkout-section mb-4 p-4 rounded shadow-sm" style="background:#fff;">
                    <div class="fw-semibold mb-2 checkout-product-header">Products Ordered</div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr style="background:#f7f7fa;">
                                    <th></th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="width:70px;">
                                            @php
                                                $primaryImage = $item->product->primaryImage->image_url ?? null;
                                            @endphp
                                            <div style="width:60px;height:60px;background:#e3eafc;border-radius:8px;">
                                                <img src="{{ $primaryImage ? asset('images/' . $primaryImage) : asset('images/no-image.png') }}"
                                                    alt="{{ $item->product->name }}"
                                                    style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                                            </div>
                                        </td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
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

            <!-- Right: Payment & Admin Actions -->
            <div class="col-lg-4">
                <div class="checkout-section checkout-section-details p-4 rounded shadow-sm">


                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Payment Details:</div>
                        <div class="d-flex justify-content-between mb-2"><span>Subtotal:</span>
                            <span>₱{{ number_format($order->subtotal ?? $subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2"><span>Shipping Fee:</span>
                            <span>₱{{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2"><span>Discount:</span>
                            <span>- ₱{{ number_format($order->discount_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fw-semibold"><span>Total Payment:</span>
                            <span>₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    {{-- <div class="mb-3">
                        <div class="fw-semibold mb-1">Order Status:</div>
                        <div>{{ ucwords(str_replace('_', ' ', $order->current_status)) }}</div>
                    </div> --}}

                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Payment Method:</div>
                        <div>{{ $order->payment_method }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Delivery Method:</div>
                        <div>{{ $order->delivery_method ?? 'Standard Delivery' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold mb-1">Voucher Code:</div>
                        <div>{{ $order->voucher_code ?? 'N/A' }}</div>
                    </div>


                    <!-- Admin Actions -->
                    <div class="order-actions-main d-flex flex-column gap-2 mt-3">
                        <a href="{{ route('admin.orders.invoice', $order->order_id) }}"
                            class="btn btn-primary btn-sm">Download Invoice</a>
                        <a href="{{ route('admin.orders.packing-slip', $order->order_id) }}"
                            class="btn btn-secondary btn-sm">Download Packing Slip</a>
                        <div class="fw-semibold mb-1">Order Status</div>


                        @if ($order->current_status === 'cancel_requested')
                            <button type="button" class="btn btn-warning w-100"
                                onclick="document.getElementById('cancelRequestModalOverlay-{{ $order->order_id }}').style.display='flex'">
                                View Cancel Request
                            </button>
                            <div class="modal-overlay" id="cancelRequestModalOverlay-{{ $order->order_id }}"
                                style="display:none;">
                                <div class="modal-card">
                                    <div class="modal-header">
                                        <h2>Cancel Request - Order #{{ $order->order_id }}</h2>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Requested by:</strong> {{ $order->user->getFullName() }}</p>
                                        <p><strong>Reason:</strong> {{ $order->cancel_reason ?? 'No reason provided' }}
                                        </p>
                                        <p><strong>Requested at:</strong>
                                            {{ $order->updated_at->format('F j, Y, g:i A') }}</p>
                                    </div>
                                    <div class="modal-footer d-flex gap-2">
                                        <form action="{{ route('admin.orders.reject-cancel', $order->order_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-secondary w-100">Reject
                                                Cancel</button>
                                        </form>
                                        <form action="{{ route('admin.orders.approve-cancel', $order->order_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger w-100">Approve
                                                Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('admin.orders.update-status', ['order' => $order->order_id]) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <!-- Status Dropdown -->
                                <div class="mb-2">
                                    <select name="current_status" class="form-select form-select-sm">
                                        <option value="pending"
                                            {{ $order->current_status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="confirmed"
                                            {{ $order->current_status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed
                                        </option>
                                        <option value="processing"
                                            {{ $order->current_status == 'processing' ? 'selected' : '' }}>
                                            Processing
                                        </option>
                                        <option value="shipped"
                                            {{ $order->current_status == 'shipped' ? 'selected' : '' }}>
                                            Shipped
                                        </option>
                                        <option value="delivered"
                                            {{ $order->current_status == 'delivered' ? 'selected' : '' }}>
                                            Delivered
                                        </option>
                                        <option value="completed"
                                            {{ $order->current_status == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>

                                        {{-- Cancellation --}}
                                        <option value="cancel_requested"
                                            {{ $order->current_status == 'cancel_requested' ? 'selected' : '' }}>
                                            Cancel Requested
                                        </option>
                                        <option value="cancelled"
                                            {{ $order->current_status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled
                                        </option>

                                        {{-- Return / Refund --}}
                                        <option value="return_requested"
                                            {{ $order->current_status == 'return_requested' ? 'selected' : '' }}>
                                            Return Requested
                                        </option>
                                        <option value="return_approved"
                                            {{ $order->current_status == 'return_approved' ? 'selected' : '' }}>
                                            Return Approved
                                        </option>
                                        <option value="refund_requested"
                                            {{ $order->current_status == 'refund_requested' ? 'selected' : '' }}>
                                            Refund Requested
                                        </option>
                                        <option value="refund_approved"
                                            {{ $order->current_status == 'refund_approved' ? 'selected' : '' }}>
                                            Refund Approved
                                        </option>
                                        <option value="returned"
                                            {{ $order->current_status == 'returned' ? 'selected' : '' }}>
                                            Returned
                                        </option>
                                        <option value="refunded"
                                            {{ $order->current_status == 'refunded' ? 'selected' : '' }}>
                                            Refunded
                                        </option>
                                    </select>

                                </div>

                                <!-- Update Status Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                </div>
                            </form>

                            <!-- Delete Order Button -->
                            <form action="{{ route('admin.orders.destroy', ['order' => $order->order_id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this order?')">
                                    Delete Order
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Return / Refund Management --}}
                    @if (in_array($order->current_status, [
                            'return_requested',
                            'refund_requested',
                            'return_approved',
                            'refund_approved',
                            'returned',
                            'refunded',
                        ]))
                        <div class="order-actions-main d-flex flex-column gap-2 mt-3">
                            <div class="fw-semibold mb-1">Return / Refund Requests</div>

                            {{-- Refund Request --}}
                            @if ($order->current_status === 'refund_requested')
                                <button type="button" class="btn btn-warning w-100"
                                    onclick="document.getElementById('refundRequestModalOverlay-{{ $order->order_id }}').style.display='flex'">
                                    View Refund Request
                                </button>

                                <div class="modal-overlay" id="refundRequestModalOverlay-{{ $order->order_id }}"
                                    style="display:none;">
                                    <div class="modal-card">
                                        <div class="modal-header">
                                            <h2>Refund Request - Order #{{ $order->order_id }}</h2>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Requested by:</strong> {{ $order->user->getFullName() }}</p>
                                            <p><strong>Reason:</strong>
                                                {{ $order->return_refund_reason ?? 'No reason provided' }}</p>
                                            <p><strong>Requested at:</strong>
                                                {{ $order->return_refund_requested_at?->format('F j, Y, g:i A') }}</p>
                                        </div>
                                        <div class="modal-footer d-flex gap-2">
                                            <form action="{{ route('admin.orders.reject-refund', $order->order_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-secondary w-100">Reject
                                                    Refund</button>
                                            </form>
                                            <form
                                                action="{{ route('admin.orders.approve-refund', $order->order_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger w-100">Approve
                                                    Refund</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Refund Approved → Process Refund --}}
                            @elseif ($order->current_status === 'refund_approved')
                                <form action="{{ route('admin.orders.process-refund', $order->order_id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary w-100">Process Refund</button>
                                </form>

                                {{-- Already Refunded → Display text only --}}
                            @elseif ($order->current_status === 'refunded')
                                <div class="alert alert-success text-center mb-0">Refund Completed</div>

                                {{-- Return Request --}}
                            @elseif ($order->current_status === 'return_requested')
                                <button type="button" class="btn btn-warning w-100"
                                    onclick="document.getElementById('returnRequestModalOverlay-{{ $order->order_id }}').style.display='flex'">
                                    View Return Request
                                </button>

                                <div class="modal-overlay" id="returnRequestModalOverlay-{{ $order->order_id }}"
                                    style="display:none;">
                                    <div class="modal-card">
                                        <div class="modal-header">
                                            <h2>Return Request - Order #{{ $order->order_id }}</h2>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Requested by:</strong> {{ $order->user->getFullName() }}</p>
                                            <p><strong>Reason:</strong>
                                                {{ $order->return_refund_reason ?? 'No reason provided' }}</p>
                                            <p><strong>Requested at:</strong>
                                                {{ $order->return_refund_requested_at?->format('F j, Y, g:i A') }}</p>
                                        </div>
                                        <div class="modal-footer d-flex gap-2">
                                            <form action="{{ route('admin.orders.reject-return', $order->order_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-secondary w-100">Reject
                                                    Return</button>
                                            </form>
                                            <form
                                                action="{{ route('admin.orders.approve-return', $order->order_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger w-100">Approve
                                                    Return</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Return Approved → Process Return --}}
                            @elseif ($order->current_status === 'return_approved')
                                <form action="{{ route('admin.orders.process-return', $order->order_id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary w-100">Process Return</button>
                                </form>

                                {{-- Already Returned → Display text only --}}
                            @elseif ($order->current_status === 'returned')
                                <div class="alert alert-success text-center mb-0">Return Completed</div>
                            @endif
                        </div>
                    @endif




                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
