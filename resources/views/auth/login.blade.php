@extends('layouts.app')

@section('content')
<style>
.auth-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a, #1e3a8a, #0ea5e9);
    display: flex;
    align-items: center;
    justify-content: center;
}
.glass-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: 1.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,.25);
}
</style>

<div class="auth-bg">
    <div class="col-md-4">
        <div class="glass-card p-4 text-white">
            <h3 class="fw-bold mb-3 text-center">Welcome Back 👋</h3>
            <p class="text-center opacity-75 mb-4">Login to manage your properties</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input">
                        <label class="form-check-label">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-warning text-decoration-none">
                        Forgot?
                    </a>
                </div>

                <button class="btn btn-light w-100 py-2 fw-bold">Login</button>

                <p class="text-center mt-3">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-warning fw-bold">Register</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
