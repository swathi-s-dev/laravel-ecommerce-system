
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Payments List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .payment-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        #loader {
            display: none;
        }
    </style>
</head>

<body>

<div class="container payment-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Payments List</h1>

        <button type="button" class="btn btn-primary" id="addPayment">
            <i class="bi bi-plus-circle"></i> Add Payment
        </button>
    </div>

    <div id="loader" class="text-center mb-3">
        <div class="spinner-border text-primary"></div>
        <p>Loading payments...</p>
    </div>

    <div id="message"></div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Payment ID</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="paymentTable">
                <tr>
                    <td colspan="8">Loading payments...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function () {

    // Load payments using AJAX
    function loadPayments() {
        $('#loader').show();

        $.ajax({
            url: "{{ route('payments.index') }}",
            type: "GET",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },

            success: function (response) {
                let rows = '';

                if (response.payments.length === 0) {
                    rows = '<tr><td colspan="8">No payments found.</td></tr>';
                } else {
                    $.each(response.payments, function (index, payment) {
                        let customer = payment.order &&
                                       payment.order.customer
                            ? payment.order.customer.name
                            : 'N/A';

                        let date = payment.payment_date
                            ? payment.payment_date.substring(0, 10)
                            : 'N/A';

                        let statusClass = {
                            Pending: 'warning',
                            Completed: 'success',
                            Failed: 'danger',
                            Refunded: 'secondary'
                        }[payment.status] || 'secondary';

                        rows += `
                            <tr id="paymentRow${payment.id}">
                                <td>${payment.id}</td>
                                <td>${payment.order_id}</td>
                                <td>${escapeHtml(customer)}</td>
                                <td>₹${Number(payment.amount).toFixed(2)}</td>
                                <td>${escapeHtml(payment.payment_method)}</td>
                                <td>
                                    <span class="badge bg-${statusClass}">
                                        ${escapeHtml(payment.status)}
                                    </span>
                                </td>
                                <td>${date}</td>
                                <td>
                                    <button class="btn btn-info btn-sm viewPayment"
                                            data-id="${payment.id}">
                                        <i class="bi bi-eye"></i> View
                                    </button>

                                    <button class="btn btn-danger btn-sm deletePayment"
                                            data-id="${payment.id}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>`;
                    });
                }

                $('#paymentTable').html(rows);
            },

            error: function (xhr) {
                console.error(xhr.responseText);
                $('#paymentTable').html(
                    '<tr><td colspan="8">Unable to load payments.</td></tr>'
                );
            },

            complete: function () {
                $('#loader').hide();
            }
        });
    }

    // Escape text before inserting server-provided values into HTML
    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    // Add Payment button
    $('#addPayment').on('click', function () {
        window.location.href = "{{ route('payments.create') }}";
    });

    // View Payment details
    $(document).on('click', '.viewPayment', function () {
    let id = $(this).data('id');

    window.location.href = "{{ url('payments') }}/" + id;
});

    // Delete Payment
    $(document).on('click', '.deletePayment', function () {
        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this payment?')) {
            return;
        }

        $.ajax({
            url: "{{ url('payments') }}/" + id,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },

            success: function (response) {
                $('#paymentRow' + id).remove();
                $('#message').html(
                    '<div class="alert alert-success">' +
                    escapeHtml(response.message) + '</div>'
                );

                if ($('#paymentTable tr[id^="paymentRow"]').length === 0) {
                    $('#paymentTable').html(
                        '<tr><td colspan="8">No payments found.</td></tr>'
                    );
                }
            },

            error: function (xhr) {
                console.error(xhr.responseText);
                $('#message').html(
                    '<div class="alert alert-danger">Unable to delete payment.</div>'
                );
            }
        });
    });

    // Initial AJAX load
    loadPayments();
});
</script>

</body>
</html>
