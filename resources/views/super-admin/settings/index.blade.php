@extends('super-admin.layouts.master')

@section('title', 'Settings')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">SaaS Settings</h6></div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Central Domain</dt>
            <dd class="col-sm-9"><code>{{ $tenancy['central_domain'] }}</code></dd>
            <dt class="col-sm-3">Tenancy Driver</dt>
            <dd class="col-sm-9">{{ $tenancy['driver'] }}</dd>
            <dt class="col-sm-3">Tenancy Enabled</dt>
            <dd class="col-sm-9">{{ $tenancy['enabled'] ? 'Yes' : 'No' }}</dd>
            <dt class="col-sm-3">Default Trial (days)</dt>
            <dd class="col-sm-9">{{ $tenancy['trial_days'] }}</dd>
            <dt class="col-sm-3">Stripe Mode</dt>
            <dd class="col-sm-9">
                {{ config('services.stripe.secret') && str_starts_with(config('services.stripe.secret'), 'sk_test') ? 'Test' : 'Live' }}
            </dd>
        </dl>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><h6 class="mb-0">Maintenance Mode</h6></div>
    <div class="card-body">
        @if(app()->isDownForMaintenance())
            <p class="text-danger mb-2">Maintenance mode is currently <strong>enabled</strong>. The entire application is offline for users.</p>
            <form method="POST" action="{{ route('super-admin.settings.maintenance') }}">
                @csrf
                <button class="btn btn-success">Disable Maintenance Mode</button>
            </form>
        @else
            <p class="text-muted mb-2">The application is running normally.</p>
            <form method="POST" action="{{ route('super-admin.settings.maintenance') }}">
                @csrf
                <button class="btn btn-warning">Enable Maintenance Mode</button>
            </form>
        @endif
    </div>
</div>
@endsection
