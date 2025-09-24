<x-admin-layout>
    @section('title', 'Order Management - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/order-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <!-- Order Management Content (main area) -->
    <div class="order-management-content">
        <h2>Order Management</h2>
        <div class="order-management-controls">
            <form method="GET" action="{{ route('admin.order-management') }}">
                <!-- Sort by Order Date -->
                <select name="sort" class="om-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Newest First
                    </option>
                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Oldest First</option>
                </select>

                <!-- Filter by Payment Method -->
                <select name="mop" class="om-category" onchange="this.form.submit()">
                    <option value="">Payment Method</option>
                    <option value="cod" {{ request('mop') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                    <option value="gcash" {{ request('mop') == 'gcash' ? 'selected' : '' }}>GCash</option>
                    <option value="card" {{ request('mop') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                </select>

                <!-- Filter by Status -->
                <select name="status" class="om-category" onchange="this.form.submit()">
                    <option value="">Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                    </option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                    </option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                    </option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </form>
        </div>

        <div class="om-table-container">
            <table class="om-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Order ID</th>
                        <th>MOP</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <!-- Image -->
                            <td>
                                <div class="om-image-cell">
                                    @php
                                        $firstItem = $order->items->first();
                                        $productImage = $firstItem?->product?->images->where('is_primary', 1)->first();
                                    @endphp
                                    @if ($productImage)
                                        <img src="{{ asset('images/' . $productImage->image_url) }}"
                                            alt="Order Product" class="order-img">
                                    @else
                                        <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="No Image"
                                            class="order-img">
                                    @endif
                                </div>
                            </td>

                            <!-- Order ID -->
                            <td>{{ $order->order_id }}</td>

                            <!-- MOP -->
                            <td>{{ strtoupper($order->payment_method) }}</td>

                            <!-- Status (Dropdown) -->
                            <td>
                                {{-- <form action="/" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="current_status" onchange="this.form.submit()">
                                        <option value="pending"
                                            {{ $order->current_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed"
                                            {{ $order->current_status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                        </option>
                                        <option value="processing"
                                            {{ $order->current_status == 'processing' ? 'selected' : '' }}>Processing
                                        </option>
                                        <option value="shipped"
                                            {{ $order->current_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered"
                                            {{ $order->current_status == 'delivered' ? 'selected' : '' }}>Delivered
                                        </option>
                                        <option value="cancelled"
                                            {{ $order->current_status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                        <option value="returned"
                                            {{ $order->current_status == 'returned' ? 'selected' : '' }}>Returned
                                        </option>
                                        <option value="refunded"
                                            {{ $order->current_status == 'refunded' ? 'selected' : '' }}>Refunded
                                        </option>
                                    </select>
                                </form> --}}
                                {{ ucfirst($order->current_status) }}
                            </td>

                            <!-- Order Date -->
                            <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                            <!-- Actions -->
                            <td>
                                <button class="om-action-btn om-action-view" title="View"
                                    onclick="window.location.href='/'">
                                    <span class="icon-container"><span class="icon-eye"></span></span>
                                </button>
                                <form action="/" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="om-action-btn om-action-delete" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this order?')">
                                        <span class="icon-container"><span class="icon-trash"></span></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">No orders available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- 🔹 Pagination below the table -->
        <div class="om-pagination">
            {{ $orders->appends(request()->only(['sort', 'mop', 'status']))->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-admin-layout>
