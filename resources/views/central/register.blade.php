@extends('central.layouts.app')
@section('title', 'SPB Pipes - Home')
@section('sections')

@push('styles')
    <style>
        .register-bg {
            background: linear-gradient(250deg, #26516f 0%, #2480ad 100%);
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
@endpush

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
                                @if ($plan->isFree())
                                    Skip Payment
                                @elseif ($plan->trial_days > 0)
                                    Start Free Trial
                                @else
                                    Create Workspace & Pay
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

   

@endsection
@push('scripts')
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
@endpush
