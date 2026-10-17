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
.header {
    border-bottom: 1px solid #ddd;
    margin-bottom: 12px;
    padding-bottom: 8px;
}

.header h2 {
    margin: 0;
    font-size: 19px;
}

.header i {
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

/* Address */
textarea.form-control {
    width: 380px;
    height: 55px;
    border-radius: 10px;
    resize: none;
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

    textarea.form-control {
        width: 100%;
    }
}
</style>

<div class="form-container">

    <div class="header">
        <h2><i class="bi bi-person-plus-fill"></i> Add Customer</h2>
    </div>

    <form action="{{ route('customers.store') }}"
          method="POST"
          id="customerForm">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="name" class="form-label"> Customer Name:
                    <input type="text"
                        name="name"
                        id="name"
                        class="form-control" pattern="[A-Za-z ]+"
                        title="Name can contain alphabets and spaces only">
                </label>
                       <small class="text-danger" id="nameError"></small>

            </div>


            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email:

                    <input type="email"
                        name="email"
                        id="email"
                        class="form-control">
                </label>
                <small class="text-danger" id="emailError"></small>
            </div>


            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone
                    <input type="text" name="phone" id="phone" class="form-control" maxlength="10"pattern="[0-9]{10}" inputmode="numeric"title="Phone number must contain exactly 10 digits">
                    <small class="text-danger" id="phoneError"></small>
                </label>    
            </div>


            <div class="col-md-6 mb-3">
                <label for="city" class="form-label">City
                    <input type="text"
                        name="city"
                        id="city"
                        class="form-control" pattern="[A-Za-z ]+"title="City can contain alphabets and spaces only">
                    <small class="text-danger" id="cityError"></small>
                </label>

                </div>


            <div class="col-md-6 mb-3">
                <label for="state" class="form-label">State

                    <input type="text"
                        name="state"
                        id="state"
                        class="form-control" pattern="[A-Za-z ]+"title="State can contain alphabets and spaces only">
                </label>
                    <small class="text-danger" id="stateError"></small>
            </div>


            <div class="col-md-6 mb-3">
                <label for="pincode" class="form-label">Pincode
                    <input type="text" name="pincode" id="pincode"class="form-control" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" title="Pincode must contain exactly 6 digits">
                    <small class="text-danger" id="pincodeError"></small>
                </label>
            </div>


            <div class="col-md-12 mb-3">
                <label for="address" class="form-label">Address

                    <textarea name="address"
                            id="address"
                            class="form-control"
                            rows="4"></textarea>

                    <small class="text-danger" id="addressError"></small>
                </label>
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

        </div>

        {{-- Buttons --}}
        <div class="mt-3">

            <button type="submit" class="btn btn-primary"> <i class="bi bi-check-circle"></i>Save Customer</button>
            <button type="button" class="cancel-button" id="cancelCustomer">Cancel</button>
        </div>

    </form>

</div>