<style>
    /* Main form box */
    .form-container {
        background: #fff;
        width: 600px;
        max-width: 90%;
        margin: 20px auto;
        padding: 20px 25px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        box-sizing: border-box;
    }
    /* Header */
    .header {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    .header i {
        margin-right: 6px;
    }
    /* Two fields in one row */
    .col-md-6 {
        width: 50%;
        padding: 0 7px;
        box-sizing: border-box;
    }

    .col-md-12 {
        width: 100%;
        padding: 0 7px;
        box-sizing: border-box;
    }
    /* Labels */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
    }
    /* Small input boxes */
    .form-control,
    .form-select {
        width: 75%;
        height: 34px;
        padding: 5px 8px;
        font-size: 13px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-sizing: border-box;
    }
    /* Address box */
    textarea.form-control {
        width: 90%;
        height: 65px;
        resize: none;
    }
    /* Field spacing */
    .mb-3 {
        margin-bottom: 12px !important;
    }
    /* Error message */
    .text-danger {
        display: block;
        min-height: 15px;
        margin-top: 2px;
        font-size: 11px;
    }
    /* Buttons */
    .mt-3 {
        display: flex;
        gap: 8px;
        margin-top: 8px !important;
        padding-left: 7px;
    }
    /* Save */
    .btn-primary {
        min-width: 125px;
        height: 36px;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        font-size: 13px;
        cursor: pointer;
    }
    .btn-primary i {
        margin-right: 5px;
    }
    /* Cancel */
    .cancel-button {
        min-width: 80px;
        height: 36px;
        padding: 6px 12px;
        background: white;
        color: #6c757d;
        border: 1px solid #6c757d;
        border-radius: 5px;
        font-size: 13px;
        cursor: pointer;
    }
    .cancel-button:hover {
        background: #6c757d;
        color: white;
    }
    /* Mobile */
    @media (max-width: 768px) {

        .form-container {
            width: 95%;
            padding: 18px;
        }
        .col-md-6,
        .col-md-12 {
            width: 100%;
        }
        .form-control,
        .form-select,
        textarea.form-control {
            width: 90%;
        }
    }
</style>

<div class="form-container">

    <div class="header">
        <h2><i class="bi bi-pencil-square"></i> Edit Product</h2>
    </div>
  

    <form action="{{ route('products.update', $product) }}"
          method="POST" id="ProductEditForm"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')


          <!-- Current Image -->

        <div class="col-md-6 mb-3">

            <label>
                Current Image
            </label>

            @if($product->image)

                <img src="{{ asset('product-images/' . $product->image) }}"
                     class="current-image">

            @else

                <p>No image uploaded.</p>

            @endif

        </div>

        <!-- New Image -->

        <div class="col-md-6 mb-3">

            <label for="image">
                Replace Image
            </label>

            <input type="file"
                   name="image"
                   id="image"
                   accept=".jpg,.jpeg,.png,.webp">

        </div>

        <!-- Category -->

        <div class="col-md-6 mb-3">

            <label for="category_id"> Category </label>

            <select name="category_id" id="category_id">

                <option value=""> -- Select Category --</option>
                @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}

                    </option>

                @endforeach

            </select>

        </div>

        <!-- Product Name -->

        <div class="col-md-6 mb-3">

            <label for="name">
                Product Name
            </label>

            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $product->name) }}"
                   placeholder="Enter product name">
               <small class="text-danger" id="nameError"></small>
        </div>

        <!-- Description -->

        <div class="col-md-6 mb-3">

            <label for="description">
                Description
            </label>

            <textarea name="description"
                      id="description"
                      placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>

        </div>

        <!-- Price -->

        <div class="col-md-6 mb-3">

            <label for="price">
                Price
            </label>

            <input type="number"
                   name="price"
                   id="price"
                   value="{{ old('price', $product->price) }}"
                   step="0.01"
                   min="0">
               <small class="text-danger" id="priceError"></small>

        </div>

        <!-- Stock -->

        <div class="col-md-6 mb-3">

            <label for="stock">
                Stock
            </label>

            <input type="number"
                   name="stock"
                   id="stock"
                   value="{{ old('stock', $product->stock) }}"
                   min="0">
               <small class="text-danger" id="stockError"></small>
        </div>

        {{-- Status --}}
        <div class="col-md-6 mb-3">
            <label for="edit_status" class="form-label">
                Status
            </label>
            <select name="status" id="edit_status"class="form-select">
                <option value="">Select Status</option>
                <option value="1"{{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}> Inactive</option>
            </select>
            <small class="text-danger" id="edit_statusError"></small>
        </div>

        

       {{-- Buttons --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i>Update Product</button>
            <button type="button"class="cancel-button"id="canceleditproduct">Cancel</button>

        </div>

    </form>

</div>