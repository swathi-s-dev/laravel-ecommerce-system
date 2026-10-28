
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <style>
        :root {
            --primary: #5b5ce2;
            --sidebar: #171b35;
            --background: #f5f6fb;
            --muted: #8b90a5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: #252943;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            padding: 28px 18px;
            background: var(--sidebar);
            color: white;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            margin: 0 8px 42px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--primary);
            font-size: 23px;
        }

        .nav-heading {
            margin: 22px 10px 12px;
            color: #9298b5;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.4px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            margin: 5px 0;
            border-radius: 10px;
            color: #b7bdd5;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .side-link i {
            font-size: 18px;
        }

        .side-link:hover,
        .side-link.active {
            background: #30365b;
            color: white;
        }

        .side-link.active {
            box-shadow: inset 3px 0 #8585ff;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 25px;
            left: 25px;
            right: 25px;
            padding-top: 18px;
            border-top: 1px solid #343954;
            color: #aeb4cc;
            font-size: 12px;
        }

        .main {
            margin-left: 250px;
            padding: 30px 35px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
        }

        .page-title {
            margin: 0;
            font-size: 27px;
            font-weight: 750;
            letter-spacing: -.6px;
        }

        .subtitle {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            width: 220px;
            background: white;
            border: 1px solid #e9eaf2;
            border-radius: 10px;
            color: #9297aa;
        }

        .search-box input {
            width: 100%;
            min-width: 0;
            border: 0;
            outline: 0;
            font-size: 13px;
        }

        .admin-avatar {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e4e5ff;
            color: var(--primary);
            font-size: 20px;
        }

        .section-heading {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid #eceef5;
            border-radius: 16px;
            padding: 23px;
            min-width: 0;
            box-shadow: 0 4px 18px rgba(35, 42, 80, .025);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(35, 42, 80, .07);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label {
            color: #858ba1;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            font-size: 21px;
        }

        .purple {
            background: #eeedff;
            color: #6865e8;
        }

        .blue {
            background: #e6f2ff;
            color: #3687db;
        }

        .green {
            background: #e1f8ef;
            color: #16a477;
        }

        .orange {
            background: #fff0df;
            color: #e79535;
        }

        .pink {
            background: #ffe8f0;
            color: #e65b92;
        }

        .stat-number {
            margin-top: 19px;
            font-size: 30px;
            line-height: 1.2;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .stat-description {
            color: #9a9fb1;
            font-size: 12px;
            margin-top: 8px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(240px, 1fr);
            gap: 22px;
            margin-top: 28px;
        }

        .panel {
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #eceef5;
            background: white;
            min-width: 0;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .panel-heading h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .panel-heading span {
            font-size: 12px;
            color: var(--muted);
        }

        .welcome-panel {
            border: 0;
            color: white;
            background: linear-gradient(120deg, #5556d8, #8580f4);
        }

        .welcome-panel h3 {
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .welcome-panel p {
            font-size: 13px;
            line-height: 1.8;
            color: #eeeeff;
            margin-bottom: 22px;
        }

        .welcome-icon {
            font-size: 39px;
            margin-bottom: 14px;
        }

        .quick-actions {
            display: grid;
            gap: 12px;
        }

        .quick-action {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px;
            border: 1px solid #eef0f6;
            border-radius: 11px;
            text-decoration: none;
            color: #353952;
            transition: .2s;
        }

        .quick-action:hover {
            background: #f8f8ff;
            border-color: #dcdcff;
        }

        .quick-action .action-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #efeeff;
            color: var(--primary);
            font-size: 19px;
        }

        .quick-action strong {
            display: block;
            font-size: 13px;
        }

        .quick-action small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        #message {
            margin-bottom: 18px;
        }

        @media (max-width: 1100px) {
            .sidebar {
                width: 215px;
            }

            .main {
                margin-left: 215px;
                padding: 25px 22px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .admin-dropdown {
            position: relative;
        }

        .admin-avatar {
            border: none;
            cursor: pointer;
            transition: .2s ease;
        }

        .admin-avatar:hover {
            background: #d7d8ff;
            transform: translateY(-1px);
        }

        .admin-dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 255px;
            background: #fff;
            border: 1px solid #eceef5;
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 12px 35px rgba(25, 30, 65, .15);
            z-index: 2000;
        }

        .admin-dropdown-menu[hidden] {
            display: none;
        }

        .admin-dropdown-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 10px;
        }

        .admin-avatar-large {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e4e5ff;
            color: #5b5ce2;
            font-size: 21px;
        }

        .admin-dropdown-header strong {
            display: block;
            font-size: 13px;
            color: #252943;
        }

        .admin-dropdown-header small {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            color: #8b90a5;
        }

        .admin-dropdown-divider {
            height: 1px;
            background: #eceef5;
            margin: 6px 0;
        }

        .admin-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 11px 12px;
            border: none;
            border-radius: 9px;
            background: transparent;
            color: #454961;
            text-align: left;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            transition: .2s ease;
        }

        .admin-dropdown-item i {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }

        .admin-dropdown-item:hover {
            background: #f4f4ff;
            color: #5b5ce2;
        }

        .logout-item {
            color: #dc3545;
        }

        .logout-item:hover {
            background: #fff0f1;
            color: #c82333;
        }

        @media (max-width: 650px) {
            .sidebar {
                position: static;
                width: 100%;
                padding: 16px;
            }

            .brand {
                margin: 0 5px 15px;
            }

            .nav-heading,
            .sidebar-footer {
                display: none;
            }

            .sidebar nav {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .side-link {
                padding: 9px 10px;
                margin: 0;
                font-size: 12px;
            }

            .side-link i {
                font-size: 15px;
            }

            .main {
                margin-left: 0;
                padding: 23px 15px;
            }

            .topbar {
                align-items: flex-start;
                margin-bottom: 25px;
            }

            .page-title {
                font-size: 23px;
            }

            .top-actions {
                gap: 8px;
            }

            .search-box {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .stat-card {
                padding: 19px;
            }

            .stat-number {
                font-size: 27px;
            }

            .panel {
                padding: 19px;
            }
        }
    </style> --}}


{{-- <aside class="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-bag-check-fill"></i>
        </div>
        <span>ShopSphere</span>
    </div>

    <div class="nav-heading">MENU</div>

    <nav>
        <a href="{{ url('/dashboard') }}" class="side-link active">
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>

        <a href="{{ url('/customers') }}" class="side-link">
            <i class="bi bi-people"></i>
            Customers
        </a>

        <a href="{{ url('/categories') }}" class="side-link">
            <i class="bi bi-tags"></i>
            Categories
        </a>

        <a href="{{ url('/products') }}" class="side-link">
            <i class="bi bi-box-seam"></i>
            Products
        </a>

        <a href="{{ url('/orders') }}" class="side-link">
            <i class="bi bi-receipt"></i>
            Orders
        </a>
        <a href="{{ url('/payments') }}" class="side-link">
            <i class="bi bi-credit-card-fill"></i>
            Payment
        </a>
    </nav>

    <div class="sidebar-footer">
        <i class="bi bi-shield-check me-2"></i>
        E-commerce Management System
    </div>
</aside> --}}



    <header class="topbar">
        <div>
            <h1 class="page-title">Dashboard Overview</h1>
            <p class="subtitle">Welcome back! Here's what's happening in your store.</p>
        </div>

        <div class="top-actions">
            <label class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" placeholder="Search dashboard..."
                       aria-label="Search dashboard">
            </label>

            
<div class="admin-dropdown">
    <button type="button"
            class="admin-avatar"
            id="adminDropdownBtn"
            aria-label="Admin menu"
            aria-expanded="false"
            aria-controls="adminDropdownMenu">
        <i class="bi bi-person-fill"></i>
    </button>

    <div class="admin-dropdown-menu" id="adminDropdownMenu" hidden>

        <div class="admin-dropdown-header">
            <div class="admin-avatar-large">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <strong>Administrator</strong>
                <small>Store Management</small>
            </div>
        </div>

        <div class="admin-dropdown-divider"></div>

            {{-- <a href="{{ url('/profile') }}" class="admin-dropdown-item">
                <i class="bi bi-person-circle"></i>
                My Profile
            </a> --}}

            {{-- <a href="{{ url('/settings') }}" class="admin-dropdown-item">
                <i class="bi bi-gear"></i>
                Settings
            </a>

            <a href="{{ url('/notifications') }}" class="admin-dropdown-item">
                <i class="bi bi-bell"></i>
                Notifications
            </a>

            <a href="{{ url('/change-password') }}" class="admin-dropdown-item">
                <i class="bi bi-shield-lock"></i>
                Change Password
            </a> --}}

            <div class="admin-dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="admin-dropdown-item logout-item">
                    <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>

            </div>
        </div>

        </div>
    </header>

    <div id="message" role="status"></div>

    <div class="section-heading">Store Statistics</div>

    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Customers</span>
                <div class="stat-icon purple">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-number" id="totalCustomers">—</div>
            <div class="stat-description">Registered customers</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Categories</span>
                <div class="stat-icon orange">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
            <div class="stat-number" id="totalCategories">—</div>
            <div class="stat-description">Product categories</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Products</span>
                <div class="stat-icon blue">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
            <div class="stat-number" id="totalProducts">—</div>
            <div class="stat-description">Products in your store</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Orders</span>
                <div class="stat-icon green">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
            </div>
            <div class="stat-number" id="totalOrders">—</div>
            <div class="stat-description">Orders recorded</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Order Value</span>
                <div class="stat-icon pink">
                    <i class="bi bi-currency-rupee"></i>
                </div>
            </div>
            <div class="stat-number">
                ₹<span id="totalSales">0.00</span>
            </div>
            <div class="stat-description">Total recorded order value</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Store Status</span>
                <div class="stat-icon green">
                    <i class="bi bi-activity"></i>
                </div>
            </div>
            <div class="stat-number" style="font-size:25px">Active</div>
            <div class="stat-description">Your dashboard is ready</div>
        </div>

    </section>

    <section class="content-grid">

        <div class="panel welcome-panel">
            <div class="welcome-icon">
                <i class="bi bi-shop-window"></i>
            </div>

            <h3>Manage Your Store</h3>

            <p>
                Keep track of customers, products, categories and orders
                from one place. Use the navigation menu to manage your store.
            </p>

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span class="small">Store management dashboard</span>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <h3>Quick Access</h3>
                <span>Manage your store</span>
            </div>

            <div class="quick-actions">
                <a href="{{ url('/customers') }}" class="quick-action">
                    <div class="action-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div>
                        <strong>Manage Customers</strong>
                        <small>View and manage customers</small>
                    </div>
                </a>

                <a href="{{ url('/products') }}" class="quick-action">
                    <div class="action-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <strong>Manage Products</strong>
                        <small>View your product catalogue</small>
                    </div>
                </a>

                <a href="{{ url('/orders') }}" class="quick-action">
                    <div class="action-icon">
                        <i class="bi bi-cart-plus"></i>
                    </div>
                    <div>
                        <strong>Manage Orders</strong>
                        <small>View and create orders</small>
                    </div>
                </a>
            </div>
        </div>

    </section>


@push('scripts')
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
            $('#totalCustomers').text(response.totalCustomers ?? 0);
            $('#totalCategories').text(response.totalCategories ?? 0);
            $('#totalProducts').text(response.totalProducts ?? 0);
            $('#totalOrders').text(response.totalOrders ?? 0);

            $('#totalSales').text(
                Number(response.totalSales ?? 0).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        },

        error: function (xhr) {
            console.error('Dashboard error:', xhr.status, xhr.responseText);

            $('#message').html(
                '<div class="alert alert-danger">' +
                'Unable to load dashboard statistics. Please refresh the page.' +
                '</div>'
            );

            $('#totalCustomers, #totalCategories, #totalProducts, #totalOrders')
                .text('—');

            $('#totalSales').text('—');
        }
    });
    
    $(function () {
        const button = document.getElementById('adminDropdownBtn');
        const menu = document.getElementById('adminDropdownMenu');

        if (!button || !menu) return;

        function closeMenu() {
            menu.hidden = true;
            button.setAttribute('aria-expanded', 'false');
        }

        button.addEventListener('click', function (event) {
            event.stopPropagation();

            menu.hidden = !menu.hidden;
            button.setAttribute(
                'aria-expanded',
                String(!menu.hidden)
            );
        });

        menu.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', closeMenu);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
                button.focus();
            }
        });
    });



});
</script>

@endpush
@endsection

