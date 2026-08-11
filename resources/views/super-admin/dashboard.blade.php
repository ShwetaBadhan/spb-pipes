@extends('super-admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Total Tenants</div>
            <div class="value">{{ $stats['tenants'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Active</div>
            <div class="value text-success">{{ $stats['active_tenants'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Trial</div>
            <div class="value text-primary">{{ $stats['trial_tenants'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Suspended</div>
            <div class="value text-danger">{{ $stats['suspended_tenants'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Plans</div>
            <div class="value">{{ $stats['plans'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Active Subscriptions</div>
            <div class="value">{{ $stats['subscriptions'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Monthly Recurring Revenue</div>
            <div class="value">${{ number_format($stats['mrr'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Collected Revenue</div>
            <div class="value">${{ number_format($stats['revenue'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">ARPU</div>
            <div class="value">${{ number_format($stats['arpu'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="label">Churn Rate</div>
            <div class="value text-danger">{{ $stats['churn_rate'] }}%</div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><h6 class="mb-0">MRR & Churn Trend — Last 6 Months</h6></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>Month</th><th>MRR</th><th>Churned</th></tr>
            </thead>
            <tbody>
                @foreach($mrrTrend as $month)
                    <tr>
                        <td><strong>{{ $month['label'] }}</strong></td>
                        <td>${{ number_format($month['mrr'], 2) }}</td>
                        <td>{{ $month['churned'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Recent Tenants</h6>
        <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Slug</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTenants as $tenant)
                    <tr>
                        <td><a href="{{ route('super-admin.tenants.show', $tenant) }}">{{ $tenant->name }}</a></td>
                        <td><code>{{ $tenant->slug }}</code></td>
                        <td>{{ $tenant->plan?->name ?? ($tenant->plan_slug ?? '—') }}</td>
                        <td>
                            @if($tenant->status === 'active')
                                <span class="badge bg-success">active</span>
                            @elseif($tenant->status === 'trial')
                                <span class="badge bg-primary">trial</span>
                            @elseif($tenant->status === 'suspended')
                                <span class="badge bg-danger">suspended</span>
                            @else
                                <span class="badge bg-secondary">{{ $tenant->status }}</span>
                            @endif
                        </td>
                        <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No tenants yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
