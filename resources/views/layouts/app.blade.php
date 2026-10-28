
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ShopSphere') | ShopSphere</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>

 <aside class="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-bag-check-fill"></i>
        </div>
        <span>ShopSphere</span>
    </div>

    <div class="nav-heading">MENU</div>

    <nav>
        <a href="{{ url('/dashboard') }}"
        class="side-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>

        <a href="{{ url('/customers') }}"
        class="side-link {{ request()->is('customers*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Customers
        </a>

        <a href="{{ url('/categories') }}"
        class="side-link {{ request()->is('categories*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            Categories
        </a>

        <a href="{{ url('/products') }}"
        class="side-link {{ request()->is('products*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            Products
        </a>

        <a href="{{ url('/orders') }}"
        class="side-link {{ request()->is('orders*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            Orders
        </a>

        <a href="{{ url('/payments') }}"
        class="side-link {{ request()->is('payments*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-fill"></i>
            Payment
        </a>
    </nav>

    <div class="sidebar-footer">
        <i class="bi bi-shield-check me-2"></i>
        E-commerce Management System
    </div>
</aside>


{{-- Main Page Content --}}
<main class="main">
    @yield('content')
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
