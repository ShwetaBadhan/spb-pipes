<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'SPB Pipes SaaS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
    <style>
        body.account-page {
            background: #fff;
        }
        .account-page .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .account-brand img {
            width: 215px;
            max-width: 100%;
            object-fit: contain;
        }
        .account-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .08);
        }
        .form-control-lg-icon {
            position: relative;
        }
        .form-control-lg-icon .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: .95rem;
            z-index: 2;
            pointer-events: none;
        }
        .form-control-lg-icon .form-control {
            padding-left: 2.6rem;
            height: 48px;
        }
        .btn-login {
            height: 48px;
            font-weight: 600;
        }
        .account-back-link {
            color: #6c757d;
            text-decoration: none;
            font-size: .875rem;
        }
        .account-back-link:hover {
            color: #0d6efd;
        }
        .password-toggle {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            padding: .25rem .5rem;
            z-index: 2;
        }
    </style>
</head>

<body class="account-page">
    <div class="main-wrapper position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4">
                    <div class="card account-card border-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="SPB Pipes" class="account-brand img-fluid mb-3">
                                <h4 class="fw-bold mb-1">@yield('auth_title', 'Welcome Back')</h4>
                                <p class="text-muted fs-14 mb-0">@yield('auth_subtitle', 'Sign in to continue to the admin dashboard')</p>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="account-back-link">
                            <i class="fas fa-arrow-left me-1"></i> Back to website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
