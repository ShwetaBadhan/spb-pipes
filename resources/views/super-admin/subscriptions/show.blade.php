@extends('super-admin.layouts.master')

@section('title', 'Subscription')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Subscription #{{ $subscription->id }}</h4>
    <a href="{{ route('super-admin.subscriptions.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Tenant</dt>
            <dd class="col-sm-9">
                <a href="{{ route('super-admin.tenants.show', $subscription->tenant) }}">{{ $subscription->tenant?->name }}</a>
            </dd>
            <dt class="col-sm-3">Plan</dt>
            <dd class="col-sm-9">{{ $subscription->plan?->name ?? '—' }} (${{ $subscription->plan?->price_monthly ?? 0 }}/mo)</dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9"><span class="badge bg-info">{{ $subscription->status }}</span></dd>
            <dt class="col-sm-3">Stripe Status</dt>
            <dd class="col-sm-9">{{ $subscription->stripe_status ?? '—' }}</dd>
            <dt class="col-sm-3">Stripe ID</dt>
            <dd class="col-sm-9"><code>{{ $subscription->stripe_id ?? '—' }}</code></dd>
            <dt class="col-sm-3">Stripe Price</dt>
            <dd class="col-sm-9"><code>{{ $subscription->stripe_price ?? '—' }}</code></dd>
            <dt class="col-sm-3">Quantity</dt>
            <dd class="col-sm-9">{{ $subscription->quantity ?? '—' }}</dd>
            <dt class="col-sm-3">Trial Ends</dt>
            <dd class="col-sm-9">{{ $subscription->trial_ends_at?->format('M d, Y H:i') ?? '—' }}</dd>
            <dt class="col-sm-3">Ends</dt>
            <dd class="col-sm-9">{{ $subscription->ends_at?->format('M d, Y H:i') ?? '—' }}</dd>
            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ $subscription->created_at?->format('M d, Y H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection
