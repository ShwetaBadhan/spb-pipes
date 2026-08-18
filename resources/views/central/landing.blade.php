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

    @include('central.components.guest-header')

    <section id="home" class="hero-section text-white position-relative overflow-hidden">
        <div class="hero-glow hero-glow-1" aria-hidden="true"></div>
        <div class="hero-glow hero-glow-2" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 rounded-pill px-3 py-2 fs-13 mb-4 text-dark">
                        <i class="isax isax-flash text-warning me-1"></i> New: Free 14-day trial &middot; No credit card required
                    </span>
                    <h1 class="display-4 mb-3 lh-sm">Run Your <span class="text-warning">Pipe Business</span> From One Place</h1>
                    <p class="lead mb-4">SPB Pipes brings tenants, orders, inventory, billing and reporting together in a single secure platform — built for pipe manufacturers.</p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('central.register') }}" class="btn btn-light btn-lg px-4">
                            Start Free Trial <i class="isax isax-arrow-right-1 ms-1"></i>
                        </a>
                        <a href="#pricing" class="btn btn-outline-light btn-lg px-4">
                            <i class="isax isax-eye me-1"></i>View Pricing
                        </a>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <span class="hero-avatar bg-info text-white">RP</span>
                            <span class="hero-avatar bg-success text-white" style="margin-left:-10px">PS</span>
                            <span class="hero-avatar bg-warning text-dark" style="margin-left:-10px">AV</span>
                            <span class="hero-avatar bg-white bg-opacity-10 text-white border border-white" style="margin-left:-10px">+97</span>
                        </div>
                        <div>
                            <div class="text-warning testimonial-stars fs-14">
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                                <i class="isax isax-star-1"></i>
                            </div>
                            <div class="fs-13 opacity-75">Trusted by 100+ pipe manufacturers</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-preview bg-white rounded-4 p-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex gap-1">
                                <span class="rounded-circle bg-danger d-inline-block" style="width:10px;height:10px"></span>
                                <span class="rounded-circle bg-warning d-inline-block" style="width:10px;height:10px"></span>
                                <span class="rounded-circle bg-success d-inline-block" style="width:10px;height:10px"></span>
                            </div>
                            <span class="fs-13 text-muted fw-medium">SPB Pipes Dashboard</span>
                            <i class="isax isax-setting-2 text-muted"></i>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="border rounded-3 p-3 text-center">
                                    <span class="fs-20 fw-bold text-primary d-block">1,240</span>
                                    <span class="fs-12 text-muted">Customers</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded-3 p-3 text-center">
                                    <span class="fs-20 fw-bold text-success d-block">842</span>
                                    <span class="fs-12 text-muted">Invoices</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded-3 p-3 text-center">
                                    <span class="fs-20 fw-bold text-info d-block">₹48.2L</span>
                                    <span class="fs-12 text-muted">Revenue</span>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-3 p-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fs-13 fw-medium">Plan Usage</span>
                                <span class="fs-12 text-success">82%</span>
                            </div>
                            <div class="progress progress-sm mb-3" role="progressbar">
                                <div class="progress-bar bg-success" style="width:82%"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px">
                                        <i class="isax isax-buildings fs-14"></i>
                                    </span>
                                    <div>
                                        <div class="fs-13 fw-medium">Tenant Management</div>
                                        <div class="fs-12 text-muted">128 tenants active</div>
                                    </div>
                                </div>
                                <span class="badge badge-soft-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    
