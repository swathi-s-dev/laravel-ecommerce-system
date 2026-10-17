
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .payment-form {
            max-width: 650px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        .form-control, .form-select {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container payment-form">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Payment</h2>
        <a href="{{ route('payments.page') }}" class="btn btn-secondary">Back</a>
    </div>

    <div id="message"></div>

    <form id="paymentForm">
        <div class="mb-3">
            <label class="form-label">Order</label>
            <select name="order_id" id="order_id" class="form-select" required>
                <option value="">Select Order</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (₹)</label>
            <input type="number" name="amount" class="form-control"
                   min="0.01" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select" required>
                <option value="">Select Method</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="UPI">UPI</option>
                <option value="Net Banking">Net Banking</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Transaction ID (optional)</label>
            <input type="text" name="transaction_id" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Failed">Failed</option>
                <option value="Refunded">Refunded</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Date</label>
            <input type="date" name="payment_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" id="savePayment">
            Save Payment
        </button>
    </form>
</div>

<script>
$(document).ready(function () {

    // Load orders for the dropdown through AJAX
    $.ajax({
        url: "{{ route('payments.create.data') }}",
        type: "GET",
        dataType: "json",
        headers: { Accept: "application/json" },

        success: function (response) {
            let options = '<option value="">Select Order</option>';

            $.each(response.orders, function (i, order) {
                let customer = order.customer
                    ? order.customer.name
                    : 'N/A';

                options += `
                    <option value="${order.id}">
                        Order #${order.id} - ${escapeHtml(customer)}
                    </option>`;
            });

            $('#order_id').html(options);
        },

        error: function (xhr) {
            console.error(xhr.responseText);
            $('#message').html(
                '<div class="alert alert-danger">Unable to load orders.</div>'
            );
        }
    });

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    // Save payment through AJAX
    $('#paymentForm').on('submit', function (e) {
        e.preventDefault();

        const button = $('#savePayment');

        button.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('payments.store') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },

            success: function (response) {
                $('#message').html(
                    '<div class="alert alert-success">' +
                    escapeHtml(response.message) + '</div>'
                );

                $('#paymentForm')[0].reset();

                setTimeout(function () {
                    window.location.href = "{{ route('payments.page') }}";
                }, 1000);
            },

            error: function (xhr) {
                let message = 'Unable to save payment.';

                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    message = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join('<br>');
                }

                $('#message').html(
                    '<div class="alert alert-danger">' + message + '</div>'
                );
            },

            complete: function () {
                button.prop('disabled', false).text('Save Payment');
            }
        });
    });
});
</script>

</body>
</html>
