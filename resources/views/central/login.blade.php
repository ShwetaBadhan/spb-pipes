@extends('central.auth-layout')

@section('title', 'Superadmin Login')
@section('auth_title', 'Welcome Back')

@section('content')
    <form action="{{ route('central.login.submit') }}" method="POST">
        @csrf
        <div class="form-control-lg-icon mb-3">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <label for="email" class="form-label visually-hidden">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-control-lg-icon mb-3">
            <span class="icon"><i class="fas fa-lock"></i></span>
            <label for="password" class="form-label visually-hidden">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" style="padding-right: 3rem;" required>
            <button type="button" id="togglePassword" class="btn btn-link text-muted password-toggle" aria-label="Toggle password visibility">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label fs-14">Remember me</label>
            </div>
            <a href="{{ route('central.password.request') }}" class="fs-14 text-primary text-decoration-none">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100 btn-login">
            <i class="fas fa-sign-in-alt me-1"></i> Login
        </button>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
    });
</script>
@endpush
