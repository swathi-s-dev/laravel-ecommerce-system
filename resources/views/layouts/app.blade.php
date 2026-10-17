<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'E-Commerce System')
    </title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Your Common CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}">

</head>

<body>

    <!-- Header -->
    {{-- <header class="bg-dark text-white py-3">

        <div class="container">

            <h3 class="mb-0">
                <i class="bi bi-shop"></i>
                E-Commerce Management System
            </h3>

        </div>

    </header> --}}


    <!-- Main Content -->
    <main class="container py-4">

        @yield('content')

    </main>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')

</body>

</html>