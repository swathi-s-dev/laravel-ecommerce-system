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
        <h2><i class="bi bi-person-plus-fill"></i> Add Category</h2>
    </div>

  <form action="{{ route('categories.store') }}"
          method="POST"
          id="categoryForm">
            @csrf
            
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name:
                    <input type="text"
                        name="name"
                        id="name" placeholder="Enter category name"
                        class="form-control" pattern="[A-Za-z ]+"
                        title="Name can contain alphabets and spaces only">
                </label>
                       <small class="text-danger" id="nameError"></small>

            </div>
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

            <button type="submit" class="btn btn-primary"> <i class="bi bi-check-circle"></i>Save Category</button>
            <button type="button" class="cancel-button" id="cancelCategory">Cancel</button>
        </div>

    </form>

</div>