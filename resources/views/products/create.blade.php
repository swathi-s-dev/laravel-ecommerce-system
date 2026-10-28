
<style>
    #productForm .product-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 20px;
    }

    
    #productForm .product-field {
        min-width: 0;
    }

    #productForm .product-field.full-width {
        grid-column: 1 / -1;
    }

    #productForm label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #344054;
    }

    #productForm .form-control,
    #productForm .form-select {
        width: 100%;
        min-height: 40px;
        padding: 9px 12px;
        border: 1px solid #d0d5dd;
        border-radius: 7px;
        font-size: 14px;
        box-sizing: border-box;
    }

    #productForm textarea.form-control {
        min-height: 85px;
        resize: vertical;
    }

    #productForm .form-control:focus,
    #productForm .form-select:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.12);
    }

    #productForm .text-danger {
        display: block;
        margin-top: 4px;
        font-size: 12px;
    }

    #productForm .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }

    #productForm .btn-save {
        background: #198754;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 10px 17px;
    }

    #productForm .btn-save:hover {
        background: #157347;
    }

    #productForm .btn-cancel {
        background: rgb(36, 48, 221);
        color: white;
        border: 1px solid #d0d5dd;
        border-radius: 7px;
        padding: 10px 17px;
    }
 #productForm .btn-cancel:hover {
        background: #152673;
    }
    @media (max-width: 576px) {
        #productForm .product-form-grid {
            grid-template-columns: 1fr;
        }

        #productForm .product-field.full-width {
            grid-column: auto;
        }
    }
</style>

<form action="{{ route('products.store') }}"
      method="POST"
      id="productForm"
      enctype="multipart/form-data">
    @csrf

    <div class="product-form-grid">

        <div class="product-field">
            <label for="name">Product Name   <span class="text-danger">*</span></span></label>
            <input type="text" name="name" id="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Enter product name">
            <small class="text-danger" id="nameError"></small>
        </div>

        <div class="product-field">
            <label for="category_id">Category  <span class="text-danger">*</span></span></label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-danger" id="category_idError"></small>
        </div>

        <div class="product-field">
            <label for="price">Price (₹) <span class="text-danger">*</span>
            </label>
            <input type="number" name="price" id="price"
                   class="form-control"
                   value="{{ old('price') }}"
                   step="0.01" min="0"
                   placeholder="Enter price">
            <small class="text-danger" id="priceError"></small>
        </div>

        <div class="product-field">
            <label for="stock">Stock Quantity  <span class="text-danger">*</span></label>
            <input type="number" name="stock" id="stock"
                   class="form-control"
                   value="{{ old('stock', 0) }}"
                   min="0" placeholder="Enter stock quantity">
            <small class="text-danger" id="stockError"></small>
        </div>

        <div class="product-field">
            <label for="status">Status  <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select">
                <option value="">Select status</option>
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Stock In</option>
                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Stock Out</option>
            </select>
            <small class="text-danger" id="statusError"></small>
        </div>

        <div class="product-field">
            <label for="image">Product Image</label>
            <input type="file" name="image" id="image"
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.webp">
            <small class="text-danger" id="imageError"></small>
        </div>

        <div class="product-field full-width">
            <label for="description">Description</label>
            <textarea name="description" id="description"
                      class="form-control"
                      placeholder="Enter product description">{{ old('description') }}</textarea>
            <small class="text-danger" id="descriptionError"></small>
        </div>

    </div>

    <div class="form-actions">
        <button type="button" class="btn-cancel" id="cancelProduct">
            Cancel
        </button>

        <button type="submit" class="btn-save">
            <i class="bi bi-check-circle me-1"></i> Save Product
        </button>
    </div>
</form>
