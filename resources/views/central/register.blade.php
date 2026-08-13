<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Create Your Workspace | SPB Pipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/iconsax.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

    <style>
        .register-bg {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            min-height: 100vh;
            padding: 48px 0;
        }
        .register-card {
            max-width: 560px;
            margin: 0 auto;
        }
        .input-group-text-sub {
            border: 1px solid #d9dee3;
            border-left: 0;
            background: #f5f6f8;
            color: #6c757d;
            font-size: .875rem;
            border-radius: 0 .375rem .375rem 0;
        }
    </style>
</head>

<body>

    @include('central.components.guest-header')

    <div class="register-bg">
        <div class="container">
            <div class="register-card">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/logo-spb.png') }}" alt="SPB Pipes Logo" height="44" class="mb-3">
                            <h4 class="fw-bold mb-1">Create Your Workspace</h4>
                            <p class="text-muted mb-0">Set up your SPB Pipes account in under a minute.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 px-3">
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('central.register.submit') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Select Plan</label>
                                <select name="plan_id" id="planSelect" class="form-select @error('plan_id') is-invalid @enderror">
                                    @foreach ($plans as $p)
                                        <option value="{{ $p->id }}"
                                            data-trial="{{ $p->trial_days }}"
                                            data-price="{{ $p->isFree() ? 'Free' : $p->currency . ' ' . number_format($p->price) . '/' . $p->billing_period }}"
                                            data-desc="{{ $p->description }}"
                                            {{ (int) old('plan_id', $plan->id) === $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} — {{ $p->isFree() ? 'Free' : $p->currency . ' ' . number_format($p->price) . '/' . $p->billing_period }}{{ $p->trial_days > 0 ? ' (' . $p->trial_days . '-day trial)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="mt-2 p-3 bg-light rounded-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-semibold" id="planName">{{ $plan->name }}</span>
                                        <span class="fs-15 fw-bold" id="planPrice">{{ $plan->isFree() ? 'Free' : $plan->currency . ' ' . number_format($plan->price) . '/' . $plan->billing_period }}</span>
                                    </div>
                                    <div class="fs-13 text-muted" id="planDesc">{{ $plan->description }}</div>
                                    <div class="fs-13 text-success mt-1" id="planTrial">
                                        @if ($plan->trial_days > 0)
                                            <i class="isax isax-timer"></i> {{ $plan->trial_days }}-day free trial — no card required
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Business Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. ACME Pipes Pvt Ltd" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subdomain">Workspace Subdomain</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('subdomain') is-invalid @enderror" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" placeholder="acme" required>
                                    @if ($domainSuffix)
                                        <span class="input-group-text-sub">{{ '.' . $domainSuffix }}</span>
                                    @endif
                                </div>
                                @error('subdomain')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @else
                                    <div class="form-text">Lowercase letters, numbers and hyphens only.</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="admin_name">Your Name</label>
                                    <input type="text" class="form-control @error('admin_name') is-invalid @enderror" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" placeholder="Full name" required>
                                    @error('admin_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="admin_email">Work Email</label>
                                    <input type="email" class="form-control @error('admin_email') is-invalid @enderror" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" placeholder="you@company.com" required>
                                    @error('admin_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="admin_password">Password</label>
                                    <input type="password" class="form-control @error('admin_password') is-invalid @enderror" id="admin_password" name="admin_password" placeholder="Min. 8 characters" required>
                                    @error('admin_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="admin_password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control @error('admin_password') is-invalid @enderror" id="admin_password_confirmation" name="admin_password_confirmation" placeholder="Re-enter password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-1" id="submitBtn">
                                @if ($plan->trial_days > 0)
                                    Start Free Trial
                                @else
                                    Create Workspace &amp; Pay
                                @endif
                            </button>

                            <p class="text-center text-muted small mt-3 mb-0">
                                Already have an account?
                                <a href="{{ route('central.login') }}" class="fw-semibold">Admin Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('central.components.guest-footer')

    <!-- jQuery -->
    <script src="{{ url('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ url('assets/js/script.js') }}"></script>

    <script>
        $(function () {
            var $select = $('#planSelect');
            var $btn = $('#submitBtn');

            function refreshPlan() {
                var $opt = $select.find(':selected');
                $('#planName').text($opt.text().split(' — ')[0]);
                $('#planPrice').text($opt.data('price') || '');
                $('#planDesc').text($opt.data('desc') || '');
                var trial = parseInt($opt.data('trial') || '0', 10);
                $('#planTrial').html(trial > 0
                    ? '<i class="isax isax-timer"></i> ' + trial + '-day free trial — no card required'
                    : '');
                $btn.html(trial > 0 ? 'Start Free Trial' : 'Create Workspace &amp; Pay');
            }

            $select.on('change', refreshPlan);
        });
    </script>

</body>

</html>
