
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .payment-container {
            max-width: 850px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        .info-box {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 8px;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="container payment-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payment Details</h2>

        <a href="{{ route('payments.page') }}"
           class="btn btn-secondary">
            Back to Payments
        </a>
    </div>

    <hr>

    <div class="row g-3">

        <div class="col-md-6">
            <div class="info-box">
                <strong>Payment ID</strong>
                <h5>{{ $payment->id }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Order ID</strong>
                <h5>{{ $payment->order_id }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Customer Name</strong>
                <h5>{{ $payment->order->customer->name ?? 'N/A' }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Amount</strong>
                <h5>₹{{ number_format((float) $payment->amount, 2) }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Payment Method</strong>
                <h5>{{ $payment->payment_method }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Transaction ID</strong>
                <h5>{{ $payment->transaction_id ?: 'N/A' }}</h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Status</strong>
                <h5>
                    @php
                        $colors = [
                            'Pending' => 'warning',
                            'Completed' => 'success',
                            'Failed' => 'danger',
                            'Refunded' => 'secondary'
                        ];
                    @endphp

                    <span class="badge bg-{{ $colors[$payment->status] ?? 'secondary' }}">
                        {{ $payment->status }}
                    </span>
                </h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <strong>Payment Date</strong>
                <h5>
                    {{ $payment->payment_date
                        ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y')
                        : 'N/A' }}
                </h5>
            </div>
        </div>

    </div>

</div>

</body>
</html>
