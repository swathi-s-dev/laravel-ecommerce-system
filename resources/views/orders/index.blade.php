<!DOCTYPE html>
<html>
    <head>
        <title>Orders List</title>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 30px;
                background: #f8f9fa;
            }

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
    </head>
<body>


    <div class="header">
        <h3>Orders List</h3>
        <button type="button" class="add-btn" id="addOrder"><i class="bi bi-person-plus"></i>Add Order</button>
    </div>

   <div class="form-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order</th>
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
                        <td>{{ $order->Order->name ?? 'N/A' }}</td>
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
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="btn btn-info btn-sm">View</a>
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
        <div id="OrderModal" style="display:none;">
            <div id="OrderFormContainer"></div>
        </div>
    </div>
          <div id="successToast" class="success-toast">
            <i class="bi bi-check-circle-fill"></i>
            <span id="toastMessage"></span>
        </div>
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

    // Add one product row automatically when the page opens
    addProductRow();

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
    $('#createOrderForm').on('submit', function (e) {
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

        button.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/orders',
            type: 'POST',
            data: $(this).serialize(),

            success: function (response) {
                showToast(
                    response.message || 'Order created successfully!',
                    'success'
                );

                setTimeout(function () {
                    window.location.href = '/orders';
                }, 1000);
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

    // ADD Order 
    $('#addOrder').click(function () {
        showLoader();
        $.ajax({
            url: "{{ route('orders.create') }}",
            type: "GET",
            success: function (response) {
                $('#OrderFormContainer').html(response);
                $('#OrderModal').show();
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

    function deleteOrder(id) {
        if (!confirm('Are you sure you want to delete this Order?')) {
            return;
        }
        $.ajax({
            url: "{{ url('orders') }}/" + id,
            type: "DELETE",
            success: function (response) {
                $('#Order-' + id).remove();
                showToast(response.message);
                if ($('tbody tr[id^="Order-"]').length === 0) {
                    $('tbody').html(`
                        <tr id="noorders">
                            <td colspan="9">
                                No Order found.
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Unable to delete Order.');

            }

        });

    }
  
});

</script>

</body>
</html>
