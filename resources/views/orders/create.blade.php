
<div class="container-fluid p-3">
    <div class="bg-white rounded-3 p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <i class="bi bi-cart-plus me-2"></i>Create Order
            </h4>
            <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>
        </div>

        <div id="createOrderToast" class="alert d-none" role="alert"></div>

        <form id="createOrderForm">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="customerError"></small>
                </div>

                <div class="col-md-6">
                    <label for="order_date" class="form-label">Order Date</label>
                    <input type="date" name="order_date" id="order_date"
                           class="form-control" value="{{ date('Y-m-d') }}" required>
                    <small class="text-danger" id="dateError"></small>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Order Products</h5>
                <button type="button" id="addProductRow" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Add Product
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

            <div class="text-end mb-3">
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

            <div class="d-flex gap-2">
                <button type="submit" id="saveOrderBtn" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Save Order
                </button>
                <button type="button" id="cancelOrder" class="btn btn-secondary">
                    Cancel
                </button>
            </div>
        </form>

        <template id="productRowTemplate">
            <tr class="product-row">
                <td>
                    <select name="product_id[]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock }}"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                {{ $product->name }}
                                (Stock: {{ $product->stock }})
                                {{ $product->stock <= 0 ? '- Out of Stock' : '' }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]"
                           class="form-control quantity-input"
                           value="1" min="1" max="{{ $products->max('stock') ?? 1 }}" required>
                </td>
                <td class="price-cell">₹0.00</td>
                <td class="subtotal-cell">₹0.00</td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-product">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        </template>

    </div>
</div>
