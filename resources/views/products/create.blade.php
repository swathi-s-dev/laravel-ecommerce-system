<style>
/* Main form box */
.form-container {
    background: #fff;
    width: 620px;
    max-width: 95%;
    margin: 20px auto;
    padding: 18px 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    box-sizing: border-box;
}

/* Header */
.crud-header {
    border-bottom: 1px solid #ddd;
    margin-bottom: 12px;
    padding-bottom: 8px;
}

.crud-header h2 {
    margin: 0;
    font-size: 19px;
}

.crud-header i {
    margin-right: 6px;
}

/* Row */
.row {
    display: flex;
    flex-wrap: wrap;
}

/* Two fields in one row */
.col-md-6 {
    width: 50%;
    padding: 0 5px;
    box-sizing: border-box;
}

.col-md-12 {
    width: 100%;
    padding: 0 5px;
    box-sizing: border-box;
}

/* Labels */
.form-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 500;
}

/* CURVED INPUT FIELDS */
.form-control,
.form-select {
    width: 145px;
    height: 30px;
    padding: 4px 9px;
    font-size: 13px;

    border: 1px solid #ced4da;
    border-radius: 15px;       /* curved edges */
    outline: none;
    box-sizing: border-box;
}

/* Input focus */
.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.1);
}



/* Field spacing */
.mb-3 {
    margin-bottom: 3px !important;
}

/* Error */
.text-danger {
    display: block;
    font-size: 11px;
}

/* Buttons */
.mt-3 {
    display: flex;
    gap: 8px;
    margin-top: 8px !important;
    padding-left: 5px;
}

/* Save */
.btn-primary {
    min-width: 125px;
    height: 34px;
    padding: 5px 12px;
    border: none;
    border-radius: 17px;
    font-size: 13px;
    cursor: pointer;
}

.btn-primary i {
    margin-right: 5px;
}

/* Cancel */
.cancel-button {
    min-width: 80px;
    height: 34px;
    padding: 5px 12px;
    background: white;
    color: #6c757d;
    border: 1px solid #6c757d;
    border-radius: 17px;
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
        padding: 15px;
    }

    .col-md-6,
    .col-md-12 {
        width: 100%;
    }

    .form-control,
    .form-select {
        width: 170px;
    }
}
</style>

<div class="form-container">

    <div class="header">
        <h2><i class="bi bi-person-plus-fill"></i> Add Product</h2>
    </div>

        <form action="{{ route('products.store') }}" method="POST" id="productForm" enctype="multipart/form-data">
            @csrf
              <!-- Image -->

            <div class="col-md-6 mb-3">

                <label for="image">Product Image
                    <input type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp">
                </label>
                    <small class="text-danger" id="imageError"></small>

            </div>
          
            <div class="col-md-6 mb-3">

                <label for="name"> Product Name

                    <input type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Enter product name">
                </label>
                    <small class="text-danger" id="nameError"></small>

            </div>

              <div class="col-md-6 mb-3">
                <label for="category_id"> Category Name
                    <select name="category_id" id="category_id">
                        <option value="">
                            -- Select Category --
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>
                 </label>
                    <small class="text-danger" id="category_idError"></small>

            </div>
             <!-- Description -->

        <div class="col-md-6 mb-3">

            <label for="description">Description
                <textarea name="description"
                        id="description"
                        placeholder="Enter product description" value= "{{  old('description')  }}"></textarea>
            </label>
                    <small class="text-danger" id="descriptionError"></small>

        </div>
            <!-- Price -->

            <div class="col-md-6 mb-3">

                <label for="price"> Price

                    <input type="number"
                        name="price"
                        id="price"
                        value="{{ old('price') }}"
                        step="0.01"
                        min="0"
                        placeholder="Enter price">
                </label>
                    <small class="text-danger" id="priceError"></small>
        

            </div>

            <!-- Stock -->

            <div class="col-md-6 mb-3">

                <label for="stock">Stock
                    <input type="number"
                        name="stock"
                        id="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                        placeholder="Enter stock quantity">
                </label>
                    <small class="text-danger" id="stockError"></small>

            </div>

          

            <!-- Status -->

            <div class="col-md-6 mb-3">

                <label for="status" class="form-label">Status
                    <select name="status"
                            id="status"
                            class="form-select">

                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>

                    <small class="text-danger" id="statusError"></small>
                </label>
            </div>

           
                {{-- Buttons --}}
        <div class="mt-3">

            <button type="submit" class="btn btn-primary"> <i class="bi bi-check-circle"></i>Save Product</button>
            <button type="button" class="cancel-button" id="cancelProduct">Cancel</button>
        </div>

    </form>
