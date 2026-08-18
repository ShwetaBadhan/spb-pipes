@extends('central.layout')

@section('title', 'Manage Tenants')

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-4 mb-3">
        <h6 class="mb-0"><i class="isax isax-building me-1"></i> Tenants</h6>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#createTenantForm">
            <i class="isax isax-add-square me-1"></i> Add New Tenant
        </button>
    </div>

    {{-- Create Tenant Form --}}
    <div class="collapse mb-4" id="createTenantForm">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="isax isax-add-square me-1"></i> Create Tenant</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('central.tenants.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tenant Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tenant ID (slug)</label>
                            <input type="text" name="id" class="form-control" value="{{ old('id') }}" required placeholder="e.g. acme">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Subdomain</label>
                            <div class="input-group">
                                <input type="text" name="subdomain" class="form-control" value="{{ old('subdomain') }}" required placeholder="e.g. acme">
                                <span class="input-group-text">.{{ config('tenancy.central_domains')[0] }}</span>
                            </div>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12"><h6 class="fw-semibold mb-2">Tenant Admin</h6></div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Admin Name</label>
                            <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Admin Password</label>
                            <input type="password" name="admin_password" class="form-control" required minlength="8">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="admin_password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12"><h6 class="fw-semibold mb-2">Plan</h6></div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan</label>
                            <select name="plan_id" class="form-select" required>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}" @selected(old('plan_id', $defaultPlan?->id) == $plan->id)>
                                        {{ $plan->name }} @if (!$plan->isFree()) - {{ $plan->currency }} {{ number_format($plan->price) }} ({{ $plan->billing_period }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trial Days</label>
                            <input type="number" name="trial_days" class="form-control" min="0" max="365" value="{{ old('trial_days', $defaultPlan?->trial_days ?? 14) }}">
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#createTenantForm">Close</button>
                        <button type="submit" class="btn btn-primary">Create Tenant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fs-13">Search</label>
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

    {{-- Tenants Table --}}
    <div class="card">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="mb-0">All Tenants</h6>
            <span class="badge bg-primary-subtle text-primary">{{ $tenants->total() }} total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tenant</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Users</th>
                            <th>Last Activity</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td>
                                    <a href="{{ route('central.tenants.show', $tenant) }}" class="text-primary fw-medium">{{ $tenant->name }}</a>
                                    <br><small class="text-muted">{{ Str::limit($tenant->id, 12) }}</small>
                                </td>
                                <td>{{ $tenant->admin_name ?? '—' }}</td>
                                <td><small>{{ $tenant->admin_email ?? '—' }}</small></td>
                                <td>
                                    @if ($tenant->plan)
                                        <span class="badge badge-soft-primary">{{ $tenant->plan->name }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($tenant->is_suspended)
                                        <span class="badge badge-soft-warning">Suspended</span>
                                    @else
                                        @php $sc = match($tenant->subscription_status) { 'active' => 'success', 'trialing' => 'info', 'past_due' => 'danger', 'canceled' => 'danger', 'expired' => 'secondary', default => 'secondary' }; @endphp
                                        <span class="badge badge-soft-{{ $sc }}">{{ ucfirst($tenant->subscription_status ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td>{{ $tenant->users()->count() }}</td>
                                <td>
                                    @if($tenant->latestActivity)
                                        <small class="text-muted" title="{{ $tenant->latestActivity->description }}">{{ $tenant->latestActivity->created_at->diffForHumans() }}</small>
                                    @else
                                        <small class="text-muted">—</small>
                                    @endif
                                </td>
                                <td><small>{{ $tenant->created_at?->format('d M Y') }}</small></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('central.tenants.show', $tenant) }}" class="btn btn-sm btn-soft-primary" title="Details"><i class="isax isax-eye"></i></a>
                                    <a href="{{ route('central.tenants.login', $tenant) }}" class="btn btn-sm btn-soft-success" title="Login as Tenant"><i class="isax isax-login"></i></a>
                                    <a href="{{ route('central.tenants.edit', $tenant) }}" class="btn btn-sm btn-soft-info" title="Edit"><i class="isax isax-edit-2"></i></a>
                                    <form action="{{ route('central.tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tenant and all its data?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-soft-danger" title="Delete"><i class="isax isax-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No tenants found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($tenants->hasPages())
            <div class="card-footer bg-white">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
@endsection
