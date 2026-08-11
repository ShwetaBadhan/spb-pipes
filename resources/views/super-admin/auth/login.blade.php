@extends('super-admin.layouts.master')

@section('title', 'Super Admin Login')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="text-center mb-1">SBP Pipes</h4>
                <p class="text-center text-muted mb-4">Super Admin Panel</p>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('super-admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
