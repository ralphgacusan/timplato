<x-customer-layout>
    @section('title', 'User Profile - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/user-profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    <div class="container py-5">
        <div class="row g-4">
            <!-- Profile Photo & Name -->
            <div class="col-lg-4">
                <div class="card p-4 text-center shadow-sm">
                    <div class="mb-3">
                        <img id="profilePhoto"
                            src="{{ Auth::user()->profile_picture_path ? asset(Auth::user()->profile_picture_path) : asset('timplatoLogo/Timplato-Blue-LOGO.png') }}"
                            alt="Profile Photo" class="rounded-circle"
                            style="width:140px;height:140px;object-fit:cover;">
                    </div>
                    <div class="fw-semibold fs-4">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </div>
                    <div class="text-primary fs-5">
                        @php
                            $now = \Carbon\Carbon::now();
                            $status = '';

                            if ($user->suspended_until && $user->suspended_until->isFuture()) {
                                $status = '<span class="status suspended">Suspended</span>';
                            } elseif ($user->last_login_at && $user->last_login_at->diffInDays($now) <= 30) {
                                $status = '<span class="status active">Active</span>';
                            } elseif ($user->last_login_at) {
                                $status =
                                    '<span class="status inactive">Inactive since ' .
                                    $user->last_login_at->format('M d, Y H:i') .
                                    '</span>';
                            } else {
                                $status = '<span class="status never">Never logged in</span>';
                            }
                        @endphp
                        {!! $status !!}
                    </div>
                </div>
            </div>

            <!-- Address Display -->
            <div class="col-lg-8">
                @php
                    $defaultAddress = Auth::user()->addresses->where('is_default', 1)->first();
                @endphp
                <div class="card p-4 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-semibold">
                            Address
                            @if ($defaultAddress)
                                <span class="badge bg-secondary ms-1">{{ $defaultAddress->label }}</span>
                            @endif
                        </div>
                        <a href="{{ route('auth.user-profile.manage-address') }}" class="btn btn-warning btn-sm">
                            Manage Addresses
                        </a>
                    </div>

                    <!-- Row 1: Street Address + ZIP -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-8">
                            <label class="form-label d-block">Street Address</label>
                            <p class="form-control-plaintext">{{ $defaultAddress?->address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">ZIP Code</label>
                            <p class="form-control-plaintext">{{ $defaultAddress?->zip_code ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Row 2: Country / City / State -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label d-block">Country</label>
                            <p class="form-control-plaintext">{{ $defaultAddress?->country ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">City</label>
                            <p class="form-control-plaintext">{{ $defaultAddress?->city ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">State/Province</label>
                            <p class="form-control-plaintext">{{ $defaultAddress?->state ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Information Display -->
        <div class="card p-4 mt-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-semibold mb-0">General Information</h5>
                <a href="{{ route('auth.user-profile.edit') }}" class="btn btn-warning btn-sm">Edit Profile</a>
            </div>

            <!-- Row 1: Names + Gender (4 Columns) -->
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label d-block">First Name</label>
                    <p class="form-control-plaintext">{{ Auth::user()->first_name }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Middle Name</label>
                    <p class="form-control-plaintext">{{ Auth::user()->middle_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Last Name</label>
                    <p class="form-control-plaintext">{{ Auth::user()->last_name }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Gender</label>
                    <p class="form-control-plaintext">
                        {{ ucfirst(str_replace('_', ' ', Auth::user()->gender ?? 'N/A')) }}
                    </p>
                </div>
            </div>

            <!-- Row 2: DOB, Phone, Email, Hidden Column (Keeps layout aligned) -->
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label d-block">Date of Birth</label>
                    <p class="form-control-plaintext">
                        {{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('F d, Y') : 'N/A' }}
                    </p>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Phone Number</label>
                    <p class="form-control-plaintext">{{ Auth::user()->phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Email Address</label>
                    <p class="form-control-plaintext">{{ Auth::user()->email }}</p>
                </div>
                <!-- Hidden column to maintain 4-column structure -->
                <div class="col-md-3 d-none"></div>
            </div>

        </div>



        <!-- Delivery Section -->
        <div class="delivery-section mt-4">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="delivery-sidebar p-3 shadow-sm rounded">
                        <ul class="list-unstyled" id="sidebarMenu">
                            <li data-content="purchase" class="active">My Purchase</li>
                            <li data-content="notifications">Notifications</li>
                        </ul>
                    </div>
                </div>

                <!-- Main Delivery Content -->
                <div class="col-lg-9">
                    <div class="delivery-main p-3 shadow-sm rounded">

                        {{-- Tabs --}}
                        <div class="delivery-tabs d-flex gap-3 border-bottom mb-3" id="purchaseTabs">
                            @php
                                $tabs = [
                                    'all' => 'All',
                                    'to-pay' => 'To Pay',
                                    'to-ship' => 'To Ship',
                                    'to-receive' => 'To Receive',
                                    'completed' => 'Completed',
                                    'cancelled' => 'Cancelled',
                                    'return-refund' => 'Return/Refund',
                                ];
                            @endphp


                            @foreach ($tabs as $key => $label)
                                <div class="delivery-tab {{ $loop->first ? 'active' : '' }}"
                                    data-tab="{{ $key }}">
                                    {{ $label }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Content --}}
                        <div id="deliveryContent">
                            @foreach ($tabs as $status => $label)
                                <div class="tab-content {{ $loop->first ? 'active' : '' }}"
                                    data-content="{{ $status }}">
                                    @forelse ($groupedOrders[$status] ?? [] as $order)
                                        <div class="order-card p-3 mb-3 shadow-sm rounded">
                                            <a href="{{ route('customer.orderDetails', $order->order_id) }}"
                                                class="order-card-link text-decoration-none">
                                                <div class="order-header d-flex justify-content-between mb-2">
                                                    <span class="store fw-bold">Timplato</span>
                                                    <div class="order-actions">
                                                        {{-- <button class="btn btn-primary btn-sm">Chat</button> --}}
                                                    </div>
                                                </div>

                                                {{-- Items --}}
                                                @foreach ($order->items as $item)
                                                    @php
                                                        $primaryImage = $item->product->primaryImage->image_url ?? null;
                                                        $itemSubtotal = $item->quantity * ($item->product->price ?? 0);
                                                    @endphp
                                                    <div class="order-details d-flex align-items-center gap-3 mb-2">
                                                        <img src="{{ $primaryImage ? asset('images/' . $primaryImage) : asset('images/no-image.png') }}"
                                                            alt="{{ $item->product->name ?? 'Product' }}"
                                                            class="rounded"
                                                            style="width:60px;height:60px;object-fit:cover;">

                                                        <div class="order-info flex-grow-1">
                                                            <div class="title fw-bold">
                                                                {{ $item->product->name ?? 'Product Name' }}</div>
                                                            <div class="qty">x{{ $item->quantity }}</div>
                                                        </div>

                                                        <div class="item-subtotal fw-bold text-end">
                                                            ₱{{ number_format($itemSubtotal, 2) }}
                                                        </div>
                                                    </div>
                                                @endforeach

                                                {{-- Status --}}
                                                <div class="order-status text-end mb-2">
                                                    <div class="delivered text-primary fw-bold">
                                                        {{ ucwords(str_replace('_', ' ', $order->current_status)) }}
                                                    </div>
                                                </div>

                                                {{-- Footer --}}
                                                <div class="order-footer d-flex justify-content-between mb-2">
                                                    <div class="confirm">Confirm receipt after checking items</div>
                                                    <div class="total fw-bold">
                                                        Order Total: ₱{{ number_format($order->total_amount, 2) }}
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="order-actions-main d-flex gap-2 justify-content-end">
                                                @php $status = $order->current_status; @endphp

                                                @if ($status === 'cancel_requested')
                                                    <button type="button" class="btn btn-dark" disabled>Cancel
                                                        Requested</button>
                                                @elseif ($status === 'cancelled')
                                                    <button type="button" class="btn btn-secondary"
                                                        disabled>Cancelled</button>
                                                @elseif ($status === 'pending')
                                                    {{-- Button for Not COD orders that are not yet paid --}}
                                                    @if ($order->payment_method != 'COD')
                                                        <form
                                                            action="{{ route('paymongo.redirect', [
                                                                'amount' => $order->total_amount,
                                                                'order' => $order->order_id,
                                                                'paymentMethod' => $order->payment_method,
                                                            ]) }}"
                                                            method="GET">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning">Pay
                                                                Now</button>
                                                        </form>
                                                    @endif

                                                    <button type="button" class="btn btn-dark"
                                                        onclick="document.getElementById('cancelOrderModalOverlay-{{ $order->order_id }}').style.display='flex'">
                                                        Cancel Order
                                                    </button>
                                                    <!-- Cancel Order Modal -->
                                                    <div class="modal-overlay"
                                                        id="cancelOrderModalOverlay-{{ $order->order_id }}"
                                                        style="display:none;">
                                                        <div class="modal-card">
                                                            <form
                                                                action="{{ route('customer.orders.cancel', $order->order_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-header">
                                                                    <h2 class="modal-product-title">Cancel Order
                                                                        #{{ $order->order_id }}
                                                                    </h2>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to request cancellation
                                                                        for this order? The
                                                                        seller/admin must approve it.</p>

                                                                    <div class="modal-review-row">
                                                                        <label for="cancel_reason">Reason
                                                                            (optional)
                                                                            :</label>
                                                                        <textarea name="cancel_reason" id="cancel_reason" class="modal-review-text"
                                                                            placeholder="Enter reason for cancellation"></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="modal-btn modal-cancel"
                                                                        data-target="cancelOrderModalOverlay-{{ $order->order_id }}">Close</button>
                                                                    <button type="submit"
                                                                        class="modal-btn modal-submit">Request
                                                                        Cancellation</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @elseif (in_array($status, ['confirmed', 'processing']))
                                                    {{-- <button class="btn btn-warning">Track Order</button> --}}
                                                @elseif (in_array($status, ['shipped', 'to_receive']))
                                                    {{-- <button class="btn btn-success">Order Received</button> --}}
                                                @elseif (in_array($status, ['delivered', 'completed']))
                                                    <!-- Return/Refund button -->
                                                    <button type="button" class="btn btn-warning"
                                                        onclick="document.getElementById('returnRefundModalOverlay-{{ $order->order_id }}').style.display='flex'">
                                                        Request Return/Refund
                                                    </button>

                                                    <!-- Modal for Request Return/Refund -->
                                                    <div class="modal-overlay"
                                                        id="returnRefundModalOverlay-{{ $order->order_id }}"
                                                        style="display:none;">
                                                        <div class="modal-card">
                                                            <form
                                                                action="{{ route('customer.orders.return-refund', $order->order_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="modal-header">
                                                                    <h2 class="modal-product-title">Request
                                                                        Return/Refund for Order
                                                                        #{{ $order->order_id }}</h2>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <p>Please select your request type and provide
                                                                        details below:</p>

                                                                    <div class="mb-3">
                                                                        <label for="request_type"
                                                                            class="fw-semibold">Request Type:</label>
                                                                        <select name="request_type" id="request_type"
                                                                            class="form-select">
                                                                            <option value="return">Return</option>
                                                                            <option value="refund">Refund</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="modal-review-row">
                                                                        <label for="reason">Reason:</label>
                                                                        <textarea name="reason" id="reason" class="modal-review-text"
                                                                            placeholder="Describe the issue or reason for return/refund" required></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="modal-btn modal-cancel"
                                                                        data-target="returnRefundModalOverlay-{{ $order->order_id }}">Close</button>
                                                                    <button type="submit"
                                                                        class="modal-btn modal-submit">Submit
                                                                        Request</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    {{-- <button class="btn btn-outline-secondary">Leave a
                                                        Review</button> --}}
                                                    <form
                                                        action="{{ route('customer.orders.buy-again', $order->order_id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Buy
                                                            Again</button>
                                                    </form>
                                                @elseif ($status === 'cancelled')
                                                    <form
                                                        action="{{ route('customer.orders.buy-again', $order->order_id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Buy
                                                            Again</button>
                                                    </form>
                                                @elseif (in_array($status, ['returned', 'refunded']))
                                                    <form
                                                        action="{{ route('customer.orders.buy-again', $order->order_id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Buy
                                                            Again</button>
                                                    </form>
                                                @endif
                                            </div>


                                        </div>

                                    @empty
                                        <div class="text-center py-5">
                                            <p>No orders in this section.</p>
                                        </div>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>

                        <!-- Notifications Section -->
                        <div id="notifications-section" class="notifications-section mt-4" style="display: none;">
                            <div class="notification-main p-3 shadow-sm rounded">

                                <h5 class="mb-3 fw-semibold">Notifications</h5>

                                @forelse($notifications as $notification)
                                    @php
                                        $imageUrl = null;

                                        // Determine image source
                                        if ($notification->product?->primaryImage) {
                                            $imageUrl = asset(
                                                'images/' . $notification->product->primaryImage->image_url,
                                            );
                                        } elseif ($notification->order?->items->first()?->product?->primaryImage) {
                                            $imageUrl = asset(
                                                'images/' .
                                                    $notification->order->items->first()->product->primaryImage
                                                        ->image_url,
                                            );
                                        } else {
                                            $imageUrl = asset('images/product-placeholder.png');
                                        }

                                        // Get order ID if notification is related to an order
                                        $orderId = $notification->order_id ?? ($notification->order?->id ?? null);
                                    @endphp

                                    <div class="notification-card">
                                        <div class="notification-header">
                                            <span class="notification-title">{{ $notification->title }}</span>

                                            @if ($orderId)
                                                <a href="{{ route('customer.orderDetails', ['order' => $orderId]) }}"
                                                    class="notification-details-btn"
                                                    style="text-decoration: none; color: inherit;">
                                                    View Details
                                                </a>
                                            @else
                                                <button class="notification-details-btn" disabled>
                                                    No Details
                                                </button>
                                            @endif
                                        </div>

                                        <div class="notification-details">
                                            @if ($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="Notification Image"
                                                    class="notification-img">
                                            @endif

                                            <div class="notification-info">
                                                <div class="notification-desc">{!! $notification->message !!}</div>
                                                <div class="notification-date">
                                                    {{ $notification->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-3">
                                        <p>No notifications found.</p>
                                    </div>
                                @endforelse


                            </div>
                        </div>





                    </div>




                </div>

            </div>
        </div>




        <script src="{{ asset('js/customer/delivery.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.modal-cancel').forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-target');
                        document.getElementById(targetId).style.display = 'none';
                    });
                });
            });
        </script>

    </div>
</x-customer-layout>
