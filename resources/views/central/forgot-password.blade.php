@extends('central.auth-layout')

@section('title', 'Forgot Password')

@section('content')
    <p class="text-muted">Enter your email and we'll send you a password reset link.</p>
    <form action="{{ route('central.password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>
    <div class="mt-3 text-center">
        <a href="{{ route('central.login') }}" class="fs-14 text-primary">Back to login</a>
    </div>
@endsection
