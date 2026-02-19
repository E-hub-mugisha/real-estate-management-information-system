<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Optional Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themee1e3.css?ver=3.2.4')}}">
</head>

<body>

    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="vh-84 py-4 bg-light">
        @yield('content')
    </main>
    <footer class="mt-auto text-white" style="background: linear-gradient(135deg, #0f172a, #1e3a8a);">
        <div class="container py-5">
            <div class="row gy-4">

                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">{{ config('app.name') }}</h5>
                    <p class="small opacity-75">
                        Real Estate Management System – simplifying property, tenant,
                        lease, payment, and maintenance management in one smart platform.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-semibold mb-3">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('dashboard') }}" class="text-white text-decoration-none opacity-75 hover-opacity">Dashboard</a></li>
                        <li><a href="{{ route('properties.index') }}" class="text-white text-decoration-none opacity-75">Properties</a></li>
                        <li><a href="{{ route('tenants.index') }}" class="text-white text-decoration-none opacity-75">Tenants</a></li>
                        <li><a href="{{ route('payments.index') }}" class="text-white text-decoration-none opacity-75">Payments</a></li>
                        <li><a href="{{ route('reports.index') }}" class="text-white text-decoration-none opacity-75">Reports</a></li>
                    </ul>
                </div>

                <!-- System -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-semibold mb-3">System</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('login') }}" class="text-white text-decoration-none opacity-75">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-white text-decoration-none opacity-75">Register</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="text-white text-decoration-none opacity-75">Profile</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-semibold mb-3">Contact</h6>
                    <p class="small opacity-75 mb-1">
                        <i class="bi bi-envelope me-2"></i> support@rems.com
                    </p>
                    <p class="small opacity-75 mb-1">
                        <i class="bi bi-telephone me-2"></i> +250 788 000 000
                    </p>
                </div>

            </div>

            <hr class="border-light opacity-25 my-4">

            <div class="text-center small opacity-75">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>


    <!-- jQuery CDN (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('table').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                order: [],
            });
        });
    </script>

    @stack('scripts')
</body>

</html>