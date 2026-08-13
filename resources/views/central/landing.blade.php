<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SPB Pipes | SPB Pipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SPB Pipes SaaS platform for managing operations, tenants and central administration.">
    <meta name="keywords" content="SPB Pipes, SaaS, pipe management, ERP">
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

    <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            padding: 120px 0;
        }
        .hero-section h1 {
            font-weight: 700;
        }
        .feature-card {
            transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .12) !important;
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: .75rem;
        }
        section {
            scroll-margin-top: 80px;
        }
    </style>
</head>

<body>

    {{-- header --}}
    @include('central.components.guest-header')

    {{-- Hero Banner --}}
    <section id="home" class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 mb-3">Manage Your SPB Pipes Business With Ease</h1>
                    <p class="lead mb-4">A powerful SaaS platform that streamlines your pipe manufacturing operations, central administration and tenant management all in one place.</p>
                    <a href="{{ route('central.login') }}" class="btn btn-light btn-lg me-2">Get Started</a>
                    <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-25">
                        <div class="row g-3 text-center">
                            <div class="col-4">
                                <h2 class="fw-bold mb-0">50+</h2>
                                <p class="mb-0">Features</p>
                            </div>
                            <div class="col-4">
                                <h2 class="fw-bold mb-0">100+</h2>
                                <p class="mb-0">Tenants</p>
                            </div>
                            <div class="col-4">
                                <h2 class="fw-bold mb-0">24/7</h2>
                                <p class="mb-0">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Our Features</h2>
                <p class="text-muted">Everything you need to run your business efficiently.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                                <i class="isax isax-buildings"></i>
                            </span>
                            <h5 class="fw-semibold">Tenant Management</h5>
                            <p class="text-muted mb-0">Create and manage multiple tenants under a single central platform with ease.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-success bg-opacity-10 text-success mb-3">
                                <i class="isax isax-settings"></i>
                            </span>
                            <h5 class="fw-semibold">Central Settings</h5>
                            <p class="text-muted mb-0">Control platform-wide settings, configurations and preferences from one dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-warning bg-opacity-10 text-warning mb-3">
                                <i class="isax isax-security-user"></i>
                            </span>
                            <h5 class="fw-semibold">Admin Roles</h5>
                            <p class="text-muted mb-0">Assign and manage super admins and central admins with role based access.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-info bg-opacity-10 text-info mb-3">
                                <i class="isax isax-chart"></i>
                            </span>
                            <h5 class="fw-semibold">Dashboards</h5>
                            <p class="text-muted mb-0">Real time insights and reports to help you make smarter business decisions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-danger bg-opacity-10 text-danger mb-3">
                                <i class="isax isax-shield-tick"></i>
                            </span>
                            <h5 class="fw-semibold">Secure &amp; Reliable</h5>
                            <p class="text-muted mb-0">Your data is protected with industry standard security practices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body text-center p-4">
                            <span class="feature-icon bg-secondary bg-opacity-10 text-secondary mb-3">
                                <i class="isax isax-call"></i>
                            </span>
                            <h5 class="fw-semibold">Dedicated Support</h5>
                            <p class="text-muted mb-0">Our support team is here to help you around the clock, whenever you need it.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <span class="badge text-bg-primary mb-2">About Us</span>
                    <h2 class="fw-bold mb-3">About SPB Pipes</h2>
                    <p class="text-muted">SPB Pipes is a leading manufacturer of high quality pipes and pipe related products. Our SaaS platform brings together all aspects of our business operations into a single, unified system.</p>
                    <p class="text-muted">From tenant management to central administration, our platform is designed to scale with our business and provide a seamless experience for our team and partners.</p>
                    <a href="{{ route('central.login') }}" class="btn btn-primary">Get Started Today</a>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <div class="d-flex align-items-start mb-4">
                            <span class="feature-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="isax isax-radar"></i>
                            </span>
                            <div>
                                <h6 class="fw-semibold mb-1">Our Mission</h6>
                                <p class="text-muted mb-0">To deliver reliable, high quality products and services powered by modern technology.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <span class="feature-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="isax isax-eye"></i>
                            </span>
                            <div>
                                <h6 class="fw-semibold mb-1">Our Vision</h6>
                                <p class="text-muted mb-0">To be the trusted leader in pipe manufacturing through innovation and excellence.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <span class="feature-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="isax isax-heart"></i>
                            </span>
                            <div>
                                <h6 class="fw-semibold mb-1">Our Values</h6>
                                <p class="text-muted mb-0">Quality, integrity and customer satisfaction are at the heart of everything we do.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
