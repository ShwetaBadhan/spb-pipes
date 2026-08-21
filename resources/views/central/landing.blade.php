@extends('central.layouts.app')
@section('title', 'SPB Pipes - Home')
@section('sections')
@push('styles')
    <style>
        .hero-section {
            background: linear-gradient(250deg, #26516f 0%, #2480ad 100%);
            padding: 120px 0;
        }
        .hero-section h1 {
            font-weight: 700;
        }
        .hero-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }
        .hero-glow-1 {
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, .12);
            top: -180px;
            right: -120px;
        }
        .hero-glow-2 {
            width: 400px;
            height: 400px;
            background: rgba(255, 193, 7, .12);
            bottom: -160px;
            left: -100px;
        }
        .hero-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            border: 2px solid rgba(255, 255, 255, .8);
            letter-spacing: .5px;
        }
        .hero-preview {
            box-shadow: 0 2rem 4rem rgba(0, 0, 0, .25);
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
        .testimonial-stars {
            letter-spacing: 2px;
        }
        section {
            scroll-margin-top: 80px;
        }
    </style>
@endpush

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <section id="home" class="flex flex-col items-center text-sm bg-[url('https://raw.githubusercontent.com/prebuiltui/prebuiltui/main/assets/hero/bg-with-grid.png')] bg-cover bg-center bg-no-repeat">
        <nav class="z-50 flex items-center justify-between w-full py-4 px-6 md:px-16 lg:px-24 xl:px-32 backdrop-blur text-slate-800 text-sm">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo-spb.png') }}" alt="SPB Pipes Logo" class="h-10 w-auto">
            </a>

            <div class="hidden md:flex items-center gap-8 transition duration-500">
                <a href="#home" class="hover:text-slate-500 transition">
                    Home
                </a>
                <a href="#features" class="hover:text-slate-500 transition">
                    Features
                </a>
                <a href="#about" class="hover:text-slate-500 transition">
                    About
                </a>
                <a href="#testimonials" class="hover:text-slate-500 transition">
                    Testimonials
                </a>
                <a href="#pricing" class="hover:text-slate-500 transition">
                    Pricing
                </a>
            </div>

            <div class="hidden md:block space-x-3">
                @if (auth('central')->check())
                    <a href="{{ route('central.dashboard') }}" class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 transition text-white rounded-md">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('central.register') }}" class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 transition text-white rounded-md">
                        Get started
                    </a>
                    <a href="{{ route('central.login') }}" class="inline-block hover:bg-slate-100 transition px-6 py-2 border border-indigo-600 rounded-md">
                        Login
                    </a>
                @endif
            </div>
            <button id="open-menu" class="md:hidden active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/></svg>
            </button>
        </nav>
        <div id="mobile-navLinks" class="fixed inset-0 z-[100] bg-white/60 text-slate-800 backdrop-blur flex flex-col items-center justify-center text-lg gap-8 md:hidden transition-transform duration-300 -translate-x-full">
            <a href="#home">
                Home
            </a>
            <a href="#features">
                Features
            </a>
            <a href="#about">
                About
            </a>
            <a href="#testimonials">
                Testimonials
            </a>
            <a href="#pricing">
                Pricing
            </a>
            @if (auth('central')->check())
                <a href="{{ route('central.dashboard') }}">
                    Dashboard
                </a>
            @else
                <a href="{{ route('central.login') }}">
                    Login
                </a>
                <a href="{{ route('central.register') }}">
                    Get started
                </a>
            @endif
            <button id="close-menu" class="active:ring-3 active:ring-white aspect-square size-10 p-1 items-center justify-center bg-slate-100 hover:bg-slate-200 transition text-black rounded-md flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <main class="flex flex-col items-center max-md:px-2 container">
            <a href="{{ route('central.register') }}" class="mt-32 flex items-center gap-2 border border-indigo-200 rounded-full p-1 pr-3 text-sm font-medium text-indigo-500 bg-indigo-200/20">
                <span class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full">
                    NEW
                </span>
                <p class="flex items-center gap-1">
                    <span>Start your 14-day free trial — no credit card required</span>
                    <svg class="mt-1" width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m1 1 4 3.5L1 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </p>
            </a>

            <h1 class="text-center text-5xl leading-[68px] md:text-6xl md:leading-[80px] font-semibold max-w-4xl text-slate-900">
                Run Your Pipe Business From One Place.
            </h1>
            <p class="text-center text-base text-slate-700 max-w-lg mt-2">
                SPB Pipes brings tenants, orders, inventory, billing and reporting together in a single secure platform — built for pipe manufacturers.
            </p>
            <div class="flex items-center gap-4 mt-8">
                <a href="{{ route('central.register') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white active:scale-95 rounded-lg px-7 h-11">
                    Get started
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.166 10h11.667m0 0L9.999 4.165m5.834 5.833-5.834 5.834" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#pricing" class="flex items-center border border-slate-600 active:scale-95 hover:bg-white/10 transition text-slate-600 rounded-lg px-8 h-11">
                    View Pricing
                </a>
            </div>

            <img src="{{ asset('assets/img/hero-dashboard-img.png') }}"
                class="w-full rounded-[15px] max-w-4xl mt-16 border border-primary"
                alt="SPB Pipes dashboard preview"
            />
        </main>
    </section>

    <script>
        const openMenu = document.getElementById("open-menu");
        const closeMenu = document.getElementById("close-menu");
        const navLinks = document.getElementById("mobile-navLinks");

        const openMenuHandler = () => {
            navLinks.classList.remove("-translate-x-full")
            navLinks.classList.add("translate-x-0")
        }

        const closeMenuHandler = () => {
            navLinks.classList.remove("translate-x-0")
            navLinks.classList.add("-translate-x-full")
        }

        openMenu.addEventListener("click", openMenuHandler);
        closeMenu.addEventListener("click", closeMenuHandler);
    </script>

    <section id="features" class="w-full flex-col items-center mx-auto px-4 py-20 container">
        <div class="mx-auto flex w-full flex-col items-center">
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-sm text-slate-800">
                Core Features
            </div>

            <h1 class="mt-7 text-center text-5xl font-medium text-slate-900">
                Everything You Need to Run Your Business
            </h1>

            <p class="mt-3 max-w-[540px] text-center text-sm md:text-base text-slate-600">
                Powerful tools for tenants, billing, inventory and reporting — designed to simplify day-to-day operations for pipe manufacturers.
            </p>

            <div class="mt-10 grid w-full max-w- 6xl grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.333 17.5v-1.667A3.333 3.333 0 0 0 10 12.5H5a3.333 3.333 0 0 0-3.333 3.333V17.5M13.333 2.61a3.333 3.333 0 0 1 0 6.453m5 8.438v-1.667a3.334 3.334 0 0 0-2.5-3.225M7.5 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Tenant Management</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Create and manage multiple tenants under a single central platform with ease.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        Manage Tenants
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12.503v4.166s2.525-.458 3.333-1.666c.9-1.35 0-4.167 0-4.167M3.75 13.748c-1.25 1.05-1.667 4.167-1.667 4.167s3.117-.417 4.167-1.667c.592-.7.583-1.775-.075-2.425a1.817 1.817 0 0 0-2.425-.075" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 9.998a18.3 18.3 0 0 1 1.667-3.292 10.73 10.73 0 0 1 9.166-5.042c0 2.267-.65 6.25-5 9.167A18.7 18.7 0 0 1 10 12.498z" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 9.996H3.333S3.792 7.471 5 6.663c1.35-.9 4.167.042 4.167.042" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Central Settings</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Control platform-wide settings, configurations and preferences from one dashboard.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        Explore Settings
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.667 10.831c0 4.167-2.917 6.25-6.384 7.458a.83.83 0 0 1-.558-.008c-3.475-1.2-6.392-3.283-6.392-7.45V4.998a.833.833 0 0 1 .834-.834c1.666 0 3.75-1 5.2-2.266a.975.975 0 0 1 1.266 0c1.459 1.275 3.534 2.266 5.2 2.266a.833.833 0 0 1 .834.834z" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m7.5 10.003 1.667 1.666L12.5 8.336" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Admin Roles</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Assign and manage super admins and central admins with role based access.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        View Roles
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 2.5H3.333a.833.833 0 0 0-.833.833v5.834c0 .46.373.833.833.833H7.5c.46 0 .833-.373.833-.833V3.333A.833.833 0 0 0 7.5 2.5m9.167 0H12.5a.833.833 0 0 0-.833.833v2.5c0 .46.373.834.833.834h4.167c.46 0 .833-.373.833-.834v-2.5a.833.833 0 0 0-.833-.833m0 7.5H12.5a.833.833 0 0 0-.833.833v5.834c0 .46.373.833.833.833h4.167c.46 0 .833-.373.833-.833v-5.834a.833.833 0 0 0-.833-.833M7.5 13.336H3.333a.833.833 0 0 0-.833.833v2.5c0 .46.373.834.833.834H7.5c.46 0 .833-.373.833-.834v-2.5a.833.833 0 0 0-.833-.833" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Dashboards</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Real time insights and reports to help you make smarter business decisions.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        View Insights
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3.333" y="8.333" width="13.333" height="8.333" rx="1.667" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.667 8.333V5.833a3.333 3.333 0 0 1 6.667 0v2.5" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Secure &amp; Reliable</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Your data is protected with industry standard security practices.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        Learn Security
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="flex flex-col rounded-lg border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100 transition-colors duration-300">
                    <div class="flex size-10 items-center justify-center rounded-lg border border-slate-200">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 11.666a.832.832 0 0 1-.65-1.358l8.25-8.5a.417.417 0 0 1 .717.383l-1.6 5.017a.833.833 0 0 0 .783 1.125h5.834a.833.833 0 0 1 .65 1.358l-8.25 8.5a.416.416 0 0 1-.717-.383l1.6-5.017a.833.833 0 0 0-.783-1.125z" stroke="#314158" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h2 class="mt-6 text-sm font-medium text-slate-800">Dedicated Support</h2>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Our support team is here to help you around the clock, whenever you need it.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm text-slate-600 group">
                        Contact Support
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#45556c" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
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
                    <a href="{{ route('central.register') }}" class="btn btn-primary">Get Started Today</a>
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

    {{-- Testimonials Section --}}
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge text-bg-primary mb-2">Testimonials</span>
                <h2 class="fw-bold mb-2">What Our Customers Say</h2>
                <p class="text-muted">Trusted by pipe manufacturers and operations teams across India.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body p-4">
                            <div class="text-warning testimonial-stars mb-3">
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                            </div>
                            <p class="text-muted mb-4">&ldquo;We moved all our tenant records, billing and inventory onto SPB Pipes. The plan limits keep our teams accountable, and setup took minutes — not months.&rdquo;</p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="hero-avatar bg-primary text-white flex-shrink-0">RP</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Ramesh Patel</h6>
                                    <span class="fs-13 text-muted">Plant Manager, Gujarat Steel Pipes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body p-4">
                            <div class="text-warning testimonial-stars mb-3">
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                            </div>
                            <p class="text-muted mb-4">&ldquo;The multi-tenant setup lets each of our units run independently while I keep full control from the central dashboard. Reporting that used to take a day now takes minutes.&rdquo;</p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="hero-avatar bg-success text-white flex-shrink-0">PS</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Priya Sharma</h6>
                                    <span class="fs-13 text-muted">Operations Head, Titan Pipes Ltd</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm feature-card">
                        <div class="card-body p-4">
                            <div class="text-warning testimonial-stars mb-3">
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                            </div>
                            <p class="text-muted mb-4">&ldquo;Upgrading plans is effortless and the support team is genuinely responsive. It&rsquo;s the first system our entire team actually enjoys using every single day.&rdquo;</p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="hero-avatar bg-warning text-dark flex-shrink-0">AV</span>
                                <div>
                                    <h6 class="fw-semibold mb-0">Amit Verma</h6>
                                    <span class="fs-13 text-muted">Director, Nova Tubes Pvt Ltd</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing Section --}}
    <section id="pricing" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge text-bg-primary mb-2">Pricing</span>
                <h2 class="fw-bold mb-2">Simple, Transparent Pricing</h2>
                <p class="text-muted">Choose a plan that fits your business. Start free, upgrade anytime.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse ($plans as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm feature-card">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-0">{{ $plan->name }}</h5>
                                    @if ($plan->is_default)
                                        <span class="badge text-bg-primary">Recommended</span>
                                    @endif
                                </div>
                                @if ($plan->description)
                                    <p class="text-muted fs-14 mb-3">{{ $plan->description }}</p>
                                @endif
                                <div class="mb-3">
                                    @if ($plan->isFree())
                                        <span class="fs-2 fw-bold">Free</span>
                                        <span class="text-muted">forever</span>
                                    @else
                                        <span class="fs-2 fw-bold">{{ $plan->currency }} {{ number_format($plan->price) }}</span>
                                        <span class="text-muted">/{{ $plan->billing_period }}</span>
                                    @endif
                                    @if ($plan->trial_days > 0)
                                        <div class="fs-13 text-success mt-1">
                                            <i class="isax isax-timer"></i> {{ $plan->trial_days }}-day free trial
                                        </div>
                                    @endif
                                </div>
                                <ul class="list-unstyled mb-4 flex-grow-1">
                                    @foreach ($limitKeys as $key)
                                        @php $value = $plan->limit($key); @endphp
                                        <li class="d-flex align-items-center gap-2 mb-2">
                                            <i class="isax isax-tick-circle text-success flex-shrink-0"></i>
                                            <span class="text-capitalize fs-14">{{ str_replace('_', ' ', $key) }}:
                                                @if ($value < 0)
                                                    Unlimited
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                                @if ($plan->isFree())
                                    <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="btn btn-primary w-100">Start Free Trial</a>
                                @elseif ($plan->trial_days > 0)
                                    <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="btn btn-primary w-100">Start Free Trial</a>
                                @else
                                    <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="btn btn-primary w-100">Get Started</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Plans are not available yet. Please check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

    
