
<style>
    #ProductEditForm .product-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 20px;
    }

    #ProductEditForm .product-field {
        min-width: 0;
    }

    #ProductEditForm .product-field.full-width {
        grid-column: 1 / -1;
    }

    #ProductEditForm label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #344054;
    }

    #ProductEditForm .form-control,
    #ProductEditForm .form-select {
        width: 100%;
        min-height: 40px;
        padding: 9px 12px;
        border: 1px solid #d0d5dd;
        border-radius: 7px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .text-danger {
        color: #dc3545 !important;
        font-weight: bold;
    }
    #ProductEditForm textarea.form-control {
        min-height: 85px;
        resize: vertical;
    }

    #ProductEditForm .form-control:focus,
    #ProductEditForm .form-select:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.12);
    }

    #ProductEditForm .current-image {
        display: block;
        width: 85px;
        height: 85px;
        object-fit: cover;
        border: 1px solid #e4e7ec;
        border-radius: 8px;
        padding: 4px;
        margin-bottom: 8px;
    }

    #ProductEditForm .text-danger {
        display: block;
        margin-top: 4px;
        font-size: 12px;
    }

    #ProductEditForm .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }

    #ProductEditForm .btn-save {
        background: #198754;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 10px 17px;
    }

    #ProductEditForm .btn-save:hover {
        background: #157347;
    }

   #ProductEditForm .btn-cancel {
        background: rgb(36, 48, 221);
        color: white;
        border: 1px solid #d0d5dd;
        border-radius: 7px;
        padding: 10px 17px;
    }
    #ProductEditForm .btn-cancel:hover {
        background: #152673;
    }

    @media (max-width: 576px) {
        #ProductEditForm .product-form-grid {
            grid-template-columns: 1fr;
        }

        #ProductEditForm .product-field.full-width {
            grid-column: auto;
        }
    }
</style>

<form action="{{ route('products.update', $product) }}"
      method="POST"
      id="ProductEditForm"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="product-form-grid">

        <div class="product-field">
            <label>Current Image</label>

            @if($product->image)
                <img src="{{ asset('product-images/' . $product->image) }}"
                     class="current-image"
                     alt="{{ $product->name }}">
            @else
                <p class="text-muted small">No image uploaded.</p>
            @endif
        </div>

        <div class="product-field">
            <label for="image">Replace Image</label>
            <input type="file" name="image" id="image"
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.webp">
            <small class="text-danger" id="edit_imageError"></small>
        </div>

        <div class="product-field">
            <label for="name">Product Name  <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name"
                   class="form-control"
                   value="{{ old('name', $product->name) }}"
                   placeholder="Enter product name">
            <small class="text-danger" id="edit_nameError"></small>
        </div>

        <div class="product-field">
            <label for="category_id">Category  <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-danger" id="edit_category_idError"></small>
        </div>

        <div class="product-field">
            <label for="price">Price (₹)  <span class="text-danger">*</span></label>
            <input type="number" name="price" id="price"
                   class="form-control"
                   value="{{ old('price', $product->price) }}"
                   step="0.01" min="0">
            <small class="text-danger" id="edit_priceError"></small>
        </div>

        <div class="product-field">
            <label for="stock">Stock Quantity  <span class="text-danger">*</span></label>
            <input type="number" name="stock" id="stock"
                   class="form-control"
                   value="{{ old('stock', $product->stock) }}"
                   min="0">
            <small class="text-danger" id="edit_stockError"></small>
        </div>

        <div class="product-field">
            <label for="edit_status">Status  <span class="text-danger">*</span></label>
            <select name="status" id="edit_status" class="form-select">
                <option value="">Select status</option>
                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Stock In</option>
                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Stock Out</option>
            </select>
            <small class="text-danger" id="edit_statusError"></small>
        </div>

        <div class="product-field full-width">
            <label for="description">Description</label>
            <textarea name="description" id="description"
                      class="form-control"
                      placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
            <small class="text-danger" id="edit_descriptionError"></small>
        </div>

    </div>

    <div class="form-actions">
        <button type="button" class="btn-cancel" id="canceleditproduct">
            Cancel
        </button>

        <button type="submit" class="btn-save">
            <i class="bi bi-check-circle me-1"></i> Update Product
        </button>
    </div>
</form>
