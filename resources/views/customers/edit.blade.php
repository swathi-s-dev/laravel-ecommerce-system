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
        <h2><i class="bi bi-pencil-square"></i> Edit Customer</h2>
    </div>

    <form action="{{ route('customers.update', $customer) }}"
          method="POST"
          id="customerEditForm">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- Name --}}
            <div class="col-md-6 mb-3">
                <label for="edit_name" class="form-label">Name</label>

                <input type="text"
                       name="name"
                       id="edit_name"
                       class="form-control"
                       value="{{ $customer->name }}" pattern="[A-Za-z ]+"
       title="Name can contain alphabets and spaces only">

                <small class="text-danger" id="edit_nameError"></small>
            </div>


            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label for="edit_email" class="form-label">Email</label>

                <input type="email"
                       name="email"
                       id="edit_email"
                       class="form-control"
                       value="{{ $customer->email }}">

                <small class="text-danger" id="edit_emailError"></small>
            </div>


            {{-- Phone --}}
            <div class="col-md-6 mb-3">
                <label for="edit_phone" class="form-label">Phone</label>

                <input type="text"
                       name="phone"
                       id="edit_phone"
                       class="form-control"
                       value="{{ $customer->phone }}">

                <small class="text-danger" id="edit_phoneError"></small>
            </div>


            {{-- City --}}
            <div class="col-md-6 mb-3">
                <label for="edit_city" class="form-label">City</label>

                <input type="text"
                       name="city"
                       id="edit_city"
                       class="form-control"
                       value="{{ $customer->city }}">

                <small class="text-danger" id="edit_cityError"></small>
            </div>


            {{-- State --}}
            <div class="col-md-6 mb-3">
                <label for="edit_state" class="form-label">State</label>

                <input type="text"
                       name="state"
                       id="edit_state"
                       class="form-control"
                       value="{{ $customer->state }}">

                <small class="text-danger" id="edit_stateError"></small>
            </div>


            {{-- Pincode --}}
            <div class="col-md-6 mb-3">
                <label for="edit_pincode" class="form-label">Pincode</label>

                <input type="text"
                       name="pincode"
                       id="edit_pincode"
                       class="form-control"
                       value="{{ $customer->pincode }}">

                <small class="text-danger" id="edit_pincodeError"></small>
            </div>


            {{-- Address --}}
            <div class="col-md-12 mb-3">
                <label for="edit_address" class="form-label">Address</label>

                <textarea name="address"
                          id="edit_address"
                          class="form-control"
                          rows="4">{{ $customer->address }}</textarea>

                <small class="text-danger" id="edit_addressError"></small>
            </div>


            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label for="edit_status" class="form-label">
                    Status
                </label>
                <select name="status" id="edit_status"class="form-select">
                    <option value="">Select Status</option>
                    <option value="1"{{ $customer->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $customer->status == 0 ? 'selected' : '' }}> Inactive</option>
                </select>
                <small class="text-danger" id="edit_statusError"></small>
            </div>

        </div>


        {{-- Buttons --}}
        <div class="mt-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i>Update Customer</button>
            <button type="button"class="cancel-button"id="cancelEditCustomer">Cancel</button>

        </div>

    </form>

</div>