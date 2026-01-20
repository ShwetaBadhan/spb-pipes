<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard | SPB Pipes </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
<meta http-equiv="Cache-Control" content="no-transform">

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/img/favicon.png')}}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/apple-touch-icon.png')}}">

    <!-- Theme Script js -->
    <script src="{{ url('assets/js/theme-script.js') }}"></script>


	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css')}}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ url('assets/plugins/daterangepicker/daterangepicker.css')}}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ url('assets/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css')}}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css')}}">
   <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css')}}">
    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/simplebar/simplebar.min.css')}}">
<!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/select2/css/select2.min.css')}}">

	  <!-- Datatable JS -->
    <script src="{{ url('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ url('assets/js/dataTables.bootstrap5.min.js')}}"></script>
<!-- Quill CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/quill/quill.snow.css')}}">
	<!-- Iconsax CSS -->
	<link rel="stylesheet" href="{{ url('assets/css/iconsax.css')}}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ url('assets/css/style.css')}}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>




{{-- header --}}
@include("admin.components.top-header")

{{-- sidebar --}}
@include("admin.components.sidebar")
 {{-- ✅ MAIN PAGE CONTENT YIELD HERE --}}
    @yield('content')
{{-- copyright --}}
@include("admin.components.copyright")




    <!-- jQuery -->
	

	<script src="{{ url('assets/js/jquery-3.7.1.min.js') }}" data-cfasync="false"></script>


	<!-- Bootstrap Core JS -->
	<script src="{{ url('assets/js/bootstrap.bundle.min.js')}}" ></script> 
	<!-- Select2 JS -->
    <script src="{{ url('assets/plugins/select2/js/select2.min.js')}}"></script>

	<!-- Daterangepikcer JS -->
	<script src="{{ url ('assets/js/moment.min.js')}}" ></script>
	<script src="{{ url('assets/plugins/daterangepicker/daterangepicker.js')}}" ></script>

	<!-- Simplebar JS -->
	<script src="{{ url('assets/plugins/simplebar/simplebar.min.js')}}" ></script>

	<!-- Datetimepicker JS -->
	<script src="{{ url('assets/js/bootstrap-datetimepicker.min.js')}}" ></script>

	<!-- Chart JS -->
	<script src="{{ url('assets/plugins/apexchart/apexcharts.min.js')}}" ></script>
	<script src="{{ url('assets/plugins/apexchart/chart-data.js')}}" ></script>

	<!-- Datatable JS -->
	<script src="{{ url('assets/js/jquery.dataTables.min.js')}}" ></script>
    <script src="{{ url('assets/js/dataTables.bootstrap5.min.js')}}" ></script>
<!-- intel Input -->
    <script src="{{ url('assets/plugins/intltelinput/js/intlTelInput.html')}}"></script>
 <!-- Quill JS -->
    <script src="{{ url('assets/plugins/quill/quill.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{ url('assets/js/script.js')}}" ></script>

    {{-- <script src="{{ url('scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}"></script> --}}
@stack('scripts')
</body>
</html>