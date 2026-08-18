<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name', 'SPB Pipes'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SPB Pipes SaaS platform for managing operations, tenants and central administration.">
    <meta name="keywords" content="SPB Pipes, SaaS, pipe management, ERP">
    <meta name="author" content="">
    <meta http-equiv="Cache-Control" content="no-transform">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <script src="{{ url('assets/js/theme-script.js') }}"></script>
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>
    @yield('sections')


    {{-- footer --}}
    @include('central.components.guest-footer')

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