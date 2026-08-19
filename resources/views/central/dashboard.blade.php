@extends('central.layout')

@section('title', 'Central Dashboard')

@section('content')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <h6 class="mb-0 fw-bold"><i class="isax isax-element-45 me-1"></i> Dashboard</h6>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('central.tenants.index') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="isax isax-add-square me-1"></i> Create Tenant
            </a>
        </div>
    </div>

    {{-- Row 1: Core Tenant KPIs --}}
    <div class="row g-3 mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Total Tenants</p>
                            <h5 class="fw-bold mb-0">{{ number_format($stats['total_tenants']) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0">
                            <i class="isax isax-building fs-20"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Active Tenants</p>
                            <h5 class="fw-bold mb-0 text-success">{{ number_format($stats['active_tenants']) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success flex-shrink-0">
                            <i class="isax isax-check-circle fs-20"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Trial Tenants</p>
                            <h5 class="fw-bold mb-0 text-info">{{ number_format($stats['trial_tenants']) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info flex-shrink-0">
                            <i class="isax isax-clock fs-20"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">New This Month</p>
                            <h5 class="fw-bold mb-0">{{ number_format($stats['new_this_month']) }}</h5>
                            @php $trend = $stats['new_last_month'] > 0 ? round((($stats['new_this_month'] - $stats['new_last_month']) / $stats['new_last_month']) * 100) : 0; @endphp
                            <small class="{{ $trend >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $trend >= 0 ? '+' : '' }}{{ $trend }}% vs last month
                            </small>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning flex-shrink-0">
                            <i class="isax isax-arrow-up-3 fs-20"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 2: Revenue & Subscription KPIs --}}
    <div class="row g-3 mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">MRR</p>
                            <h5 class="fw-bold mb-0">₹{{ number_format($stats['mrr'], 2) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success flex-shrink-0">
                            <i class="fas fa-indian-rupee-sign fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">ARR</p>
                            <h5 class="fw-bold mb-0">₹{{ number_format($stats['arr'], 2) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0">
                            <i class="fas fa-calendar-check fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Active Subscriptions</p>
                            <h5 class="fw-bold mb-0 text-success">{{ number_format($stats['active_subscriptions']) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success flex-shrink-0">
                            <i class="fas fa-rotate fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Outstanding Revenue</p>
                            <h5 class="fw-bold mb-0 text-danger">₹{{ number_format($stats['outstanding_revenue'], 2) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-danger-subtle text-danger flex-shrink-0">
                            <i class="fas fa-exclamation-triangle fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Rates & Alerts --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Trial Conversion</p>
                            <h5 class="fw-bold mb-0">{{ $stats['trial_conversion_rate'] }}%</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info flex-shrink-0">
                            <i class="fas fa-right-left fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Churn Rate</p>
                            <h5 class="fw-bold mb-0 {{ $stats['churn_rate'] > 5 ? 'text-danger' : '' }}">{{ $stats['churn_rate'] }}%</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-danger-subtle text-danger flex-shrink-0">
                            <i class="fas fa-user-minus fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Failed Payments</p>
                            <h5 class="fw-bold mb-0 {{ $stats['failed_payments'] > 0 ? 'text-warning' : '' }}">{{ number_format($stats['failed_payments']) }}</h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning flex-shrink-0">
                            <i class="fas fa-xmark-circle fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted fs-13">Suspended / Cancelled</p>
                            <h5 class="fw-bold mb-0">
                                <span class="text-warning">{{ $stats['suspended_tenants'] }}</span>
                                /
                                <span class="text-danger">{{ $stats['canceled_tenants'] }}</span>
                            </h5>
                        </div>
                        <span class="avatar avatar-44 avatar-rounded bg-secondary-subtle text-secondary flex-shrink-0">
                            <i class="fas fa-ban fs-18"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 1 --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Tenant Growth</h6>
                </div>
                <div class="card-body">
                    <canvas id="tenantGrowthChart" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Plan Distribution</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="planDistributionChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 2 --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">MRR Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="mrrChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Revenue Growth</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 3 --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Trial → Paid Conversion</h6>
                </div>
                <div class="card-body">
                    <canvas id="trialConversionChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Churn</h6>
                </div>
                <div class="card-body">
                    <canvas id="churnChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tenants --}}
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h6 class="mb-0">Recent Tenants</h6>
            <a href="{{ route('central.tenants.index') }}" class="fs-14 btn btn-soft-primary btn-sm">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Domain</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTenants as $tenant)
                            <tr>
                                <td><code>{{ Str::limit($tenant->id, 8) }}</code></td>
                                <td>{{ $tenant->name }}</td>
                                <td>
                                    @if($tenant->plan)
                                        <span class="badge badge-soft-primary">{{ $tenant->plan->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php $statusColor = match($tenant->subscription_status) {
                                        'active' => 'success',
                                        'trialing' => 'info',
                                        'canceled' => 'danger',
                                        'past_due' => 'danger',
                                        default => 'secondary',
                                    }; @endphp
                                    <span class="badge badge-soft-{{ $statusColor }}">{{ ucfirst($tenant->subscription_status ?? 'N/A') }}</span>
                                </td>
                                <td>
                                    @forelse ($tenant->domains as $domain)
                                        <a href="http://{{ $domain->domain }}:8000" target="_blank" class="text-primary">{{ $domain->domain }}</a>
                                    @empty
                                        <span class="text-muted">—</span>
                                    @endforelse
                                </td>
                                <td>{{ $tenant->created_at?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('central.tenants.show', $tenant) }}" class="btn btn-sm btn-soft-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No tenants yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const chartBaseUrl = '{{ route("central.dashboard.charts", "REPLACE") }}'.replace('REPLACE', '');
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

async function fetchChart(name) {
    const res = await fetch(chartBaseUrl + name, {
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    return res.json();
}

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { display: false }, ticks: { font: { size: 11 } } },
        y: { beginAtZero: true, grid: { color: '#f0f0f0' }, ticks: { font: { size: 11 } } }
    }
};

async function initCharts() {
    // Tenant Growth
    const tgData = await fetchChart('tenant-growth');
    new Chart(document.getElementById('tenantGrowthChart'), {
        type: 'line',
        data: {
            labels: tgData.labels,
            datasets: [{
                label: 'New Tenants',
                data: tgData.data,
                borderColor: '#2a6cb6',
                backgroundColor: 'rgba(42,108,182,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#2a6cb6'
            }]
        },
        options: chartDefaults
    });

    // Plan Distribution
    const pdData = await fetchChart('plan-distribution');
    new Chart(document.getElementById('planDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: pdData.labels,
            datasets: [{
                data: pdData.data,
                backgroundColor: ['#2a6cb6', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 15 } }
            }
        }
    });

    // MRR Trend
    const mrrData = await fetchChart('mrr-trend');
    new Chart(document.getElementById('mrrChart'), {
        type: 'bar',
        data: {
            labels: mrrData.labels,
            datasets: [{
                label: 'MRR (₹)',
                data: mrrData.data,
                backgroundColor: 'rgba(40,167,69,0.7)',
                borderColor: '#28a745',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: chartDefaults
    });

    // Revenue Growth
    const revData = await fetchChart('revenue-growth');
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revData.labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: revData.data,
                backgroundColor: 'rgba(42,108,182,0.7)',
                borderColor: '#2a6cb6',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: chartDefaults
    });

    // Trial Conversion
    const tcData = await fetchChart('trial-conversion');
    new Chart(document.getElementById('trialConversionChart'), {
        type: 'bar',
        data: {
            labels: tcData.labels,
            datasets: [
                { label: 'Trial Started', data: tcData.trial, backgroundColor: 'rgba(23,162,184,0.7)', borderRadius: 4 },
                { label: 'Converted', data: tcData.converted, backgroundColor: 'rgba(40,167,69,0.7)', borderRadius: 4 }
            ]
        },
        options: { ...chartDefaults, plugins: { legend: { display: true, position: 'top' } } }
    });

    // Churn
    const chData = await fetchChart('churn');
    new Chart(document.getElementById('churnChart'), {
        type: 'line',
        data: {
            labels: chData.labels,
            datasets: [{
                label: 'Cancellations',
                data: chData.data,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#dc3545'
            }]
        },
        options: chartDefaults
    });
}

document.addEventListener('DOMContentLoaded', initCharts);
</script>
@endpush
