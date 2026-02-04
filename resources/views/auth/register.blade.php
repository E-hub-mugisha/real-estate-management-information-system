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
            <h3 class="fw-bold mb-3 text-center">Create Account 🚀</h3>
            <p class="text-center opacity-75 mb-4">Start managing properties digitally</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
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
@endsection
