@extends('central.auth-layout')

@section('title', 'Forgot Password')
@section('auth_title', 'Forgot Password')
@section('auth_subtitle', "Enter your email and we'll send you a reset link")

@section('content')
    <form action="{{ route('central.password.email') }}" method="POST">
        @csrf
        <div class="form-control-lg-icon mb-4">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <label for="email" class="form-label visually-hidden">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100 btn-login">
            <i class="fas fa-paper-plane me-1"></i> Send Reset Link
        </button>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('central.login') }}" class="fs-14 text-primary text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to login
        </a>
    </div>
@endsection
