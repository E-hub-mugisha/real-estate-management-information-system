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
        .auth-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .25);
        }
    </style>

    <div class="auth-bg">
        <div class="col-md-8 col-lg-6">
            <div class="glass-card p-4 text-white">
                <h3 class="fw-bold mb-3 text-center">Create Account 🚀</h3>
                <p class="text-center opacity-75 mb-4">Start managing properties digitally</p>
                <!-- errors -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <!-- role -->
                        <div class="col-md-6 mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="tenant">Tenant</option>
                                <option value="owner">Owner</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="passwordField"
                                    class="form-control pe-5" required>

                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                    id="togglePassword"
                                    style="font-size: 1.2rem; cursor: pointer; color: #6c757d;"></i>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="passwordConfirmationField"
                                    class="form-control pe-5" required>

                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                    id="toggleConfirmationPassword"
                                    style="font-size: 1.2rem; cursor: pointer; color: #6c757d;"></i>
                            </div>
                        </div>

                        <script>
                            function togglePasswordVisibility(toggleId, fieldId) {
                                const toggleIcon = document.getElementById(toggleId);
                                const passwordField = document.getElementById(fieldId);

                                toggleIcon.addEventListener('click', function() {
                                    const type = passwordField.type === 'password' ? 'text' : 'password';
                                    passwordField.type = type;

                                    this.classList.toggle('bi-eye');
                                    this.classList.toggle('bi-eye-slash');
                                });
                            }

                            togglePasswordVisibility('togglePassword', 'passwordField');
                            togglePasswordVisibility('toggleConfirmationPassword', 'passwordConfirmationField');
                        </script>
                    </div>
                    <button class="btn btn-light w-100 py-2 fw-bold">Register</button>

                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-warning fw-bold">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


</body>

</html>