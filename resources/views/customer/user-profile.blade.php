<x-customer-layout>
    @section('title', 'User Profile - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/user-profile.css') }}">
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
                        {{ Auth::user()->phone ?? 'No phone set' }}
                        <span class="ms-1"><i class="bi bi-patch-check-fill"></i></span>
                    </div>
                </div>
            </div>

            <!-- Address Display -->
            <div class="col-lg-8">
                @php
                    // Get the default address
                    $defaultAddress = Auth::user()->addresses->where('is_default', 1)->first();
                @endphp
                <div class="card p-4 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-semibold">Address

                            @if ($defaultAddress)
                                <span class="badge bg-secondary ms-1">{{ $defaultAddress->label }}</span>
                            @endif

                        </div>
                        <a href=" {{ route('auth.user-profile.manage-address') }}" class="btn btn-warning btn-sm">
                            Manage Addresses
                        </a>
                    </div>



                    <!-- Row 1: Street Address + ZIP -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-8">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->address ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->zip_code ?? 'N/A' }}"
                                readonly>
                        </div>
                    </div>

                    <!-- Row 2: Country / City / State -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->country ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->city ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State/Province</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->state ?? 'N/A' }}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Information Display -->
        <div class="card p-4 mt-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold fs-5">General Information</div>
                <a href=" {{ route('auth.user-profile.edit') }}" class="btn btn-warning btn-sm">Edit Profile</a>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->first_name }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->last_name }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control"
                        value="{{ ucfirst(str_replace('_', ' ', Auth::user()->gender ?? 'N/A')) }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->date_of_birth }}" readonly>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->phone ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                </div>
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
                        <div class="delivery-tabs d-flex gap-3 border-bottom mb-3">
                            <div class="delivery-tab active" data-tab="to-ship">To Ship</div>
                            <div class="delivery-tab" data-tab="to-receive">To Receive</div>
                            <div class="delivery-tab" data-tab="completed">Completed</div>
                        </div>

                        <div id="deliveryContent">
                            @forelse ($orders as $order)
                                <div class="order-card p-3 mb-3 shadow-sm rounded">
                                    <div class="order-header d-flex justify-content-between mb-2">
                                        <span class="store fw-bold">Timplato</span>
                                        <div class="order-actions">
                                            <button class="btn btn-primary btn-sm">Chat</button>
                                        </div>
                                    </div>

                                    @foreach ($order->items as $item)
                                        <div class="order-details d-flex align-items-center gap-3 mb-2">
                                            @php
                                                $primaryImage = $item->product->primaryImage->image_url ?? null;
                                                $itemSubtotal = $item->quantity * ($item->product->price ?? 0);
                                            @endphp

                                            <img src="{{ $primaryImage ? asset('images/' . $primaryImage) : asset('images/no-image.png') }}"
                                                alt="{{ $item->product->name ?? 'Product' }}" class="rounded"
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

                                    <!-- Move order status OUTSIDE the items loop -->
                                    <div class="order-status text-end mb-2">
                                        <div class="delivered text-primary fw-bold">
                                            {{ $order->current_status }}
                                        </div>
                                    </div>

                                    <div class="order-footer d-flex justify-content-between mb-2">
                                        <div class="confirm">Confirm receipt after checking items</div>
                                        <div class="total fw-bold">Order Total:
                                            ₱{{ number_format($order->total_amount, 2) }}</div>
                                    </div>

                                    <div class="order-actions-main d-flex gap-2">
                                        <button class="btn btn-dark flex-fill">Cancel Order</button>

                                        <a href="{{ route('customer.orderDetails', $order->order_id) }}"
                                            class="btn btn-primary flex-fill">
                                            Order Details
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <p>No orders yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../JS/delivery.js"></script>

    </div>
</x-customer-layout>
