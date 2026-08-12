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
    <link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
</head>

<body class="account-page">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="Logo" class="img-fluid mb-2" style="max-height: 44px;">
                                <h5 class="mb-0">@yield('auth_title', 'Central Admin Login')</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
