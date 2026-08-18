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
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
    <style>
        body, body *:not(i):not([class*="fa"]):not(.fa) {
            font-family: 'Inter', sans-serif;
        }
        body.account-page {
            background: #fff;
        }
        body.account-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 600px 600px at 10% 20%, rgba(42, 108, 182, .25) 0%, transparent 70%),
                radial-gradient(ellipse 500px 500px at 80% 80%, rgba(13, 33, 55, .3) 0%, transparent 70%),
                radial-gradient(ellipse 300px 300px at 60% 10%, rgba(42, 108, 182, .12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .auth-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: #fff;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 2.5rem 6rem rgba(0, 0, 0, .25), 0 0 0 1px rgba(255, 255, 255, .05);
            min-height: 600px;
        }

        /* ── Left brand panel ── */
        .auth-brand-panel {
            flex: 1;
            background: linear-gradient(160deg, #0d2137 0%, #14365a 35%, #1e5a8e 70%, #2a6cb6 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .auth-brand-panel::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, .08) 0%, transparent 70%);
            top: -120px;
            left: -120px;
        }
        .auth-brand-panel::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, .06) 0%, transparent 70%);
            bottom: -100px;
            right: -80px;
        }
        .auth-brand-panel .floating-shape {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .auth-brand-panel .floating-shape:nth-child(1) {
            width: 60px; height: 60px;
            top: 15%; left: 10%;
            animation-delay: 0s;
        }
        .auth-brand-panel .floating-shape:nth-child(2) {
            width: 40px; height: 40px;
            top: 70%; right: 12%;
            animation-delay: -2s;
            border-radius: .5rem;
            transform: rotate(45deg);
        }
        .auth-brand-panel .floating-shape:nth-child(3) {
            width: 80px; height: 80px;
            bottom: 20%; left: 15%;
            animation-delay: -4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: .6; }
            50% { transform: translateY(-15px) rotate(5deg); opacity: 1; }
        }
        .auth-brand-panel img {
            width: 180px;
            max-width: 100%;
            object-fit: contain;
            margin-bottom: 2rem;
            filter: brightness(0) invert(1);
            position: relative;
            z-index: 1;
        }
        .auth-brand-panel h2 {
            font-weight: 800;
            font-size: 1.6rem;
            margin-bottom: .75rem;
            position: relative;
            z-index: 1;
        }
        .auth-brand-panel p {
            font-size: .9rem;
            opacity: .8;
            line-height: 1.6;
            max-width: 280px;
            position: relative;
            z-index: 1;
        }
        .auth-brand-features {
            margin-top: 2rem;
            text-align: left;
            position: relative;
            z-index: 1;
        }
        .auth-brand-features .feature-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1rem;
            font-size: .85rem;
            opacity: .85;
        }
        .auth-brand-features .feature-item i {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            flex-shrink: 0;
        }

        /* ── Right form panel ── */
        .auth-form-panel {
            flex: 1;
            max-width: 480px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
        }
        .auth-form-panel .brand-mobile {
            display: none;
        }
        .auth-form-panel .brand-mobile img {
            width: 120px;
            max-width: 100%;
            object-fit: contain;
        }
        .auth-form-panel h4 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: .35rem;
        }
        .auth-form-panel .subtitle {
            color: #6c757d;
            font-size: .875rem;
            margin-bottom: 2rem;
        }

        /* ── Form controls ── */
        .form-control-lg-icon {
            position: relative;
        }
        .form-control-lg-icon .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: .9rem;
            z-index: 2;
            pointer-events: none;
        }
        .form-control-lg-icon .form-control {
            padding-left: 2.6rem;
            height: 48px;
            border-radius: .5rem;
            border: 1px solid #dee2e6;
            font-size: .9rem;
        }
        .form-control-lg-icon .form-control:focus {
            border-color: #2a6cb6;
            box-shadow: 0 0 0 .2rem rgba(42, 108, 182, .15);
        }
        .password-toggle {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            padding: .25rem .5rem;
            z-index: 2;
        }
        .btn-login {
            height: 48px;
            font-weight: 600;
            border-radius: .5rem;
            font-size: .95rem;
            background: linear-gradient(135deg, #1a4a7a, #2a6cb6);
            border: none;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0d2137, #1a4a7a);
        }

        /* ── Back link ── */
        .account-back-link {
            color: #6c757d;
            text-decoration: none;
            font-size: .85rem;
        }
        .account-back-link:hover {
            color: #2a6cb6;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .auth-brand-panel {
                display: none;
            }
            .auth-form-panel {
                max-width: 100%;
            }
            .auth-form-panel .brand-mobile {
                display: block;
                text-align: center;
                margin-bottom: 1.5rem;
            }
            .auth-container {
                box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, .3);
                border-radius: 1rem;
            }
            .auth-form-panel {
                background: #fff;
                border-radius: 1rem;
                padding: 2rem;
            }
        }
    </style>
</head>

<body class="account-page">
    <div class="main-wrapper">
        <div class="auth-container">
            {{-- Left Brand Panel --}}
            <div class="auth-brand-panel">
                <div class="floating-shape"></div>
                <div class="floating-shape"></div>
                <div class="floating-shape"></div>
                @yield('left_panel')
                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="SPB Pipes" class="mt-auto opacity-50" style="width:80px; margin-top:2rem;">
            </div>

            {{-- Right Form Panel --}}
            <div class="auth-form-panel">
                <div class="brand-mobile">
                    <img src="{{ asset('assets/img/logo-spb.png') }}" alt="SPB Pipes">
                </div>
                <h4>@yield('auth_title', 'Welcome Back')</h4>
                <p class="subtitle mb-0">@yield('auth_subtitle', 'Sign in to continue to the admin dashboard')</p>

                @if (session('status'))
                    <div class="alert alert-success mt-3">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="account-back-link">
                        <i class="fas fa-arrow-left me-1"></i> Back to website
                    </a>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
