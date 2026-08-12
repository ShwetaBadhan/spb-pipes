<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Central Admin | SPB Pipes SaaS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta http-equiv="Cache-Control" content="no-transform">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Theme Script js -->
    <script src="{{ url('assets/js/theme-script.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/simplebar/simplebar.min.css') }}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/iconsax.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    {{-- header --}}
    @include('central.components.header')

    {{-- sidebar --}}
    @include('central.components.sidebar')

    <div class="page-wrapper">
        <div class="content">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ✅ MAIN PAGE CONTENT --}}
            @yield('content')

        </div>

        {{-- footer --}}
        @include('central.components.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ url('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ url('assets/plugins/simplebar/simplebar.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ url('assets/js/script.js') }}"></script>

    @stack('scripts')
</body>

</html>
