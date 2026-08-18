@extends('central.layout')

@section('title', $tenant->name . ' - Tenant Details')

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">{{ $tenant->name }}</h6>
            <small class="text-muted">Tenant ID: <code>{{ $tenant->id }}</code></small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('central.tenants.login', $tenant) }}" class="btn btn-sm btn-success"><i class="isax isax-login me-1"></i> Impersonate</a>
            <a href="{{ route('central.tenants.edit', $tenant) }}" class="btn btn-sm btn-primary"><i class="isax isax-edit-2 me-1"></i> Edit</a>
            <a href="{{ route('central.tenants.index') }}" class="btn btn-sm btn-soft-secondary"><i class="isax isax-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    {{-- Quick Status Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center flex-wrap gap-3">
                @if ($tenant->is_suspended)
                    <span class="badge bg-warning text-dark"><i class="isax isax-warning-2 me-1"></i> Suspended</span>
                @endif
                @php $sc = match($tenant->subscription_status) { 'active' => 'success', 'trialing' => 'info', 'past_due' => 'danger', 'canceled' => 'danger', 'expired' => 'secondary', default => 'secondary' }; @endphp
                <span class="badge badge-soft-{{ $sc }}">{{ ucfirst($tenant->subscription_status ?? 'N/A') }}</span>
                @if($tenant->plan)
                    <span class="badge badge-soft-primary">{{ $tenant->plan->name }}</span>
                @endif
                @if($tenant->trial_ends_at)
                    <small class="text-muted">Trial ends: {{ $tenant->trial_ends_at->format('d M Y') }}</small>
                @endif
                @if($tenant->subscription_ends_at)
                    <small class="text-muted">Renewal: {{ $tenant->subscription_ends_at->format('d M Y') }}</small>
                @endif
                <small class="text-muted ms-auto">Created: {{ $tenant->created_at?->format('d M Y H:i') }}</small>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="tenantTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-overview">Overview</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-users">Users ({{ $users->count() }})</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-subscription">Subscription</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-billing">Billing</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-domains">Domains</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-usage">Usage</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-activity">Activity Logs</a></li>
    </ul>

    <div class="tab-content">
        {{-- Overview --}}
        <div class="tab-pane fade show active" id="tab-overview">
            @include('central.tenants.tabs._overview')
        </div>

        {{-- Users --}}
        <div class="tab-pane fade" id="tab-users">
            @include('central.tenants.tabs._users')
        </div>

        {{-- Subscription --}}
        <div class="tab-pane fade" id="tab-subscription">
            @include('central.tenants.tabs._subscription')
        </div>

        {{-- Billing --}}
        <div class="tab-pane fade" id="tab-billing">
            @include('central.tenants.tabs._billing')
        </div>

        {{-- Domains --}}
        <div class="tab-pane fade" id="tab-domains">
            @include('central.tenants.tabs._domains')
        </div>

        {{-- Usage --}}
        <div class="tab-pane fade" id="tab-usage">
            @include('central.tenants.tabs._usage')
        </div>

        {{-- Activity Logs --}}
        <div class="tab-pane fade" id="tab-activity">
            @include('central.tenants.tabs._activity')
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0">Quick Actions</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('central.tenants.extend-trial', $tenant) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <div class="input-group input-group-sm" style="width: 260px;">
                        <span class="input-group-text">Extend Trial</span>
                        <input type="number" name="days" class="form-control" value="7" min="1" max="365">
                        <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Extend trial by this many days?')">Apply</button>
                    </div>
                </form>

                <form action="{{ route('central.tenants.reset-trial', $tenant) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Reset the trial period? This will restart the trial.')">Reset Trial</button>
                </form>

                <form action="{{ route('central.tenants.force-logout', $tenant) }}" method="POST" class="d-inline">
                    @csrf @method('POST')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Force logout all users of this tenant?')">Force Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection
