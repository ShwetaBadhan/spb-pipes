<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | SPB Pipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/img/favicon.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/iconsax.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

</head>

<body class="bg-white">

    <!-- Begin Wrapper -->
    <div class="main-wrapper auth-bg">

        <!-- Start Content -->
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

                <!-- start row -->
                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap ">
                    <div class="col-lg-4 mx-auto">
                        <form action="{{ route('login.submit') }}" method="POST"
                            class="d-flex justify-content-center align-items-center">
                            @csrf

                            <div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
                                <div class="mx-auto mb-5 text-center">
                                    <img src="{{ asset('assets/img/logo/logo-spb.png') }}" class="img-fluid"
                                        alt="Logo">
                                </div>

                                <div class="card border-0 p-lg-3 shadow-lg">
                                    <div class="card-body">

                                        <div class="text-center mb-3">
                                            <h5 class="mb-2">Sign In</h5>
                                            <p class="mb-0">Please enter below details to access the dashboard</p>
                                        </div>

                                        {{-- 🔴 ERROR MESSAGE --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                {{ $errors->first() }}
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-sms-notification"></i>
                                                </span>
                                                <input type="email" name="email" value="{{ old('email') }}"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Enter Email Address">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            {{-- <div class="pass-group input-group" id="passwordInput1">  --}}

                                            {{--                                                 
                                                <input type="password" name="password" 
                                                    class="pass-inputs form-control"
                                                    placeholder="************">
                                                    <span class="isax toggle-password isax-eye-slash"></span> --}}
                                            <div class="pass-group input-group" id="passwordInput1">
                                                <span class="input-group-text border-end-0">
                                                    <i class="isax isax-lock"></i>
                                                </span>
                                                <input type="password" name="password"
                                                    class="border-start-0 ps-0 pass-inputs form-control">
                                                <span
                                                    class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" id="remember_me" name="remember"
                                                type="checkbox">
                                            <label for="remember_me" class="form-check-label">
                                                Remember Me
                                            </label>
                                        </div>
                                        <a href="#">Forgot Password</a>
                                    </div>

                                    <button type="submit" class="btn bg-primary-gradient text-white w-100">
                                        Sign In
                                    </button>

                                </div>
                            </div>
                    </div>
                    </form>

                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
    </div>
    <!-- End Content -->

    </div>
    <!-- End Wrapper -->

    <!-- jQuery -->
    <script src="{{ url('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ url('assets/js/script.js') }}"></script>

    {{-- <script src="scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" defer></script> --}}
</body>

</html>
