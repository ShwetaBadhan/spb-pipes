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
        :root {
            --brand-dark: #1a4a7a;
            --brand-light: #2a6cb6;
        }
        .brand-gradient {
            background-image: linear-gradient(135deg, #1a4a7a, #2a6cb6);
        }
        .brand-text {
            color: var(--brand-dark);
        }
        .btn-brand {
            background-image: linear-gradient(135deg, #1a4a7a, #2a6cb6);
            color: #fff;
            transition: filter .2s ease, transform .15s ease;
        }
        .btn-brand:hover {
            filter: brightness(1.12);
            color: #fff;
        }
        .btn-brand:active {
            transform: scale(.97);
        }
        .btn-outline-brand {
            border: 1px solid var(--brand-light);
            color: var(--brand-dark);
            transition: background-color .2s ease;
        }
        .btn-outline-brand:hover {
            background-color: rgba(42, 108, 182, .08);
        }
        .badge-brand-pill {
            border: 1px solid #cfe0f2;
            background-color: rgba(42, 108, 182, .10);
            color: var(--brand-dark);
        }
        .plan-featured {
            box-shadow: 0 0 0 2px var(--brand-light), 0 1rem 2rem -0.5rem rgba(26, 74, 122, .25);
        }
        .feature-tile {
            transition: opacity .5s ease, transform .5s ease, translate .2s ease, background-color .3s ease, box-shadow .3s ease;
        }
        .feature-tile.feature-anim {
            opacity: 0;
            transform: translateY(24px);
        }
        .feature-tile.is-visible {
            opacity: 1;
            transform: none;
        }
    </style>
@endpush

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <section id="home" class="flex flex-col items-center text-sm bg-[url('https://raw.githubusercontent.com/prebuiltui/prebuiltui/main/assets/hero/bg-with-grid.png')] bg-cover bg-center bg-no-repeat">
        <nav class="z-50 flex items-center justify-between w-full py-4 px-6 md:px-16 lg:px-24 xl:px-32 backdrop-blur text-slate-800 text-sm">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/saas-default-logo.png') }}" width="150" alt="SPB Pipes Logo" class="h -10 w- auto">
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
                    <a href="{{ route('central.dashboard') }}" class="btn-brand inline-block px-6 py-2 rounded-md">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('central.register') }}" class="btn-brand inline-block px-6 py-2 rounded-md">
                        Get started
                    </a>
                    <a href="{{ route('central.login') }}" class="btn-outline-brand inline-block px-6 py-2 rounded-md">
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
            <a href="{{ route('central.register') }}" class="badge-brand-pill mt-32 flex items-center gap-2 rounded-full p-1 pr-3 text-sm font-medium">
                <span class="brand-gradient text-white text-xs px-3 py-1 rounded-full">
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
                <a href="{{ route('central.register') }}" class="btn-brand flex items-center gap-2 active:scale-95 rounded-lg px-7 h-11">
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

            <h1 class="mt-7 text-center text-4xl sm:text-5xl font-medium text-slate-900">
                Everything You Need to Run Your Business
            </h1>

            <p class="mt-3 max-w-[540px] text-center text-sm md:text-base text-slate-600">
                Powerful tools for orders, invoicing, inventory, production and reporting — everything a growing pipe business needs.
            </p>

            <div class="mt-10 grid w-full max-w -6xl grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4.167" y="3.333" width="11.667" height="13.333" rx="1.667" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="7.083" y="1.667" width="5.833" height="3.333" rx=".833" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 9.583h5M7.5 12.917h5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Order Management</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Create, track and fulfil customer orders from confirmation to delivery in one flow.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        Manage Orders
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 11.666a.832.832 0 0 1-.65-1.358l8.25-8.5a.417.417 0 0 1 .717.383l-1.6 5.017a.833.833 0 0 0 .783 1.125h5.834a.833.833 0 0 1 .65 1.358l-8.25 8.5a.416.416 0 0 1-.717-.383l1.6-5.017a.833.833 0 0 0-.783-1.125z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Invoices &amp; Payments</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Generate professional invoices, record payments and follow outstanding dues instantly.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        Create Invoices
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.5 13.55v-7.1a1.667 1.667 0 0 0-.85-1.45L10.817 1.71a1.667 1.667 0 0 0-1.634 0L3.35 5a1.667 1.667 0 0 0-.85 1.45v7.1a1.667 1.667 0 0 0 .85 1.45l5.833 3.283a1.667 1.667 0 0 0 1.634 0l5.833-3.283a1.667 1.667 0 0 0 .85-1.45z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m2.75 6.25 7.25 4.167 7.25-4.167M10 18.333v-7.916" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Inventory Management</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Track pipes, raw materials and stock levels across your warehouse in real time.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        Track Stock
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.333 17.5v-1.667A3.333 3.333 0 0 0 10 12.5H5a3.333 3.333 0 0 0-3.333 3.333V17.5M13.333 2.61a3.333 3.333 0 0 1 0 6.453m5 8.438v-1.667a3.334 3.334 0 0 0-2.5-3.225M7.5 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Customers &amp; Suppliers</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Maintain customer and supplier records with complete payment history in one place.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        Manage Contacts
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2.5" y="4.583" width="15" height="10.833" rx="1.667" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.5 8.333h15M5.833 12.083h3.334" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Finance &amp; Expenses</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Monitor incomes, expenses, bank accounts and money transfers effortlessly.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        View Finances
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="feature-tile flex flex-col rounded-xl border border-slate-200 bg-slate-50 p-6 hover:bg-white hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70">
                    <div class="mb-3 brand-gradient flex size-11 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.167 16.667V10.833M10 16.667V3.333M15.833 16.667V6.667" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h5 class="mt-6 text-base font-semibold text-slate-900">Reports &amp; Insights</h5>
                    <p class="mt-2 grow text-sm leading-5 text-slate-600">Labor cost, product-wise and detailed reports for smarter business decisions.</p>
                    <div class="my-4.5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>
                    <a href="{{ route('central.register') }}" class="flex items-center gap-1 text-sm font-medium brand-text group">
                        View Reports
                        <svg class="transition-transform duration-300 group-hover:translate-x-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#1a4a7a" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const tiles = document.querySelectorAll('.feature-tile');
            if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            tiles.forEach((tile, i) => {
                tile.classList.add('feature-anim');
                tile.style.transitionDelay = `${(i % 3) * 90}ms`;
                io.observe(tile);
            });
        })();
    </script>

    {{-- About Section --}}
    <section id="about" class="w-full bg-slate-50 px-4 py-20 ">
        <div class="mx-auto grid w-full max-w-6xl grid-cols-1 items-center gap-12 lg:grid-cols-2 container">
            <div>
                <div class="inline-block rounded-full border border-slate-200 bg-white px-4 py-1.5 text-sm text-slate-800">
                    About Us
                </div>

                <h2 class="mt-7 text-4xl sm:text-5xl font-medium text-slate-900">
                    Built for Pipe Manufacturers
                </h2>

                <p class="mt-4 text-sm md:text-base leading-6 text-slate-600">
                    SPB Pipes brings orders, invoicing, inventory, production and finances together in one secure workspace — so you spend less time on paperwork and more time making pipes.
                </p>
                <p class="mt-3 text-sm md:text-base leading-6 text-slate-600">
                    From a single workshop to multiple units, the platform grows with your business and keeps every order, payment and report within reach.
                </p>

                <a href="{{ route('central.register') }}" class="btn-brand mt-8 inline-flex items-center gap-2 rounded-lg px-7 h-11 text-sm font-medium">
                    Get Started Today
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.333 8h9.334M8 3.336l4.667 4.667L8 12.669" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>

                <div class="mt-10 grid max-w-md grid-cols-3 gap-6">
                    <div>
                        <p class="text-2xl font-semibold brand-text">100+</p>
                        <p class="mt-1 text-xs leading-4 text-slate-500">Manufacturers on board</p>
                    </div>
                    <div>
                        <p class="text-2xl font-semibold brand-text">50k+</p>
                        <p class="mt-1 text-xs leading-4 text-slate-500">Invoices processed</p>
                    </div>
                    <div>
                        <p class="text-2xl font-semibold brand-text">99.9%</p>
                        <p class="mt-1 text-xs leading-4 text-slate-500">Platform uptime</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-shadow duration-300 hover:shadow-md hover:shadow-slate-200/70">
                    <div class="brand-gradient flex size-11 shrink-0 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="7.083" stroke="#fff" stroke-width="2"/><circle cx="10" cy="10" r="3.333" stroke="#fff" stroke-width="2"/><path d="M10 10.008V10" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Our Mission</h3>
                        <p class="mt-1 text-sm leading-5 text-slate-600">To simplify how pipe businesses run their day — reliable tools, honest pricing and technology that stays out of the way.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-shadow duration-300 hover:shadow-md hover:shadow-slate-200/70">
                    <div class="brand-gradient flex size-11 shrink-0 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.667 10S4.583 4.167 10 4.167 18.333 10 18.333 10 15.417 15.833 10 15.833 1.667 10 1.667 10Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="10" r="2.5" stroke="#fff" stroke-width="2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Our Vision</h3>
                        <p class="mt-1 text-sm leading-5 text-slate-600">To be the operating system behind every growing pipe manufacturer — from first order to final delivery.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-shadow duration-300 hover:shadow-md hover:shadow-slate-200/70">
                    <div class="brand-gradient flex size-11 shrink-0 items-center justify-center rounded-lg shadow-sm">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.083 7.292a4.167 4.167 0 0 0-7.083-2.95 4.167 4.167 0 1 0-5.892 5.892l5.892 5.891 5.892-5.891a4.167 4.167 0 0 0 1.191-2.942Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Our Values</h3>
                        <p class="mt-1 text-sm leading-5 text-slate-600">Quality, integrity and customer satisfaction are at the heart of everything we build and support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section id="testimonials" class="py-20">
        <div class="mx-auto flex w-full flex-col items-center px-4">
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-sm text-slate-800">
                Testimonials
            </div>

            <h2 class="mt-7 text-center text-5xl font-medium text-slate-900">
                What Our Customers Say
            </h2>

            <p class="mt-3 max-w-[540px] text-center text-sm md:text-base text-slate-600">
                Trusted by pipe manufacturers and operations teams across India.
            </p>
        </div>

        <style>
            @keyframes marqueeScroll {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .marquee-inner {
                animation: marqueeScroll 25s linear infinite;
            }

            .marquee-reverse {
                animation-direction: reverse;
            }
        </style>

        <div class="marquee-row w-full mx-auto max-w-5xl overflow-hidden relative container">
            <div class="absolute left-0 top-0 h-full w-20 z-10 pointer-events-none bg-gradient-to-r from-white to-transparent"></div>
            <div class="marquee-inner flex transform-gpu min-w-[200%] pt-10 pb-5" id="row1"></div>
            <div class="absolute right-0 top-0 h-full w-20 md:w-40 z-10 pointer-events-none bg-gradient-to-l from-white to-transparent"></div>
        </div>

        <div class="marquee-row w-full mx-auto max-w-5xl overflow-hidden relative container">
            <div class="absolute left-0 top-0 h-full w-20 z-10 pointer-events-none bg-gradient-to-r from-white to-transparent"></div>
            <div class="marquee-inner marquee-reverse flex transform-gpu min-w-[200%] pt-5 pb-10" id="row2"></div>
            <div class="absolute right-0 top-0 h-full w-20 md:w-40 z-10 pointer-events-none bg-gradient-to-l from-white to-transparent"></div>
        </div>

        <script>
            const cardsData = [
                {
                    image: '{{ asset("assets/img/profiles/avatar-01.jpg") }}',
                    name: 'Ramesh Patel',
                    handle: '@rameshpatel',
                    date: 'April 20, 2025',
                    text: 'We moved all our orders, billing and inventory onto SPB Pipes. Setup took minutes — not months.'
                },
                {
                    image: '{{ asset("assets/img/profiles/avatar-04.jpg") }}',
                    name: 'Priya Sharma',
                    handle: '@priyasharma',
                    date: 'May 10, 2025',
                    text: 'Each unit runs independently while I keep full control from one dashboard. Reporting that took a day now takes minutes.'
                },
                {
                    image: '{{ asset("assets/img/profiles/avatar-07.jpg") }}',
                    name: 'Amit Verma',
                    handle: '@amitverma',
                    date: 'June 5, 2025',
                    text: 'Upgrading plans is effortless and support is genuinely responsive. The first system our team enjoys using daily.'
                },
                {
                    image: '{{ asset("assets/img/profiles/avatar-12.jpg") }}',
                    name: 'Sneha Kapoor',
                    handle: '@snehakapoor',
                    date: 'July 18, 2025',
                    text: 'Gate passes, labor reports and invoices in one place — our dispatch desk runs twice as fast now.'
                },
            ];

            const row1 = document.getElementById('row1');
            const row2 = document.getElementById('row2');

            const createCard = (card) => `
                <div class="p-4 rounded-lg mx-4 shadow hover:shadow-lg transition-all duration-200 w-72 shrink-0">
                    <div class="flex gap-2">
                        <img class="size-11 rounded-full" src="${card.image}" alt="User Image">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1">
                                <p>${card.name}</p>
                                <svg class="mt-0.5" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.555.72a4 4 0 0 1-.297.24c-.179.12-.38.202-.59.244a4 4 0 0 1-.38.041c-.48.039-.721.058-.922.129a1.63 1.63 0 0 0-.992.992c-.071.2-.09.441-.129.922a4 4 0 0 1-.041.38 1.6 1.6 0 0 1-.245.59 3 3 0 0 1-.239.297c-.313.368-.47.551-.56.743-.213.444-.213.96 0 1.404.09.192.247.375.56.743.125.146.187.219.24.297.12.179.202.38.244.59.018.093.026.189.041.38.039.48.058.721.129.922.163.464.528.829.992.992.2.071.441.09.922.129.191.015.287.023.38.041.21.042.411.125.59.245.078.052.151.114.297.239.368.313.551.47.743.56.444.213.96.213 1.404 0 .192-.09.375-.247.743-.56.146-.125.219-.187.297-.24.179-.12.38-.202.59-.244a4 4 0 0 1 .38-.041c.48-.039.721-.058.922-.129.464-.163.829-.528.992-.992.071-.2.09-.441.129-.922a4 4 0 0 1 .041-.38c.042-.21.125-.411.245-.59.052-.078.114-.151.239-.297.313-.368.47-.551.56-.743.213-.444.213-.96 0-1.404-.09-.192-.247-.375-.56-.743a4 4 0 0 1-.24-.297 1.6 1.6 0 0 1-.244-.59 3 3 0 0 1-.041-.38c-.039-.48-.058-.721-.129-.922a1.63 1.63 0 0 0-.992-.992c-.2-.071-.441-.09-.922-.129a4 4 0 0 1-.38-.041 1.6 1.6 0 0 1-.59-.245A3 3 0 0 1 7.445.72C7.077.407 6.894.25 6.702.16a1.63 1.63 0 0 0-1.404 0c-.192.09-.375.247-.743.56m4.07 3.998a.488.488 0 0 0-.691-.69l-2.91 2.91-.958-.957a.488.488 0 0 0-.69.69l1.302 1.302c.19.191.5.191.69 0z" fill="#2196F3" />
                                </svg>
                            </div>
                            <span class="text-xs text-slate-500">${card.handle}</span>
                        </div>
                    </div>
                    <p class="text-sm py-4 text-gray-800">${card.text}</p>
                    <div class="flex items-center justify-between text-slate-500 text-xs">
                        <div class="flex items-center gap-1">
                            <span>Posted on</span>
                            <a href="https://x.com" target="_blank" class="hover:text-sky-500">
                                <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m.027 0 4.247 5.516L0 10h.962l3.742-3.926L7.727 10H11L6.514 4.174 10.492 0H9.53L6.084 3.616 3.3 0zM1.44.688h1.504l6.64 8.624H8.082z" fill="currentColor" />
                                </svg>
                            </a>
                        </div>
                        <p>${card.date}</p>
                    </div>
                </div>
            `;

            const renderCards = (target) => {
                const doubled = [...cardsData, ...cardsData];
                doubled.forEach(card => target.insertAdjacentHTML('beforeend', createCard(card)));
            };

            renderCards(row1);
            renderCards(row2);
        </script>
    </section>

    {{-- Pricing Section --}}
    <section id="pricing" class="w-full px-4 py-20">
        <div class="mx-auto flex w-full flex-col items-center">
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-sm text-slate-800">
                Pricing
            </div>

            <h2 class="mt-7 text-center text-4xl sm:text-5xl font-medium text-slate-900">
                Simple, Transparent Pricing
            </h2>

            <p class="mt-3 max-w-[540px] text-center text-sm md:text-base text-slate-600">
                Choose a plan that fits your business. Start free, upgrade anytime.
            </p>

            <div class="mt-10 grid w-full max-w-6xl grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @php $paidPlans = $plans->reject(fn ($plan) => $plan->isFree()); @endphp
                @forelse ($paidPlans as $plan)
                    <div class="flex flex-col rounded-xl border bg-white p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/70 {{ $plan->is_default ? 'plan-featured border-transparent' : 'border-slate-200' }}">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $plan->name }}</h3>
                            @if ($plan->is_default)
                                <span class="brand-gradient shrink-0 rounded-full px-3 py-1 text-xs font-medium text-white">Recommended</span>
                            @endif
                        </div>

                        @if ($plan->description)
                            <p class="mt-2 text-sm leading-5 text-slate-600">{{ $plan->description }}</p>
                        @endif

                        <div class="mt-5">
                            @if ($plan->isFree())
                                <span class="text-4xl font-semibold text-slate-900">Free</span>
                                <span class="text-sm text-slate-500">forever</span>
                            @else
                                <span class="text-4xl font-semibold text-slate-900">{{ $plan->currency }} {{ number_format($plan->price) }}</span>
                                <span class="text-sm text-slate-500">/{{ $plan->billing_period }}</span>
                            @endif
                            @if ($plan->trial_days > 0)
                                <div class="mt-2 flex items-center gap-1.5 text-sm text-emerald-600">
                                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="8" cy="8" r="6.333" stroke="currentColor" stroke-width="1.5"/><path d="M8 4.667V8l2.333 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                    {{ $plan->trial_days }}-day free trial
                                </div>
                            @endif
                        </div>

                        <div class="my-5 h-px w-full bg-linear-to-r from-slate-100 via-slate-200 to-slate-100"></div>

                        <ul class="mb-6 grow space-y-2.5">
                            @foreach ($limitKeys as $key)
                                @php $value = $plan->limit($key); @endphp
                                <li class="flex items-center gap-2 text-sm">
                                    <svg class="shrink-0" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m3.333 8.5 3 3 6.334-6.667" stroke="#1a4a7a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="capitalize text-slate-600">{{ str_replace('_', ' ', $key) }}:
                                        @if ($value < 0)
                                            <span class="font-medium text-slate-900">Unlimited</span>
                                        @else
                                            <span class="font-medium text-slate-900">{{ $value }}</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        @if ($plan->isFree() || $plan->trial_days > 0)
                            <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="{{ $plan->is_default ? 'btn-brand' : 'btn-outline-brand' }} mt-auto flex h-11 items-center justify-center rounded-lg text-sm font-medium">
                                Start Free Trial
                            </a>
                        @else
                            <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="{{ $plan->is_default ? 'btn-brand' : 'btn-outline-brand' }} mt-auto flex h-11 items-center justify-center rounded-lg text-sm font-medium">
                                Get Started
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                        <p class="text-sm text-slate-600">Plans are not available yet. Please check back soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

    
