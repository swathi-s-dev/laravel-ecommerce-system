@extends('layouts.app')

@section('title', 'products')

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

        <h1>Products List</h1>
        <button type="button" class="add-btn" id="addProduct"><i class="bi bi-person-plus"></i>Add Product</button>

    </div>
    <div class="form-container">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td>
                            @if($product->image)
                                <img
                                    src="{{ asset('product-images/' . $product->image) }}"
                                    class="product-image"alt="{{ $product->name }}">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                        <td>{{ $product->description }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->status)
                                <span class="status-active">Stock In</span>
                            @else
                                <span class="status-inactive">Stock Out</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="action-link edit editProduct" data-id="{{ $product->id }}" title="edit"> <i class="bi bi-pencil"></i></button>
                            <button type="button"
                                    class="delete deleteProduct"
                                    data-id="{{ $product->id }}"
                                    title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty

                    <tr id="noProduct">
                        <td colspan="8">
                            No products found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
        <div class="modal fade" id="productModal" tabindex="-1"
     aria-labelledby="productModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="bi bi-box-seam me-2"></i>
                    Product Details
                </h5>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="productFormContainer"></div>
            </div>

        </div>
    </div>
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

// ADD product 
    $('#addProduct').click(function () {
        showLoader();
        $.ajax({
            url: "{{ route('products.create') }}",
            type: "GET",
            success: function (response) {
                $('#productFormContainer').html(response);

                $('#productModalLabel').html(
                    '<i class="bi bi-plus-circle me-2"></i>Add Product'
                );

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('productModal')
                ).show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load product form.');
            },
            complete: function () {
                hideLoader();
            }
        });
    });


   
// SAVE product
    $(document).on('submit', '#productForm', function (e) {
        e.preventDefault();
        let form = this;
        showLoader();

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            processData: false,
            headers: {
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log(response);
                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('productModal')
                ).hide();

                $('#productFormContainer').html('');
                $('#noProduct').remove();      
                let product = response.product;
            $('tbody').append(`
                <tr id="product-${product.id}">
                    <td>
                        ${product.image
                            ? `<img src="/product-images/${product.image}"
                                    class="product-image"
                                    alt="${product.name}">`
                            : 'No Image'}
                    </td>

                    <td>${product.name ?? ''}</td>
                    <td>${product.category?.name ?? 'No Category'}</td>
                    <td>${product.description ?? ''}</td>
                    <td>₹${Number(product.price ?? 0).toFixed(2)}</td>
                    <td>${product.stock ?? 0}</td>

                    <td>
                        ${product.status == 1
                            ? '<span class="status-active">Active</span>'
                            : '<span class="status-inactive">Inactive</span>'}
                    </td>

                    <td>
                        <button type="button"
                                class="action-link edit editProduct"
                                data-id="${product.id}"
                                title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button type="button"
                                class="delete deleteProduct"
                                data-id="${product.id}"
                                title="Delete">
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
                    alert('Unable to save product.');
                }
            },
            complete: function () {
                hideLoader();
            }
        });
    });

// EDIT product - UPDATE

$(document).on('submit', '#ProductEditForm', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    formData.set('_method', 'PUT');

    showLoader();

    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'Accept': 'application/json'
        },
        // Keep your existing success, error and complete callbacks here
        success: function (response) {
            let product = response.product;
            let row = $('#product-' + product.id);

            // Image
            row.find('td:eq(0)').html(
                product.image
                    ? `<img src="/product-images/${product.image}"
                            class="product-image"
                            alt="${product.name}">`
                    : 'No Image'
            );

            // Product details
            row.find('td:eq(1)').text(product.name ?? '');
            row.find('td:eq(2)').text(
                product.category?.name ?? 'No Category'
            );
            row.find('td:eq(3)').text(product.description ?? '');
            row.find('td:eq(4)').text(
                '₹' + Number(product.price ?? 0).toFixed(2)
            );
            row.find('td:eq(5)').text(product.stock ?? 0);

            // Status
            row.find('td:eq(6)').html(
                product.status == 1
                    ? '<span class="status-active">Active</span>'
                    : '<span class="status-inactive">Inactive</span>'
            );

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('productModal')
            ).hide();

            $('#productFormContainer').html('');

            showToast(response.message);
        },

        error: function (xhr) {
            console.log(xhr.responseText);

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                $('.text-danger').text('');

                $.each(errors, function (field, messages) {
                    $('#edit_' + field + 'Error').text(messages[0]);
                    $('#' + field + 'Error').text(messages[0]);
                });
            } else {
                alert('Unable to update product.');
            }
        },

        complete: function () {
            hideLoader();
        }
    });
});
    


    // EDIT product - OPEN FORM

    $(document).on('click', '.editProduct', function () {

        let id = $(this).data('id');
        showLoader();
        $.ajax({
            url: "{{ url('products') }}/" + id + "/edit",
            type: "GET",
            success: function (response) {
                $('#productFormContainer').html(response);

                $('#productModalLabel').html(
                    '<i class="bi bi-pencil-square me-2"></i>Edit Product'
                );

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('productModal')
                ).show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load product edit form.');
            },
            complete: function () {
                hideLoader();
            }
        });

    });

    $(document).on('click', '#cancelProduct, #canceleditproduct', function () {
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('productModal')
        ).hide();

        $('#productFormContainer').html('');
    });

    function showToast(message) {
        $('#toastMessage').text(message);
        $('#successToast').css('display', 'flex').hide().fadeIn();

        setTimeout(function () {
            $('#successToast').fadeOut();
        }, 3000);
    }

    $(document).on('click', '.deleteProduct', function () {
        let id = $(this).data('id');
        deleteProduct(id);
    });


// DELETE product
    

    function deleteProduct(id) {
        if (!confirm('Are you sure you want to delete this product?')) {
            return;
        }
        $.ajax({
            url: "{{ url('products') }}/" + id,
            type: "DELETE",
            success: function (response) {
                $('#product-' + id).remove();
                showToast(response.message);
                if ($('tbody tr[id^="product-"]').length === 0) {
                    $('tbody').html(`
                        <tr id="noProduct">
                            <td colspan="8">
                                No product found.
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Unable to delete product.');

            }

        });

    }
  
});    

</script>
@endpush

@endsection