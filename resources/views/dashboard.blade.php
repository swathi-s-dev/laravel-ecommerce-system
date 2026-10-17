
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-commerce Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            max-width: 1100px;
            margin: 40px auto;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
            text-align: center;
            height: 100%;
        }

        .stat-card h5 {
            color: #666;
            font-size: 16px;
        }

        .stat-card h2 {
            font-weight: bold;
            margin-top: 12px;
        }
    </style>
</head>
<body>

<div class="container dashboard">
    <h2 class="mb-4">E-commerce Dashboard</h2>

    <div id="message"></div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total Customers</h5>
                <h2 id="totalCustomers">0</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total Categories</h5>
                <h2 id="totalCategories">0</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total Products</h5>
                <h2 id="totalProducts">0</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <h5>Total Orders</h5>
                <h2 id="totalOrders">0</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <h5>Total Order Value (₹)</h5>
                <h2 id="totalSales">0.00</h2>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $.ajax({
        url: "{{ route('dashboard.data') }}",
        type: "GET",
        dataType: "json",
        headers: {
            Accept: "application/json"
        },

        success: function (response) {
            $('#totalCustomers').text(response.totalCustomers);
            $('#totalCategories').text(response.totalCategories);
            $('#totalProducts').text(response.totalProducts);
            $('#totalOrders').text(response.totalOrders);
            $('#totalSales').text(
                Number(response.totalSales).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        },

        error: function (xhr) {
            console.error(xhr.responseText);
            $('#message').html(
                '<div class="alert alert-danger">Unable to load dashboard data.</div>'
            );
        }
    });
});
</script>

</body>
</html>
