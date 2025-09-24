<x-admin-layout>
    @section('title', 'Edit Product - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/product-add.css') }}">
    @endpush

    <div class="add-product-content">
        <h2>Edit Product</h2>
        <form method="POST" action="{{ route('admin.products.update', ['product' => $product->product_id]) }}"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="add-product-grid">
                <!-- LEFT: Name and Description -->
                <div class="add-product-section add-product-desc">
                    <h3>Name and Description</h3>
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Product Name"
                        value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                    @enderror

                    <label for="description">Product Description</label>
                    <textarea id="description" name="description" placeholder="Enter Description" rows="6" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- RIGHT: Pricing and Stocks -->
                <div class="add-product-right">
                    <div class="add-product-section add-product-pricing">
                        <h3>Pricing and Stocks</h3>

                        <label for="price">Price</label>
                        <div class="input-icon">
                            <span class="peso-sign">&#8369;</span>
                            <input type="text" id="price" name="price"
                                value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                        </div>
                        @error('price')
                            <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                        @enderror

                        <div class="quantity-restock-row">
                            <div class="input-group">
                                <label for="stock_quantity">Quantity</label>
                                <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                                    step="1" placeholder="Enter Quantity"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                @error('stock_quantity')
                                    <span class="error-message"
                                        style="color:red; font-size:0.7rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label for="restock_level">Restock Level</label>
                                <input type="number" id="restock_level" name="restock_level" min="0"
                                    step="1" placeholder="Restock Level"
                                    value="{{ old('restock_level', $product->restock_level) }}" required>
                                @error('restock_level')
                                    <span class="error-message"
                                        style="color:red; font-size:0.7rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Category Section -->
                    <div class="add-product-section add-product-category">
                        <h3>Category</h3>

                        <!-- Main Category -->
                        <div class="category-row">
                            <label for="category_id">Product Category</label>
                            <select id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    @if (!$category->parent_id)
                                        <option value="{{ $category->category_id }}"
                                            {{ old('category_id', $parentCategoryId) == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div class="subcategory-row">
                            <label for="subcategory_id">Product Sub-Category</label>
                            <select id="subcategory_id" name="subcategory_id">
                                <option value="">Select Sub-Category</option>
                                @foreach ($subcategoriesByParent[$parentCategoryId] ?? [] as $sub)
                                    <option value="{{ $sub->category_id }}"
                                        {{ old('subcategory_id', $selectedSubcategoryId) == $sub->category_id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <script>
                        const mainCategorySelect = document.getElementById('category_id');
                        const subCategorySelect = document.getElementById('subcategory_id');

                        // Preloaded subcategories grouped by parent_id
                        const subcategories = @json($subcategoriesByParent);

                        function populateSubcategories(parentId, selectedId = null) {
                            subCategorySelect.innerHTML = '<option value="">Select Sub-Category</option>';

                            if (subcategories[parentId]) {
                                subcategories[parentId].forEach(sub => {
                                    const option = document.createElement('option');
                                    option.value = sub.category_id;
                                    option.textContent = sub.name;
                                    if (selectedId && selectedId == sub.category_id) {
                                        option.selected = true;
                                    }
                                    subCategorySelect.appendChild(option);
                                });
                            }
                        }

                        // Populate subcategory on page load
                        populateSubcategories('{{ $parentCategoryId }}', '{{ $selectedSubcategoryId }}');

                        // Update subcategory when main category changes
                        mainCategorySelect.addEventListener('change', function() {
                            populateSubcategories(this.value);
                        });
                    </script>

                </div>
            </div>

            <!-- BOTTOM: Product Images -->
            <div class="add-product-section add-product-images">
                <h3>Product Images</h3>
                <div class="image-upload-scroll">
                    <div class="image-upload-list" id="imageUploadList">
                        @foreach ($product->images as $img)
                            <div class="preview-item" data-image-id="{{ $img->id }}">
                                <span class="preview-number">{{ $loop->iteration }}</span>
                                <button type="button" class="remove-btn"
                                    data-index="{{ $loop->index }}">&times;</button>
                                <img src="{{ asset('images/' . $img->image_url) }}" alt="Preview">
                            </div>
                        @endforeach
                        <label class="image-upload-box">
                            <input type="file" name="images[]" accept="image/*" multiple style="display:none;"
                                id="productImages">
                            <div class="icon-container">
                                <span class="icon-image-plus"></span>
                            </div>
                            <span class="upload-text">Click to Upload</span>
                        </label>
                        @error('images')
                            <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Hidden input to track deleted images (move OUTSIDE dynamic list) -->
                <input type="hidden" name="deleted_images" id="deletedImages" value="">

                <div class="add-product-actions">
                    <button type="reset" class="clear-all-btn">Clear All</button>
                    <button type="submit" class="add-product-btn">Update Product</button>
                </div>
            </div>

            <script>
                const productImagesInput = document.getElementById('productImages');
                const imageUploadList = document.getElementById('imageUploadList');
                const deletedImagesInput = document.getElementById('deletedImages');
                let previewFiles = [];
                const MAX_IMAGES = 5;

                // Helper to get number of existing images not deleted
                function existingImagesCount() {
                    return imageUploadList.querySelectorAll('.preview-item:not(.uploaded)').length;
                }

                // Handle new file selection
                productImagesInput.addEventListener('change', function(event) {
                    const selectedFiles = Array.from(event.target.files);

                    // Calculate total images after adding new files
                    const totalImages = existingImagesCount() + previewFiles.length + selectedFiles.length;

                    if (totalImages > MAX_IMAGES) {
                        alert(`You can only have up to ${MAX_IMAGES} images in total.`);
                        return;
                    }

                    previewFiles.push(...selectedFiles);
                    renderUploadedPreviews();
                });

                function renderUploadedPreviews() {
                    // Remove only uploaded previews, keep existing ones
                    imageUploadList.querySelectorAll('.preview-item.uploaded').forEach(el => el.remove());

                    previewFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.classList.add('preview-item', 'uploaded');
                            div.innerHTML = `
                    <span class="preview-number">New</span>
                    <button type="button" class="remove-btn" data-index="${index}">&times;</button>
                    <img src="${e.target.result}" alt="Preview">
                `;
                            imageUploadList.insertBefore(div, imageUploadList.querySelector('.image-upload-box'));
                        };
                        reader.readAsDataURL(file);
                    });

                    updateFileList();
                }

                imageUploadList.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-btn')) {
                        const previewItem = e.target.closest('.preview-item');

                        // If existing image, mark for deletion
                        if (previewItem.dataset.imageId) {
                            const deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];
                            const imageId = previewItem.dataset.imageId;
                            if (!deletedImages.includes(imageId)) {
                                deletedImages.push(imageId);
                                deletedImagesInput.value = deletedImages.join(',');
                            }
                        }

                        // If newly uploaded image
                        if (previewItem.classList.contains('uploaded')) {
                            const idx = parseInt(e.target.dataset.index);
                            previewFiles.splice(idx, 1);
                            renderUploadedPreviews();
                            return;
                        }

                        // Remove from DOM
                        previewItem.remove();

                        // Re-number existing images
                        let counter = 1;
                        imageUploadList.querySelectorAll('.preview-item:not(.uploaded)').forEach(item => {
                            item.querySelector('.preview-number').textContent = counter++;
                        });

                        console.log('Deleted Images:', deletedImagesInput.value); // for debugging
                    }
                });

                // Update input.files for form submission
                function updateFileList() {
                    const dataTransfer = new DataTransfer();
                    previewFiles.forEach(file => dataTransfer.items.add(file));
                    productImagesInput.files = dataTransfer.files;
                }
            </script>

        </form>
    </div>


</x-admin-layout>
