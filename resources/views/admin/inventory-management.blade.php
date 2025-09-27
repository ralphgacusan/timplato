<x-admin-layout>
    @section('title', 'Inventory Management - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/inventory-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    <div class="inventory-management-content">
        <h2>Inventory Management</h2>
        <div class="inventory-management-controls mb-4">
            <form method="GET" action="{{ route('admin.inventory-management') }}" class="d-flex gap-2 flex-wrap">

                <!-- Sort Dropdown -->
                <select name="sort" class="im-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="stock-asc" {{ request('sort') == 'stock-asc' ? 'selected' : '' }}>Stock (Low → High)
                    </option>
                    <option value="stock-desc" {{ request('sort') == 'stock-desc' ? 'selected' : '' }}>Stock (High →
                        Low)</option>
                    <option value="latest-restock" {{ request('sort') == 'latest-restock' ? 'selected' : '' }}>Latest
                        Restock</option>
                </select>

                <!-- Status Filter -->
                <select name="status" class="im-status" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="in-stock" {{ request('status') == 'in-stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low-stock" {{ request('status') == 'low-stock' ? 'selected' : '' }}>Low Stock
                    </option>
                    <option value="out-of-stock" {{ request('status') == 'out-of-stock' ? 'selected' : '' }}>Out of
                        Stock</option>
                </select>

                <!-- Search -->
                <input type="text" name="search" class="im-search" placeholder="Search products"
                    value="{{ request('search') }}">
                <button type="submit" class="im-btn btn btn-primary">Search</button>

            </form>
        </div>

        <div class="im-table-container">
            <table class="im-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Reserved</th>
                        <th>Available Stock</th>
                        <th>Status</th>
                        <th>Last Restock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $reserved = $product->reserved_stock ?? 0; // from orders
                            $available = $product->stock_quantity - $reserved;

                            if ($product->stock_quantity <= 0) {
                                $status = '<span class="badge bg-danger">Out of stock 🔴</span>';
                            } elseif ($product->stock_quantity <= ($product->restock_level ?? 5)) {
                                $status = '<span class="badge bg-warning text-dark">Low stock 🟡</span>';
                            } else {
                                $status = '<span class="badge bg-success">In stock 🟢</span>';
                            }
                        @endphp

                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $reserved }}</td>
                            <td>{{ $available }}</td>
                            <td>{!! $status !!}</td>
                            <td>
                                {{ $product->latestStockTransaction ? $product->latestStockTransaction->created_at->format('M d, Y H:i') : 'N/A' }}
                            </td>

                            <td>
                                <!-- Adjust Stock -->
                                <button class="im-action-btn im-action-edit" title="Adjust Stock"
                                    onclick="document.getElementById('adjustStockModalOverlay-{{ $product->product_id }}').style.display='flex'">
                                    <span class="icon-container"><span class="icon-pencil"></span></span>
                                </button>
                                <!-- Adjust Stock Modal -->
                                <div class="modal-overlay" id="adjustStockModalOverlay-{{ $product->product_id }}"
                                    style="display:none;">
                                    <div class="modal-card">
                                        <div class="modal-header">
                                            <h2>Adjust Stock - {{ $product->name }}</h2>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('admin.inventory.updateStock', ['product' => $product->product_id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <!-- Current Stock (centered text) -->
                                                <div class="mb-4 text-center">
                                                    <h4>Current Stock: <span
                                                            class="fw-bold">{{ $product->stock_quantity }}</span></h4>
                                                </div>

                                                <!-- Adjustment Type + Quantity on same row -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="type-{{ $product->product_id }}"
                                                            class="form-label">Adjustment Type</label>
                                                        <select name="type" id="type-{{ $product->product_id }}"
                                                            class="form-control" required>
                                                            <option value="add">Add Stock</option>
                                                            <option value="deduct">Deduct Stock</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="quantity-{{ $product->product_id }}"
                                                            class="form-label">Quantity</label>
                                                        <input type="number" name="quantity"
                                                            id="quantity-{{ $product->product_id }}"
                                                            class="form-control" min="1" required>
                                                    </div>
                                                </div>

                                                <!-- Footer buttons -->
                                                <div class="modal-footer d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="document.getElementById('adjustStockModalOverlay-{{ $product->product_id }}').style.display='none'">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Update Stock</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                                <!-- View Stock History -->
                                <button class="im-action-btn im-action-view" title="Stock History"
                                    onclick="window.location.href='{{ route('admin.inventory.history', ['product' => $product->product_id]) }}'">
                                    <span class="icon-container"><span class="icon-eye"></span></span>
                                </button>

                                {{-- <!-- Delete Product (optional in inventory) -->
                                <form action="/" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="im-action-btn im-action-delete" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        <span class="icon-container"><span class="icon-trash"></span></span>
                                    </button>
                                </form> --}}

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center;">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $products->appends(request()->only(['sort', 'status', 'search']))->links('pagination::bootstrap-5') }}
        </div>

    </div>
</x-admin-layout>
