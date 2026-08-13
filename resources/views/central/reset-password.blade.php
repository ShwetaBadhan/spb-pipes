@extends('central.auth-layout')

@section('title', 'Reset Password')
@section('auth_title', 'Reset Password')
@section('auth_subtitle', 'Create a new password for your account')

@section('content')
    <form action="{{ route('central.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-control-lg-icon mb-3">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <label for="email" class="form-label visually-hidden">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email address" value="{{ $email }}" required autofocus>
        </div>
        <div class="form-control-lg-icon mb-3">
            <span class="icon"><i class="fas fa-lock"></i></span>
            <label for="password" class="form-label visually-hidden">New Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="New password" required>
        </div>
        <div class="form-control-lg-icon mb-4">
            <span class="icon"><i class="fas fa-lock"></i></span>
            <label for="password_confirmation" class="form-label visually-hidden">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 btn-login">
            <i class="fas fa-check me-1"></i> Reset Password
        </button>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('central.login') }}" class="fs-14 text-primary text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to login
        </a>
    </div>
@endsection
