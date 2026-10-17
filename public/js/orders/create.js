
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
