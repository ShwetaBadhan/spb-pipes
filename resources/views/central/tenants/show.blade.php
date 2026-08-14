@extends('central.layout')

@section('title', 'Tenant Details - ' . $tenant->name)

@section('content')
    @php
        $planStatus = $tenant->subscription_status;
        $domain = $tenant->domains->first()?->domain;
        $statMeta = [
            'users' => ['label' => 'Users', 'icon' => 'isax isax-profile-2user5'],
            'customers' => ['label' => 'Customers', 'icon' => 'isax isax-user-tag'],
            'products' => ['label' => 'Products', 'icon' => 'isax isax-box'],
            'invoices' => ['label' => 'Invoices', 'icon' => 'isax isax-receipt'],
            'gate_passes' => ['label' => 'Gate Passes', 'icon' => 'isax isax-ticket-2'],
            'raw_materials' => ['label' => 'Raw Materials', 'icon' => 'isax isax-clipboard-text'],
        ];
    @endphp

    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 flex-wrap">
        <div>
            <a href="{{ route('central.tenants.index') }}" class="fs-14 text-primary text-decoration-none mb-1 d-inline-block">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Tenants
            </a>
            <h5 class="mb-0 d-flex align-items-center gap-2 flex-wrap">
                <i class="isax isax-building text-primary"></i> {{ $tenant->name }}
                <code class="fs-13">{{ $tenant->id }}</code>
                @if ($tenant->plan)
                    <span class="badge bg-primary-subtle text-primary">{{ $tenant->plan->name }}</span>
                @endif
                @if (in_array($planStatus, ['trialing', 'active']))
                    <span class="badge bg-success-subtle text-success">{{ ucfirst($planStatus) }}</span>
                @elseif ($planStatus)
                    <span class="badge bg-danger-subtle text-danger">{{ ucfirst($planStatus) }}</span>
                @endif
            </h5>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            @if ($domain)
                <a href="http://{{ $domain }}:8000" target="_blank" class="btn btn-sm btn-soft-secondary">
                    <i class="isax isax-export-1 me-1"></i> Visit Site
                </a>
            @endif
            <a href="{{ route('central.tenants.login', $tenant) }}" class="btn btn-sm btn-soft-success">
                <i class="isax isax-login me-1"></i> Move to Tenant
            </a>
            <a href="{{ route('central.tenants.edit', $tenant) }}" class="btn btn-sm btn-soft-primary">Edit</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-7">
            <div class="row g-3">
                @foreach ($statMeta as $key => $meta)
                    @php
                        $item = $usage[$key];
                        $barClass = $item['percent'] >= 100 ? 'bg-danger' : ($item['percent'] >= 80 ? 'bg-warning' : 'bg-success');
                        $limitText = $item['unlimited'] ? 'Unlimited' : number_format($item['limit']);
                        $usageText = $item['unlimited'] ? number_format($item['usage']) : number_format($item['usage']) . ' / ' . $limitText;
                    @endphp
                    <div class="col-md-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-flex align-items-center gap-2 fs-14 fw-medium text-muted">
                                        <i class="{{ $meta['icon'] }} fs-16 text-primary"></i> {{ $meta['label'] }}
                                    </span>
                                    <span class="fs-14 text-muted">{{ $usageText }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 fw-bold">{{ number_format($item['usage']) }}</h4>
                                    @if (! $item['unlimited'] && $item['percent'] >= 100)
                                        <span class="badge bg-danger-subtle text-danger fs-12">Limit reached</span>
                                    @elseif (! $item['unlimited'] && $item['percent'] >= 80)
                                        <span class="badge bg-warning-subtle text-warning fs-12">Almost full</span>
                                    @endif
                                </div>
                                @if (! $item['unlimited'])
                                    <div class="progress progress-sm mt-3" role="progressbar" aria-valuenow="{{ $item['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar {{ $barClass }}" style="width: {{ $item['percent'] }}%"></div>
                                    </div>
                                    <div class="fs-12 text-muted mt-1">{{ $item['remaining'] }} remaining</div>
                                @else
                                    <div class="fs-12 text-muted mt-3">No limit on this plan</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="isax isax-clipboard-text me-1"></i> Plan Usage &amp; Limits</h6>
                    @if ($tenant->plan)
                        <span class="badge bg-primary-subtle text-primary">{{ $tenant->plan->name }}</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Resource</th>
                                    <th class="text-center">Used</th>
                                    <th class="text-center">Limit</th>
                                    <th class="text-center">Remaining</th>
                                    <th style="width: 30%;">Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usage as $key => $item)
                                    @php
                                        $barClass = $item['percent'] >= 100 ? 'bg-danger' : ($item['percent'] >= 80 ? 'bg-warning' : 'bg-success');
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <i class="{{ $statMeta[$key]['icon'] }} text-primary"></i>
                                                {{ $statMeta[$key]['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ number_format($item['usage']) }}</td>
                                        <td class="text-center">{{ $item['unlimited'] ? '∞' : number_format($item['limit']) }}</td>
                                        <td class="text-center">{{ $item['unlimited'] ? '∞' : number_format($item['remaining']) }}</td>
                                        <td>
                                            @if ($item['unlimited'])
                                                <span class="badge bg-success-subtle text-success">Unlimited</span>
                                            @else
                                                <div class="progress progress-sm" role="progressbar" aria-valuenow="{{ $item['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar {{ $barClass }}" style="width: {{ $item['percent'] }}%"></div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="isax isax-building me-1"></i> Tenant Information</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fs-14 fw-normal">Tenant ID</dt>
                        <dd class="col-7 fs-14 mb-2"><code>{{ $tenant->id }}</code></dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Domain</dt>
                        <dd class="col-7 fs-14 mb-2">
                            @if ($domain)
                                <a href="http://{{ $domain }}:8000" target="_blank" class="text-primary">{{ $domain }} <i class="fa-solid fa-arrow-up-right-from-square fs-12"></i></a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Admin Name</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $admin?->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Admin Email</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $admin?->email ?? '—' }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Created At</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $tenant->created_at?->format('d M Y h:i A') ?? '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="isax isax-crown me-1"></i> Subscription</h6>
                    @if ($tenant->plan)
                        <span class="fs-14 fw-medium">{{ $tenant->plan->currency }} {{ number_format($tenant->plan->price, 2) }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fs-14 fw-normal">Plan</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $tenant->plan?->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Status</dt>
                        <dd class="col-7 fs-14 mb-2">
                            @if (in_array($planStatus, ['trialing', 'active']))
                                <span class="badge bg-success-subtle text-success">{{ ucfirst($planStatus) }}</span>
                            @elseif ($planStatus)
                                <span class="badge bg-danger-subtle text-danger">{{ ucfirst($planStatus) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Starts At</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $tenant->activeSubscription?->starts_at?->format('d M Y') ?? '—' }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Trial Ends</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $tenant->trial_ends_at?->format('d M Y') ?? '—' }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Subscription Ends</dt>
                        <dd class="col-7 fs-14 mb-2">
                            {{ $tenant->subscription_ends_at?->format('d M Y') ?? '—' }}
                            @if ($tenant->subscription_ends_at?->isPast())
                                <span class="badge bg-danger-subtle text-danger fs-12">Expired</span>
                            @endif
                        </dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Billing Period</dt>
                        <dd class="col-7 fs-14 mb-2">{{ $tenant->plan?->billing_period ?? '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="isax isax-wallet-3 me-1"></i> Financials</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fs-14 fw-normal">Total Invoiced</dt>
                        <dd class="col-7 fs-14 mb-2 fw-semibold">{{ $tenant->plan?->currency ?? 'INR' }} {{ number_format($financials['invoice_total'], 2) }}</dd>
                        <dt class="col-5 text-muted fs-14 fw-normal">Invoices</dt>
                        <dd class="col-7 fs-14 mb-2">{{ number_format($financials['invoice_count']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0"><i class="isax isax-money-3 me-1"></i> Recent Payments</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Gateway</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td class="text-capitalize">{{ $payment->gateway }}</td>
                                <td>{{ $payment->subscription?->plan?->name ?? '—' }}</td>
                                <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if ($payment->status === 'paid')
                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                    @elseif ($payment->status === 'failed')
                                        <span class="badge bg-danger-subtle text-danger">Failed</span>
                                    @elseif ($payment->status === 'refunded')
                                        <span class="badge bg-secondary-subtle text-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $payment->paid_at?->format('d M Y h:i A') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No payments recorded for this tenant.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
