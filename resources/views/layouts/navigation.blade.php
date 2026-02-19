<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(135deg, #0f172a, #1e3a8a);">
    <div class="container-fluid px-4">
        <!-- Logo / Brand -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <i class="bi bi-building"></i> REMIS
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Left Links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                @if(Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('users.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-people me-1"></i> Users
                    </a>
                </li>
                @endif

                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'manager']))
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('properties.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('properties.index') }}">
                        <i class="bi bi-house-door me-1"></i> Properties
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('units.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('units.index') }}">
                        <i class="bi bi-grid me-1"></i> Units
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('tenants.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('tenants.index') }}">
                        <i class="bi bi-person-lines-fill me-1"></i> Tenants
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('leases.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('leases.index') }}">
                        <i class="bi bi-file-earmark-text me-1"></i> Leases
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('payments.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('payments.index') }}">
                        <i class="bi bi-credit-card me-1"></i> Payments
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('maintenance.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('maintenance.index') }}">
                        <i class="bi bi-tools me-1"></i> Maintenance
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('reports.*') ? 'active fw-semibold text-warning' : 'text-white' }}"
                        href="{{ route('reports.index') }}">
                        <i class="bi bi-bar-chart-line me-1"></i> Reports
                    </a>
                </li>
                @endif

            </ul>

            <!-- Right User Menu -->
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm rounded-pill px-3">Register</a>
                </li>
                @endguest

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white"
                        href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span class="fw-semibold">{{ auth()->user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-gear me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>