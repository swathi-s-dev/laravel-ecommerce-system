
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container py-5">
    <div class="crud-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Create Order</h3>
        </div>

        <div id="createOrderToast" class="alert d-none" role="alert"></div>

        <form id="createOrderForm">
            @csrf

            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger small" id="customerError"></div>
            </div>

            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date</label>
                <input type="date" name="order_date" id="order_date"
                       class="form-control" value="{{ date('Y-m-d') }}" required>
                <div class="text-danger small" id="dateError"></div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Order Products</h5>
                <button type="button" id="addProductRow" class="btn btn-success btn-sm">
                    + Add Product
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="orderItemsBody"></tbody>
                </table>
            </div>

            <div id="itemsError" class="text-danger small mb-3"></div>

            <div class="text-end mb-4">
                <h5>Total Amount: ₹<span id="orderTotal">0.00</span></h5>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Order Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <button type="submit" id="saveOrderBtn" class="btn btn-primary">
                Save Order
            </button>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>

        <template id="productRowTemplate">
            <tr class="product-row">
                <td>
                    <select name="product_id[]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]"
                           class="form-control quantity-input"
                           value="1" min="1" required>
                </td>
                <td class="price-cell">₹0.00</td>
                <td class="subtotal-cell">₹0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-product">
                        Remove
                    </button>
                </td>
            </tr>
        </template>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/orders/create.js') }}"></script>

</body>
</html>

