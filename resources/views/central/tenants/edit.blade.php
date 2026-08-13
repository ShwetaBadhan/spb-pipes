@extends('central.layout')

@section('title', 'Edit Tenant')

@section('content')
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Edit Tenant</h6>
            <p class="text-muted fs-14 mb-0">{{ $tenant->id }} · {{ $tenant->name }}</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 fs-14">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Current Subscription</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted fs-14 mb-1">Plan</div>
                        <div class="fw-semibold">
                            @if ($tenant->plan)
                                {{ $tenant->plan->name }}
                                @if (!$tenant->plan->isFree())
                                    · {{ $tenant->plan->currency }} {{ number_format($tenant->plan->price) }}/{{ $tenant->plan->billing_period }}
                                @endif
                            @else
                                <span class="text-muted">No plan</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted fs-14 mb-1">Status</div>
                        <span class="badge bg-{{ in_array($tenant->subscription_status, ['trialing', 'active']) ? 'success' : 'danger' }}-subtle text-{{ in_array($tenant->subscription_status, ['trialing', 'active']) ? 'success' : 'danger' }}">
                            {{ $tenant->subscription_status ? ucfirst($tenant->subscription_status) : '—' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted fs-14 mb-1">Trial Ends</div>
                        <div>{{ $tenant->trial_ends_at?->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted fs-14 mb-1">Subscription Ends</div>
                        <div>{{ $tenant->subscription_ends_at?->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="text-muted fs-14 mb-1">Domains</div>
                        @forelse ($tenant->domains as $domain)
                            <a href="http://{{ $domain->domain }}:8000" target="_blank" class="d-block text-primary">{{ $domain->domain }} <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Change Plan / Subscription</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('central.tenants.update', $tenant) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="plan_id" class="form-label">Plan</label>
                                <select name="plan_id" id="plan_id" class="form-select" required>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" @selected(old('plan_id', $tenant->plan_id) == $plan->id)>
                                            {{ $plan->name }} @if (!$plan->isFree()) · {{ $plan->currency }} {{ number_format($plan->price) }} ({{ $plan->billing_period }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ends_at" class="form-label">Subscription Ends At</label>
                                <input type="date" name="ends_at" id="ends_at" class="form-control" value="{{ old('ends_at', $tenant->subscription_ends_at?->format('Y-m-d')) }}">
                            </div>

                            <div class="col-12">
                                <h6 class="fw-semibold mt-2 mb-2">Per-Tenant Limit Overrides <span class="text-muted small fw-normal">(leave blank to use the plan defaults, -1 = unlimited)</span></h6>
                                <div class="row g-2">
                                    @php
                                        $effectiveOverrides = $tenant->activeSubscription ? ($tenant->activeSubscription->meta['limit_overrides'] ?? []) : [];
                                    @endphp
                                    @foreach (\App\Models\Plan::LIMIT_KEYS as $key)
                                        <div class="col-md-4">
                                            <label for="limit_{{ $key }}" class="form-label text-capitalize small">{{ str_replace('_', ' ', $key) }}</label>
                                            <input type="number" name="limit_overrides[{{ $key }}]" id="limit_{{ $key }}"
                                                class="form-control" min="-1" placeholder="Plan default"
                                                value="{{ old("limit_overrides.$key", $effectiveOverrides[$key] ?? '') }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 d-flex align-items-center gap-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="suspend" id="suspend" value="1" class="form-check-input"
                                        @checked(in_array($tenant->subscription_status, ['canceled', 'expired', 'past_due']))>
                                    <label for="suspend" class="form-check-label">Suspend subscription (blocks creates)</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('central.tenants.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
