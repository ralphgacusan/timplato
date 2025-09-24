<x-admin-layout>
    @section('title', 'Product Management - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/product-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <!-- Product Management Content (main area) -->
    <div class="product-management-content">
        <h2>Product Management</h2>
        <div class="product-management-controls">
            <form method="GET" action="{{ route('admin.product-management') }}">
                <select name="sort" class="pm-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price (Low-High)
                    </option>
                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price (High-Low)
                    </option>
                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date Added (Newest)
                    </option>
                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date Added (Oldest)
                    </option>
                    </option>
                </select>

                <select name="category" class="pm-category" onchange="this.form.submit()">
                    <option value="">Category</option>
                    @foreach (\App\Models\Category::whereNull('parent_id')->get() as $mainCategory)
                        <option value="{{ $mainCategory->name }}"
                            {{ request('category') == $mainCategory->name ? 'selected' : '' }}>
                            {{ $mainCategory->name }}
                        </option>
                        @foreach ($mainCategory->children as $subCategory)
                            <option value="{{ $subCategory->name }}"
                                {{ request('category') == $subCategory->name ? 'selected' : '' }}>
                                └ {{ $subCategory->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>


                <input type="text" name="search" class="pm-search" placeholder="Search"
                    value="{{ request('search') }}">
                <button type="submit" class="pm-add-btn">Search</button>
            </form>

            <button class="pm-add-btn" onclick="window.location.href='{{ route('admin.products.create') }}'">
                Add Product
            </button>
        </div>

        <div class="pm-table-container">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Price</th> {{-- ✅ New Price column --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="pm-image-cell">
                                    @if ($product->images->count() > 0)
                                        @php
                                            $primaryImage = $product->images->where('is_primary', 1)->first();
                                        @endphp
                                        <img src="{{ $primaryImage ? asset('images/' . $primaryImage->image_url) : asset('images/no-image.png') }}"
                                            alt="{{ $product->name }}">
                                    @else
                                        {{-- Image Placeholder --}}
                                        {{-- <img src="{{ asset('img/product-placeholder.png') }}" alt="No Image"> --}}
                                    @endif
                                </div>
                            </td>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->main_category }}</td>
                            <td>{{ $product->sub_category }}</td>
                            <td>₱{{ number_format($product->price, 2) }}</td> {{-- ✅ Show formatted price --}}
                            <td>
                                <button class="pm-action-btn pm-action-edit" title="Edit"
                                    onclick="window.location.href='{{ route('admin.products.edit', ['product' => $product->product_id]) }}'">
                                    <span class="icon-container"><span class="icon-pencil"></span></span>
                                </button>
                                <form action="{{ route('admin.products.destroy', $product->product_id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="pm-action-btn pm-action-delete" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        <span class="icon-container"><span class="icon-trash"></span></span>
                                    </button>
                                </form>
                                <button class="pm-action-btn pm-action-view" title="View"
                                    onclick="window.location.href='{{ route('admin.show', $product->product_id) }}'">
                                    <span class="icon-container"><span class="icon-eye"></span></span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">No records available</td>
                            {{-- ✅ colspan updated --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $products->appends(request()->only(['search', 'category', 'sort']))->links('pagination::bootstrap-5') }}
        </div>




    </div>

</x-admin-layout>
