<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>
    <style>
        .hero {
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #0ea5e9);
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .25);
        }

        .feature-card {
            transition: all .3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.01);
        }
    </style>

    <section class="hero text-white">
        <div class="container position-relative z-2">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="badge bg-warning text-dark mb-3">Smart Property Platform</span>
                    <h1 class="display-5 fw-bold mb-3">
                        Real Estate Management Information System
                    </h1>
                    <p class="lead opacity-75 mb-4">
                        Centralize property management, tenants, leases, payments, and maintenance — all in one powerful digital platform.
                    </p>

                    <div class="d-flex gap-3">
                        @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg px-4">
                            Go to Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                            Register
                        </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6" data-aos="zoom-in">
                    <div class="glass p-4">
                        <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1200"
                            class="img-fluid rounded-4 shadow"
                            alt="Real Estate">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Core Features</h2>
                <p class="text-muted">Everything you need to manage properties digitally</p>
            </div>

            <div class="row g-4">
                @php
                $features = [
                ['icon'=>'bi-buildings','title'=>'Property & Unit Management','desc'=>'Manage properties and units in one dashboard'],
                ['icon'=>'bi-people','title'=>'Tenant Management','desc'=>'Onboard tenants and track occupancy'],
                ['icon'=>'bi-file-earmark-text','title'=>'Lease Management','desc'=>'Digitize contracts and lease periods'],
                ['icon'=>'bi-cash-stack','title'=>'Payments & Reports','desc'=>'Track rent and generate reports'],
                ['icon'=>'bi-tools','title'=>'Maintenance Requests','desc'=>'Manage service requests'],
                ['icon'=>'bi-graph-up','title'=>'Analytics Dashboard','desc'=>'Visual insights and trends'],
                ];
                @endphp

                @foreach($features as $f)
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card border-0 shadow-sm h-100 feature-card">
                        <div class="card-body p-4">
                            <i class="bi {{ $f['icon'] }} fs-1 text-primary mb-3"></i>
                            <h5 class="fw-bold">{{ $f['title'] }}</h5>
                            <p class="text-muted">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
            <p class="text-muted mb-4">
                Take control of your real estate operations with a modern digital MIS.
            </p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                Create Account
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


</body>

</html>