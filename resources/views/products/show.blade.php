<!doctype html>
<html>
<head>
    <title>Products view</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-btn {
            background: green;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
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

        .edit {
            color: orange;
            font-size: 20px;
            text-decoration: none;
            margin-right: 10px;
        }

        .delete {
            color: red;
            font-size: 20px;
            border: none;
            background: none;
            cursor: pointer;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="header">

    <h1>Products View</h1>

    {{-- <a href="{{ route('') }}" class="add-btn">
        <i class="bi bi-plus"></i>
 
    </a> --}}

</div>

@if(session('success'))

    <div class="success">
        {{ session('success') }}
    </div>

@endif

<table>

    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
           
        </tr>
    </thead>

    <tbody>

        @forelse($products as $product)

            <tr>

                <td>

                    @if($product->image)

                        <img src="{{ asset('products/' . $product->image) }}"
                             class="product-image">

                    @else

                        No Image

                    @endif

                </td>

                <td>
                    {{ $product->name }}
                </td>

                <td>
                    {{ $product->category->name }}
                </td>

                <td>
                    ₹{{ number_format($product->price, 2) }}
                </td>

                <td>
                    {{ $product->stock }}
                </td>

                <td>

                    @if($product->status)

                        <span class="status-active">
                            Active
                        </span>

                    @else

                        <span class="status-inactive">
                            Inactive
                        </span>

                    @endif

                </td>

               

            </tr>

        @empty

            <tr>

                <td colspan="7" style="text-align:center;">
                    No products found.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

</body>
</html>