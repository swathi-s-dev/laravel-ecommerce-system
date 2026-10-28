@extends('layouts.app')

@section('title', 'Order')

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
        <h3>Orders List</h3>
        <button type="button" class="add-btn" id="addOrder"><i class="bi bi-person-plus"></i>Add Order</button>
    </div>
   <div class="form-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th> Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr id="orderRow{{ $order->id }}">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($order->status === 'Completed') bg-success
                                @elseif($order->status === 'Cancelled') bg-danger
                                @elseif($order->status === 'Processing') bg-info text-dark
                                @else bg-warning text-dark
                                @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <button type="button"
                                    class="btn btn-info btn-sm viewOrder"
                                    data-id="{{ $order->id }}">
                                <i class="bi bi-eye"></i> 
                            </button>
                            <button type="button"  class="delete"  title="Delete" onclick="deleteOrder({{ $order->id }})"> <i class="bi bi-trash"></i> </button>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyOrderRow">
                        <td colspan="6">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
      <!-- Create Order Modal -->
    <div class="modal fade" id="OrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                 
                <div class="modal-body" id="OrderFormContainer"></div>
            </div>
        </div>
    </div>
      
    
    <!-- View Order Modal -->
    <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                <div class="modal-body" id="orderDetailsContent">

                    <!-- Order Information -->
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <label class="text-muted">Order ID</label>
                                <h5 id="viewOrderId">-</h5>

                                <label class="text-muted">Order Date</label>
                                <div id="viewOrderDate">-</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <label class="text-muted">Customer</label>
                                <h5 id="viewCustomerName">-</h5>

                                <label class="text-muted">Status</label>
                                <div>
                                    <span class="badge bg-primary" id="viewOrderStatus">
                                        -
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Ordered Products -->
                    <h6 class="mb-3">Ordered Products</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>

                            <tbody id="viewOrderItems">
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Select an order to view details.
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">
                                        Total Amount
                                    </th>
                                    <th class="text-end" id="viewTotalAmount">
                                        ₹0.00
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

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

    
    // Add Product button
    $('#addProductRow').on('click', function () {
        addProductRow();
    });

    function addProductRow() {
        const template = document.getElementById('productRowTemplate');

        if (!template) {
            console.error('Product row template not found.');
            return;
        }

        $('#orderItemsBody').append(
            template.content.cloneNode(true)
        );

        calculateTotal();
    }

    // Product selection: display price
    $(document).on('change', '.product-select', function () {
        const row = $(this).closest('tr');
        calculateRow(row);
    });

    // Quantity change
    $(document).on('input change', '.quantity-input', function () {
        const row = $(this).closest('tr');
        calculateRow(row);
    });

    function calculateRow(row) {
        const price = parseFloat(
            row.find('.product-select option:selected').attr('data-price')
        ) || 0;

        let quantity = parseInt(
            row.find('.quantity-input').val()
        ) || 1;

        if (quantity < 1) {
            quantity = 1;
            row.find('.quantity-input').val(1);
        }

        row.find('.price-cell').text('₹' + price.toFixed(2));

        row.find('.subtotal-cell').text(
            '₹' + (price * quantity).toFixed(2)
        );

        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;

        $('#orderItemsBody .product-row').each(function () {
            const price = parseFloat(
                $(this).find('.product-select option:selected')
                    .attr('data-price')
            ) || 0;

            const quantity = parseInt(
                $(this).find('.quantity-input').val()
            ) || 0;

            total += price * quantity;
        });

        $('#orderTotal').text(total.toFixed(2));
    }

    // Remove product row
    $(document).on('click', '.remove-product', function () {
        $(this).closest('tr').remove();

        if ($('#orderItemsBody .product-row').length === 0) {
            addProductRow();
        }

        calculateTotal();
    });

    // Create order using AJAX
    $(document).on('submit', '#createOrderForm', function(e) {
        e.preventDefault();

        $('#createOrderToast').addClass('d-none');
        $('#OrderError, #dateError, #itemsError').text('');

        if ($('#orderItemsBody .product-row').length === 0) {
            showToast('Please add a product.', 'danger');
            return;
        }

        let valid = true;
        const selectedProducts = [];

        $('#orderItemsBody .product-row').each(function () {
            const productId = $(this).find('.product-select').val();
            const quantity = parseInt(
                $(this).find('.quantity-input').val()
            );

            if (!productId || !quantity || quantity < 1) {
                valid = false;
            }

            if (productId && selectedProducts.includes(productId)) {
                valid = false;
            }

            selectedProducts.push(productId);
        });

        if (!valid) {
            showToast(
                'Select a product in each row, use a quantity of at least 1, and do not select the same product twice.',
                'danger'
            );
            return;
        }

        const button = $('#saveOrderBtn');
        showLoader();
        button.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/orders',
            type: 'POST',
            data: $(this).serialize(),

           success: function (response) {
                showToast(
                    response.message || 'Order created successfully!'
                );

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('OrderModal')
                ).hide();

                // Refresh only the order table, not the entire page.
                $.get("{{ route('orders.index') }}", function (html) {
                    const newTable = $(html).find('.form-container table');
                    $('.form-container table').replaceWith(newTable);
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;

                    if (errors.Order_id) {
                        $('#OrderError').text(errors.Order_id[0]);
                    }

                    if (errors.order_date) {
                        $('#dateError').text(errors.order_date[0]);
                    }

                    if (errors.product_id || errors.quantity) {
                        $('#itemsError').text(
                            (errors.product_id || errors.quantity)[0]
                        );
                    }

                    showToast('Please correct the form errors.', 'danger');
                } else {
                    showToast(
                        xhr.responseJSON?.message || 'Unable to save order.',
                        'danger'
                    );
                }
            },

            complete: function () {
                button.prop('disabled', false).text('Save Order');
                hideLoader();
            }
        });
    });

    function showToast(message) {
        $('#toastMessage').text(message);
        $('#successToast').css('display', 'flex').hide().fadeIn();

        setTimeout(function () {
            $('#successToast').fadeOut();
        }, 3000);
    }

   
   // VIEW ORDER using AJAX

    $(document).on('click', '.viewOrder', function () {

        const id = $(this).data('id');

        $('#viewOrderId, #viewOrderDate, #viewCustomerName, #viewOrderStatus')
            .text('-');

        $('#viewTotalAmount').text('₹0.00');

        $('#viewOrderItems').html(`
            <tr>
                <td colspan="4" class="text-center">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    Loading order details...
                </td>
            </tr>
        `);

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('viewOrderModal')
        ).show();

        $.ajax({
            url: "{{ url('orders') }}/" + id,
            type: 'GET',
            dataType: 'json',
            headers: {
                'Accept': 'application/json'
            },

            success: function (response) {

                const order = response.order;
                const customer = order.customer || {};
                const items = order.order_items || order.orderItems || [];

                $('#viewOrderId').text('#' + order.id);
                $('#viewOrderDate').text(order.order_date || 'N/A');
                $('#viewCustomerName').text(customer.name || 'N/A');
                $('#viewOrderStatus').text(order.status || 'N/A');

                let rows = '';

            

                items.forEach(function (item) {
                    const product = item.product || {};
                    const quantity = Number(item.quantity || 0);
                    const price = Number(item.price || 0);
                    const subtotal = Number(
                        item.subtotal ?? price * quantity
                    );

                    const row = $('<tr>');

                    $('<td>')
                        .text(product.name || 'Product unavailable')
                        .appendTo(row);

                    $('<td>')
                        .addClass('text-center')
                        .text(quantity)
                        .appendTo(row);

                    $('<td>')
                        .addClass('text-end')
                        .text('₹' + price.toFixed(2))
                        .appendTo(row);

                    $('<td>')
                        .addClass('text-end')
                        .text('₹' + subtotal.toFixed(2))
                        .appendTo(row);

                    rows += row.prop('outerHTML');
                });

                if (items.length === 0) {
                    rows = `
                        <tr>
                            <td colspan="4" class="text-center">
                                No order items found.
                            </td>
                        </tr>
                    `;
                }

                $('#viewOrderItems').html(rows);
                $('#viewTotalAmount').text(
                    '₹' + Number(order.total_amount || 0).toFixed(2)
                );
            },

            error: function (xhr) {
                console.error(xhr.status, xhr.responseText);

                $('#viewOrderItems').html(`
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Unable to load order details.
                        </td>
                    </tr>
                `);
            }
        });
    });

  // ADD ORDER - LOAD FORM USING AJAX
    $(document).on('click', '#addOrder', function () {
        showLoader();

        $.ajax({
            url: "{{ route('orders.create') }}",
            type: "GET",

            success: function (response) {
                $('#OrderFormContainer').html(response);

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('OrderModal')
                ).show();

                // Add the first product row after loading the form
                const template = document.getElementById('productRowTemplate');

                if (template) {
                    $('#orderItemsBody').empty();
                    $('#orderItemsBody').append(
                        template.content.cloneNode(true)
                    );
                }
            },

            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load Order form.');
            },

            complete: function () {
                hideLoader();
            }
        });
    });
    // DELETE Order

  
    window.deleteOrder = function (id) {
        if (!confirm('Are you sure you want to delete this order?')) {
            return;
        }

        $.ajax({
            url: "{{ url('orders') }}/" + id,
            type: "DELETE",

            success: function (response) {
                $('#orderRow' + id).remove();

                showToast(response.message || 'Order deleted successfully!');

                if ($('tbody tr[id^="orderRow"]').length === 0) {
                    $('tbody').html(`
                        <tr id="emptyOrderRow">
                            <td colspan="6">No orders found.</td>
                        </tr>
                    `);
                }
            },

            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to delete order.');
            }
        });
    };
  
});

</script>

@endpush

@endsection
