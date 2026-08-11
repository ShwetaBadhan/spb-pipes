@extends('super-admin.layouts.master')

@section('title', $tenant->name)

@section('content')
@php
    $statusColor = match ($tenant->status) {
        'active' => 'success',
        'trial' => 'primary',
        'suspended' => 'danger',
        default => 'secondary',
    };
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">{{ $tenant->name }}</h4>
        <span class="badge bg-{{ $statusColor }}">{{ $tenant->status }}</span>
        @if($tenant->status === 'suspended')
            <form method="POST" action="{{ route('super-admin.tenants.reactivate', $tenant) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="btn btn-sm btn-success">Reactivate</button>
            </form>
        @else
            <form method="POST" action="{{ route('super-admin.tenants.suspend', $tenant) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="btn btn-sm btn-outline-danger">Suspend</button>
            </form>
        @endif
        <a href="{{ route('super-admin.tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary">Edit</a>
    </div>
    <div>
        <form method="POST" action="{{ route('super-admin.tenants.change-plan', $tenant) }}" class="d-flex gap-2 align-items-center">
            @csrf @method('PATCH')
            <select name="plan_id" class="form-select form-select-sm">
                @foreach(\App\Models\Plan::orderBy('price_monthly')->get() as $plan)
                    <option value="{{ $plan->id }}" @if($tenant->plan_id === $plan->id) selected @endif>
                        {{ $plan->name }} — ${{ $plan->price_monthly }}/mo
                    </option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-primary">Change Plan</button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Users</div>
            <div class="value">{{ $usage['users'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Products</div>
            <div class="value">{{ $usage['products'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Customers</div>
            <div class="value">{{ $usage['customers'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Invoices</div>
            <div class="value">{{ $usage['invoices'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Orders</div>
            <div class="value">{{ $usage['orders'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Subscriptions</div>
            <div class="value">{{ $tenant->subscriptions()->count() }}</div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><h6 class="mb-0">Plan Limits — {{ $tenant->plan?->name ?? 'No plan' }}</h6></div>
    <div class="card-body">
        <div class="row g-4">
            @foreach ([['users', 'Users'], ['products', 'Products'], ['invoices', 'Invoices']] as [$key, $label])
                @php
                    $max = $limits[$key] ?? PHP_INT_MAX;
                    $used = $usage[$key];
                    $percent = $max === PHP_INT_MAX ? 0 : min(100, round($used / max(1, $max) * 100));
                @endphp
                <div class="col-md-4">
                    <div class="d-flex justify-content-between small">
                        <span>{{ $label }}</span>
                        <span>{{ $used }} / {{ $max === PHP_INT_MAX ? 'unlimited' : $max }}</span>
                    </div>
                    <div class="progress mt-1" style="height: 8px;">
                        <div class="progress-bar {{ $percent >= 100 ? 'bg-danger' : ($percent >= 80 ? 'bg-warning' : 'bg-success') }}"
                            style="width: {{ $percent }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row mt-4 g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Subscriptions</h6>
                <a href="{{ route('super-admin.tenants.domains', $tenant) }}" class="btn btn-sm btn-outline-primary">Domains</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Plan</th><th>Status</th><th>Price</th><th>Ends</th></tr></thead>
                    <tbody>
                        @forelse($tenant->subscriptions as $sub)
                            <tr>
                                <td>{{ $sub->plan?->name ?? '—' }}</td>
                                <td><span class="badge bg-info">{{ $sub->status }}</span></td>
                                <td>${{ $sub->plan?->price_monthly ?? 0 }}</td>
                                <td>{{ $sub->ends_at?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No subscriptions.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Add-ons</h6></div>
            <div class="card-body">
                <ul class="mb-0">
                    @forelse($tenant->addons as $addon)
                        <li>{{ $addon->name }} <span class="badge bg-light text-dark">${{ $addon->price_monthly }}/mo</span></li>
                    @empty
                        <li class="text-muted">No add-ons.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Invoices</h6></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Stripe Invoice</th><th>Amount</th><th>Status</th><th>Invoiced</th></tr></thead>
                    <tbody>
                        @forelse($tenant->billingInvoices->take(8) as $inv)
                            <tr>
                                <td><code class="small">{{ $inv->stripe_invoice_id ?? '#' . $inv->id }}</code></td>
                                <td>${{ number_format($inv->amount, 2) }}</td>
                                <td><span class="badge bg-{{ $inv->status === 'paid' ? 'success' : 'warning' }}">{{ $inv->status }}</span></td>
                                <td>{{ $inv->invoice_date?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No invoices.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Payments</h6></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Reference</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($tenant->payments->take(8) as $payment)
                            <tr>
                                <td>{{ $payment->reference }}</td>
                                <td>${{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->method }}</td>
                                <td><span class="badge bg-{{ $payment->status === 'success' ? 'success' : 'secondary' }}">{{ $payment->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No payments.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
