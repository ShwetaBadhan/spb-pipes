@extends('central.layout')

@section('title', 'Subscriptions')

@section('content')
    <h6 class="mb-3"><i class="isax isax-cube5 me-1"></i> Subscriptions</h6>

    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fs-13">Search Tenant</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Name, email, ID..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fs-13">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="trialing" @selected(request('status') === 'trialing')>Trialing</option>
                        <option value="past_due" @selected(request('status') === 'past_due')>Past Due</option>
                        <option value="canceled" @selected(request('status') === 'canceled')>Canceled</option>
                        <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                        <option value="incomplete" @selected(request('status') === 'incomplete')>Incomplete</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fs-13">Plan</label>
                    <select name="plan_id" class="form-select form-select-sm">
                        <option value="">All Plans</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id)>{{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="mb-0">All Subscriptions</h6>
            <span class="badge bg-primary-subtle text-primary">{{ $subscriptions->total() }} total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tenant</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Billing</th>
                            <th>Amount</th>
                            <th>Starts</th>
                            <th>Ends</th>
                            <th>Gateway</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $sub)
                            @php $tenant = $sub->tenant; @endphp
                            <tr>
                                <td>
                                    @if($tenant)
                                        <a href="{{ route('central.tenants.show', $tenant) }}" class="text-primary fw-medium">{{ $tenant->name }}</a>
                                        <br><small class="text-muted">{{ $tenant->id }}</small>
                                    @else
                                        <span class="text-muted">Deleted tenant</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-soft-primary">{{ $sub->plan?->name ?? '—' }}</span></td>
                                <td>
                                    @php $sc = match($sub->status) { 'active' => 'success', 'trialing' => 'info', 'past_due' => 'danger', 'canceled' => 'danger', 'expired' => 'secondary', 'incomplete' => 'warning', default => 'secondary' }; @endphp
                                    <span class="badge badge-soft-{{ $sc }}">{{ ucfirst($sub->status) }}</span>
                                </td>
                                <td><small>{{ ucfirst($sub->plan?->billing_period ?? '—') }}</small></td>
                                <td>₹{{ number_format($sub->amount(), 2) }}</td>
                                <td><small>{{ $sub->starts_at?->format('d M Y') ?? '—' }}</small></td>
                                <td><small>{{ $sub->ends_at?->format('d M Y') ?? '—' }}</small></td>
                                <td><small>{{ ucfirst($sub->gateway) }}</small></td>
                                <td class="text-end">
                                    <a href="{{ route('central.subscriptions.show', $sub) }}" class="btn btn-sm btn-soft-primary" title="View Details">
                                        <i class="isax isax-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No subscriptions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($subscriptions->hasPages())
            <div class="card-footer bg-white">
                {{ $subscriptions->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
