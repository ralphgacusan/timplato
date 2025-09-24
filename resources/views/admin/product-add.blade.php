<x-admin-layout>
    @section('title', 'Add Product - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/product-add.css') }}">
    @endpush

    <!-- Add Product Form -->
    <div class="add-product-content">
        <h2>Add Product</h2>
        <form id="addProductForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            <div class="add-product-grid">
                <!-- LEFT: Name and Description -->
                <div class="add-product-section add-product-desc">
                    <h3>Name and Description</h3>
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Product Name"
                        value="{{ old('name') }}" required>

                    <label for="description">Product Description</label>
                    <textarea id="description" name="description" placeholder="Enter Description" rows="6" required>{{ old('description') }}</textarea>
                </div>

                <!-- RIGHT: Pricing and Stocks -->
                <div class="add-product-right">
                    <div class="add-product-section add-product-pricing">
                        <h3>Pricing and Stocks</h3>

                        <label for="price">Price</label>
                        <div class="input-icon">
                            <span class="peso-sign">&#8369;</span>
                            <input type="text" id="price" name="price" value="{{ old('price') }}"
                                placeholder="0.00" required>
                        </div>

                        <script>
                            const priceInput = document.getElementById('price');

                            function formatPrice(value) {
                                value = value.replace(/[^0-9.]/g, '');
                                let [integerPart, decimalPart] = value.split('.');
                                if (integerPart) {
                                    integerPart = parseInt(integerPart || 0, 10).toLocaleString();
                                }
                                if (decimalPart !== undefined) {
                                    decimalPart = decimalPart.slice(0, 2);
                                    return `${integerPart}.${decimalPart}`;
                                } else {
                                    return integerPart;
                                }
                            }

                            priceInput.addEventListener('input', function(e) {
                                this.value = formatPrice(this.value);
                            });

                            // Initialize formatted price on page load
                            window.addEventListener('load', function() {
                                if (priceInput.value) {
                                    priceInput.value = formatPrice(priceInput.value);
                                }
                            });
                        </script>

                        <div class="quantity-restock-row">
                            <div class="input-group">
                                <label for="stock_quantity">Quantity</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                                    step="1" placeholder="Enter Quantity" value="{{ old('stock_quantity') }}"
                                    required>
                            </div>
                            <div class="input-group">
                                <label for="restock_level">Restock Level</label>
                                <input type="number" id="restock_level" name="restock_level" min="0"
                                    step="1" placeholder="Restock Level" value="{{ old('restock_level') }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="add-product-section add-product-category">
                        <h3>Category</h3>
                        <div class="category-row">
                            <label for="category_id">Product Category</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    @if (!$category->parent_id)
                                        <option value="{{ $category->category_id }}"
                                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="subcategory-row">
                            <label for="subcategory_id">Product Sub-Category</label>
                            <select id="subcategory_id" name="subcategory_id">
                                <option value="">Select Sub-Category</option>
                                {{-- Preload old subcategories if form validation fails --}}
                                @if (old('category_id'))
                                    @foreach ($subcategoriesByParent[old('category_id')] ?? [] as $sub)
                                        <option value="{{ $sub->category_id }}"
                                            {{ old('subcategory_id') == $sub->category_id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <script>
                        const mainCategorySelect = document.getElementById('category_id');
                        const subCategorySelect = document.getElementById('subcategory_id');

                        // Preloaded subcategories grouped by parent_id (PHP array)
                        const subcategories = @json($subcategoriesByParent);

                        mainCategorySelect.addEventListener('change', function() {
                            const mainId = this.value;
                            subCategorySelect.innerHTML = '<option value="">Select Sub-Category</option>';

                            if (subcategories[mainId]) {
                                subcategories[mainId].forEach(sub => {
                                    const option = document.createElement('option');
                                    option.value = sub.category_id;
                                    option.textContent = sub.name;
                                    subCategorySelect.appendChild(option);
                                });
                            }
                        });
                    </script>

                </div>
            </div>

            <!-- BOTTOM: Product Image -->
            <div class="add-product-section add-product-images">
                <h3>Product Images</h3>
                <div class="image-upload-scroll">
                    <div class="image-upload-list" id="imageUploadList">
                        <label class="image-upload-box">
                            <input type="file" name="images[]" accept="image/*" multiple style="display:none;"
                                id="productImages">
                            <div class="icon-container">
                                <span class="icon-image-plus"></span>
                            </div>
                            <span class="upload-text">Click to Upload</span>
                        </label>
                    </div>
                </div>
                <div class="add-product-actions">
                    <button type="reset" class="clear-all-btn">Clear All</button>
                    <button type="submit" class="add-product-btn">Add Product</button>
                </div>
            </div>

        </form>
    </div>

    <script>
        const productImagesInput = document.getElementById('productImages');
        const imageUploadList = document.getElementById('imageUploadList');
        let previewFiles = []; // to track selected files
        const MAX_IMAGES = 5;

        // Preload old files if exists
        @if (old('images'))
            // Normally file inputs cannot retain old files. For preview only, you need backend temp storage.
            // Here we just skip; user will need to re-upload.
        @endif

        // Listen for new file selection
        productImagesInput.addEventListener('change', function(event) {
            const selectedFiles = Array.from(event.target.files);

            // Check if adding these files exceeds MAX_IMAGES
            if (previewFiles.length + selectedFiles.length > MAX_IMAGES) {
                alert(`You can only upload up to ${MAX_IMAGES} images.`);
                return;
            }

            previewFiles.push(...selectedFiles);
            renderPreviews();
        });

        // Render previews in the order of previewFiles
        function renderPreviews() {
            // Remove all previous preview items except the upload box
            imageUploadList.querySelectorAll('.preview-item').forEach(el => el.remove());

            previewFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('preview-item');
                    div.innerHTML = `
                        <span class="preview-number">${index + 1}</span>
                        <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                        <img src="${e.target.result}" alt="Preview">
                    `;
                    // Insert the preview before the upload box (keeps upload box at the end)
                    imageUploadList.insertBefore(div, imageUploadList.querySelector('.image-upload-box'));
                };
                reader.readAsDataURL(file);
            });

            updateFileList();
        }

        // Use event delegation for remove buttons
        imageUploadList.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                const idx = parseInt(e.target.dataset.index);
                previewFiles.splice(idx, 1);
                renderPreviews(); // re-render to update numbers and order
            }
        });

        // Update the <input type="file"> to match previewFiles
        function updateFileList() {
            const dataTransfer = new DataTransfer();
            previewFiles.forEach(file => dataTransfer.items.add(file));
            productImagesInput.files = dataTransfer.files;
        }
    </script>
</x-admin-layout>
