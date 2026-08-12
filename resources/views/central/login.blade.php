@extends('central.auth-layout')

@section('title', 'Superadmin Login')

@section('content')
    <form action="{{ route('central.login.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember me</label>
            </div>
            <a href="{{ route('central.password.request') }}" class="fs-14 text-primary">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
@endsection
