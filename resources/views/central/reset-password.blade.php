@extends('central.auth-layout')

@section('title', 'Reset Password')

@section('content')
    <form action="{{ route('central.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $email }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
    <div class="mt-3 text-center">
        <a href="{{ route('central.login') }}" class="fs-14 text-primary">Back to login</a>
    </div>
@endsection
