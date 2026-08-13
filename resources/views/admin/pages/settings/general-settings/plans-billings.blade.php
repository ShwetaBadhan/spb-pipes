@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @if (session('billing_success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('billing_success') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if (session('billing_error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('billing_error') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($planService->isExpired())
                <div class="alert alert-{{ $planService->status() === 'pending' ? 'warning' : 'danger' }} d-flex align-items-center gap-2" role="alert">
                    <i class="isax isax-warning-2"></i>
                    <div>
                        @if ($planService->status() === 'pending')
                            Your subscription is <strong>pending</strong> and the workspace is locked. Complete your payment below to activate it.
                        @else
                            Your subscription is <strong>{{ ucfirst($planService->status() ?? 'expired') }}</strong> and create actions are
                            blocked. Upgrade below to continue using the workspace.
                        @endif
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Plans & Billing</h6>
                                </div>

                                {{-- Current Plan --}}
                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-info-circle fs-14"></i></span>
                                    <h6 class="fs-16 fw-semibold mb-0">Current Plan</h6>
                                </div>
                                <div class="mb-3 border-bottom">
                                    <div class="card shadow-none bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <h5 class="fw-bold mb-0">
                                                            @if ($plan)
                                                                {{ $plan->name }}
                                                                @if (!$plan->isFree())
                                                                    <span class="fs-14 text-muted fw-normal">· {{ $plan->currency }} {{ number_format($plan->price) }}/{{ $plan->billing_period }}</span>
                                                                @endif
                                                            @else
                                                                Legacy / No Plan
                                                            @endif
                                                        </h5>
                                                        <span class="badge badge-soft-{{ $planService->status() === 'pending' ? 'warning' : ($planService->isExpired() ? 'danger' : 'success') }}">
                                                            {{ ucfirst($planService->status() ?? 'active') }}
                                                        </span>
                                                    </div>
                                                    <div class="fs-14 text-muted">
                                                        @if ($planService->status() === 'pending')
                                                            Payment pending — complete payment below to activate your workspace.
                                                        @elseif ($planService->isExpired())
                                                            Subscription ended
                                                        @elseif ($plan && $plan->isFree() && $planService->status() === 'trialing')
                                                            Trial {{ $plan->trial_days }} days · started {{ $planService->subscription()?->created_at?->format('d M Y') }}
                                                        @elseif ($planService->subscription()?->ends_at)
                                                            Valid until {{ $planService->subscription()->ends_at->format('d M Y') }}
                                                        @else
                                                            Unlimited access
                                                        @endif
                                                    </div>
                                                </div>
                                                @if (!$planService->isExpired() || $planService->status() === 'pending')
                                                    <button type="button" class="btn btn-{{ $planService->status() === 'pending' ? 'warning' : 'primary' }} btn-md d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#upgradeModal">
                                                        @if ($planService->status() === 'pending')
                                                            <i class="isax isax-card me-1"></i>Complete Payment
                                                        @else
                                                            <i class="isax isax-crown me-1"></i>Upgrade
                                                        @endif
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Usage meters --}}
                                @if ($plan && !$planService->isExpired())
                                    <div class="mb-3 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-chart-2 fs-14"></i></span>
                                            <h6 class="fs-16 fw-semibold mb-0">Usage</h6>
                                        </div>
                                        <div class="row g-3 mb-4">
                                            @foreach ($usages as $key => $meter)
                                                <div class="col-md-6 col-xl-4">
                                                    <div class="card shadow-none border mb-0">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="fs-14 fw-medium text-capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                                                @if ($meter['unlimited'])
                                                                    <span class="badge badge-soft-info">Unlimited</span>
                                                                @else
                                                                    <span class="badge badge-soft-{{ $meter['within'] ? 'success' : 'danger' }}">{{ $meter['usage'] }} / {{ $meter['limit'] }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="progress progress-sm" role="progressbar" aria-label="{{ $key }}" aria-valuenow="{{ $meter['usage'] }}" aria-valuemin="0" aria-valuemax="{{ $meter['limit'] > 0 ? $meter['limit'] : 1 }}">
                                                                <div class="progress-bar bg-{{ $meter['within'] ? 'success' : 'danger' }}" style="width: {{ $meter['unlimited'] || $meter['limit'] <= 0 ? 0 : min(100, round($meter['usage'] / $meter['limit'] * 100)) }}%"></div>
                                                            </div>
                                                            @if (!$meter['unlimited'])
                                                                <div class="fs-12 text-muted mt-1">{{ $meter['remaining'] }} remaining</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Transactions --}}
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-transaction-minus fs-14"></i></span>
                                        <h6 class="fs-16 fw-semibold mb-0">Transactions</h6>
                                    </div>
                                    <div class="table-responsive table-nowrap">
                                        <table class="table border mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Plan Name</th>
                                                    <th>Gateway</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($payments as $payment)
                                                    <tr>
                                                        <td>{{ $payment->meta['plan_name'] ?? '—' }}</td>
                                                        <td class="text-capitalize">{{ $payment->gateway }}</td>
                                                        <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                                        <td>{{ $payment->created_at?->format('d M Y') }}</td>
                                                        <td>
                                                            <span class="badge badge-soft-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($payment->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">No transactions yet.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Upgrade modal --}}
    <div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upgradeModalLabel">{{ $planService->status() === 'pending' ? 'Complete Your Payment' : 'Choose a Plan' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse ($availablePlans as $availablePlan)
                        <div class="card border mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $availablePlan->name }}</h6>
                                        <span class="fs-18 fw-semibold">
                                            @if ($availablePlan->isFree())
                                                Free
                                            @else
                                                {{ $availablePlan->currency }} {{ number_format($availablePlan->price) }}
                                                <span class="fs-12 text-muted fw-normal">/{{ $availablePlan->billing_period }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="fs-12 text-muted text-end">
                                        @foreach ($availablePlan->limits ?? [] as $key => $value)
                                            @if ($value >= 0)
                                                <div class="text-capitalize">{{ str_replace('_', ' ', $key) }}: {{ $value }}</div>
                                            @else
                                                <div class="text-capitalize">{{ str_replace('_', ' ', $key) }}: Unlimited</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @if ($availablePlan->description)
                                    <p class="fs-13 text-muted mb-2">{{ $availablePlan->description }}</p>
                                @endif
                                <div class="d-flex align-items-center gap-2">
                                    @if ($gateways['stripe'])
                                        <form action="{{ route('billing.checkout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $availablePlan->id }}">
                                            <input type="hidden" name="gateway" value="stripe">
                                            <button class="btn btn-primary">Pay with Stripe</button>
                                        </form>
                                    @endif
                                    @if ($gateways['razorpay'])
                                        <form action="{{ route('billing.checkout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan_id" value="{{ $availablePlan->id }}">
                                            <input type="hidden" name="gateway" value="razorpay">
                                            <button class="btn btn-dark">Pay with Razorpay</button>
                                        </form>
                                    @endif
                                    @if (!$gateways['stripe'] && !$gateways['razorpay'])
                                        <span class="fs-13 text-muted">Online payment is not configured yet. Please contact support.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted mb-0">No other plans available right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
