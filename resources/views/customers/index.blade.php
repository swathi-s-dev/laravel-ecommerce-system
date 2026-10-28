@extends('layouts.app')

@section('title', 'Customer')

@section('content')

<style> 
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
    }

    .add-btn {
        background: #198754;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }

    .add-btn:hover {
        background: #157347;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #f2f2f2;
    }

    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
    }

    .status-active {
        color: green;
        font-weight: bold;
    }

    .status-inactive {
        color: red;
        font-weight: bold;
    }

    .action-link {
        font-size: 18px;
        text-decoration: none;
        margin: 0 5px;
    }

    .edit {
        color: blue;
    }


    .delete {
        color: #dc3545;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 18px;
        margin: 0 5px;
    }


        .success-toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translate(-50%);
            background: #198754;
            color: white;
            padding: 14px 25px;
            border-radius: 6px;

            display: none;
            align-items: center;
            gap: 10px;

            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 9999;
        }

        .success-toast i {
            font-size: 20px;
        }
        .loader {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #ddd;
        border-top: 4px solid #198754;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
  
    <div class="header">
        <h1>Customer List</h1>
        <button type="button" class="add-btn" id="addCustomer"><i class="bi bi-person-plus"></i>Add Customer</button>
    </div>
    <div class="form-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Pincode</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                   <tr id="customer-{{ $customer->id }}">
                        <td>{{ $customer-> name}}</td>
                        <td>{{ $customer-> email}}</td>
                        <td>{{ $customer-> phone}}</td>
                        <td>{{ $customer-> address }}</td>
                        <td>{{ $customer-> city}}</td>
                        <td>{{ $customer-> state}}</td>
                        <td>{{ $customer-> pincode}}</td>
                        <td>
                            @if($customer->status)
                                <span class="status-active">Active</span>
                            @else
                                <span class="status-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="action-link edit editCustomer"  data-id="{{ $customer->id }}"title="Edit">  <i class="bi bi-pencil"></i></button>
                            <button type="button"  class="delete"  title="Delete" onclick="deleteCustomer({{ $customer->id }})"> <i class="bi bi-trash"></i> </button>

                       
                        </td>
                    </tr>
                @empty

                    <tr id="noCustomers">
                        <td colspan="9">
                            No customer found.
                        </td>
                    </tr>

                @endforelse
            </tbody>
            
        </table>
        <div id="customerModal" style="display:none;">
            <div id="customerFormContainer"></div>
        </div>
    </div>
        <div id="successToast" class="success-toast">
            <i class="bi bi-check-circle-fill"></i>
            <span id="toastMessage"></span>
        </div>
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>

@push('scripts')
<script>
$(document).ready(function () {

// CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  
    function showLoader() {
        $('#loader').show();
    }
    function hideLoader() {
        $('#loader').hide();
    }

// ADD CUSTOMER 
    $('#addCustomer').click(function () {
        showLoader();
        $.ajax({
            url: "{{ route('customers.create') }}",
            type: "GET",
            success: function (response) {
                $('#customerFormContainer').html(response);
                $('#customerModal').show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load customer form.');
            },
            complete: function () {
                hideLoader();
            }
        });
    });


   
// SAVE CUSTOMER
    $(document).on('submit', '#customerForm', function (e) {
        e.preventDefault();
        let form = this;
        showLoader();

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: $(form).serialize(),
            headers: {
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log(response);
                $('#customerModal').hide();
                $('#customerFormContainer').html('');
                $('#noCustomers').remove();
                let customer = response.customer;
            
                $('tbody').append(`
                    <tr id="customer-${customer.id}">
                        <td>${customer.name}</td>
                        <td>${customer.email}</td>
                        <td>${customer.phone}</td>
                        <td>${customer.address}</td>
                        <td>${customer.city}</td>
                        <td>${customer.state}</td>
                        <td>${customer.pincode}</td>
                        <td>
                            ${customer.status == 1
                                ? '<span class="status-active">Active</span>'
                                : '<span class="status-inactive">Inactive</span>'
                            }
                        </td>

                        <td>
                            <button type="button"
                                    class="action-link edit editCustomer"
                                    data-id="${customer.id}"
                                    title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button type="button"
                                    class="delete"
                                    title="Delete"
                                    onclick="deleteCustomer(${customer.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);

                showToast(response.message);

            },
            error: function (xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                    $.each(errors, function (field, messages) {
                        $('#' + field + 'Error').text(messages[0]);
                    });
                } else {
                    alert('Unable to save customer.');
                }
            },
            complete: function () {
                hideLoader();
            }
        });
    });


// EDIT CUSTOMER 

    $(document).on('submit', '#customerEditForm', function(e) {
        e.preventDefault();
        let form = this;
        showLoader();
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                let customer = response.customer;
                let row = $('#customer-' + customer.id);

                // Update table values
                row.find('td:eq(0)').text(customer.name);
                row.find('td:eq(1)').text(customer.email);
                row.find('td:eq(2)').text(customer.phone);
                row.find('td:eq(3)').text(customer.address);
                row.find('td:eq(4)').text(customer.city);
                row.find('td:eq(5)').text(customer.state);
                row.find('td:eq(6)').text(customer.pincode);

                // Update status
                if (customer.status == 1) {
                    row.find('td:eq(7)').html(
                        '<span class="status-active">Active</span>'
                    );
                } else {
                    row.find('td:eq(7)').html(
                        '<span class="status-inactive">Inactive</span>'
                    );
                }

                // Close modal
                $('#customerModal').hide();
                $('#customerFormContainer').html('');

                // Show success toast
                showToast(response.message);
            },

            error: function(xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                    $.each(errors, function(field, messages) {
                        $('#edit_' + field + 'Error').text(messages[0]);
                    });
                } else {
                    alert('Unable to update customer.');
                }
            },
            complete: function () {
                hideLoader();
            }
        });
    });


    // EDIT CUSTOMER - OPEN FORM

    $(document).on('click', '.editCustomer', function () {

        let id = $(this).data('id');
        showLoader();
        $.ajax({
            url: "{{ url('customers') }}/" + id + "/edit",
            type: "GET",
            success: function (response) {
                $('#customerFormContainer').html(response);
                $('#customerModal').show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load customer edit form.');
            },
            complete: function () {
                hideLoader();
            }
        });

    });

    $(document).on('click', '#cancelEditCustomer', function() {

        $('#customerModal').hide();
        $('#customerFormContainer').html('');

    });

    // CANCEL CUSTOMER

    $(document).on('click', '#cancelCustomer', function () {
        
        $('#customerForm')[0].reset();
        $('.text-danger').text('');
        $('#customerModal').hide();
        $('#customerFormContainer').html('');

    });

    function showToast(message) {
        $('#toastMessage').text(message);
        $('#successToast').css('display', 'flex').hide().fadeIn();

        setTimeout(function () {
            $('#successToast').fadeOut();
        }, 3000);
    }

// DELETE CUSTOMER

    function deleteCustomer(id) {
        if (!confirm('Are you sure you want to delete this customer?')) {
            return;
        }
        $.ajax({
            url: "{{ url('customers') }}/" + id,
            type: "DELETE",
            success: function (response) {
                $('#customer-' + id).remove();
                showToast(response.message);
                if ($('tbody tr[id^="customer-"]').length === 0) {
                    $('tbody').html(`
                        <tr id="noCustomers">
                            <td colspan="9">
                                No customer found.
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Unable to delete customer.');

            }

        });

    }
  
});    

</script>
@endpush

@endsection