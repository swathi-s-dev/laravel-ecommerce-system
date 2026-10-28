{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .order-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
        }

        .details-table th,
        .details-table td {
            text-align: center;
            vertical-align: middle;
        }

        .info-card {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 8px;
            height: 100%;
        }

        .total-amount {
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container order-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Order Details</h1>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            Back to Orders
        </a>
    </div>

    <hr>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="info-card">
                <h6>Order ID ---------</h6>
                <h4>#{{ $order->id }}</h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-card">
                <h6>Customer</h6>
                <h5>{{ $order->customer->name ?? 'N/A' }}</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-card">
                <h6>Order Date</h6>
                <h5>
                    {{ $order->order_date
                        ? \Carbon\Carbon::parse($order->order_date)->format('d-m-Y')
                        : 'N/A' }}
                </h5>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <strong>Status:</strong>

        @php
            $statusColors = [
                'Pending' => 'warning',
                'Processing' => 'info',
                'Completed' => 'success',
                'Cancelled' => 'danger',
            ];
        @endphp

        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
            {{ $order->status }}
        </span>
    </div>

    <h4 class="mb-3">Ordered Products ---</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped details-table">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($order->orderItems as $item)
                    <tr>
                        <td>
                            {{ $item->product->name ?? 'Product unavailable' }}
                        </td>
                        <td>
                            ₹{{ number_format($item->price, 2) }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            ₹{{ number_format($item->subtotal, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No products found for this order.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-end mt-4">
        <span class="total-amount">
            Total: ₹{{ number_format($order->total_amount, 2) }}
        </span>
    </div>

</div>

</body>
</html> --}}
