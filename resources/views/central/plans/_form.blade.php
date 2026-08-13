@php
    $limits = $plan->limits ?? [];
    $route = isset($plan->id) ? route('central.plans.update', $plan) : route('central.plans.store');
@endphp

<form action="{{ $route }}" method="POST">
    @csrf
    @if (isset($plan->id))
        @method('PUT')
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Plan Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $plan->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $plan->slug ?? '') }}" required>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="2" class="form-control">{{ old('description', $plan->description ?? '') }}</textarea>
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" min="0" name="price" id="price" class="form-control" value="{{ old('price', $plan->price ?? 0) }}" required>
                </div>
                <div class="col-md-3">
                    <label for="currency" class="form-label">Currency</label>
                    <input type="text" name="currency" id="currency" maxlength="3" class="form-control" value="{{ old('currency', $plan->currency ?? 'INR') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="billing_period" class="form-label">Billing Period</label>
                    <select name="billing_period" id="billing_period" class="form-select">
                        <option value="monthly" @selected(old('billing_period', $plan->billing_period ?? 'monthly') === 'monthly')>Monthly</option>
                        <option value="yearly" @selected(old('billing_period', $plan->billing_period ?? 'monthly') === 'yearly')>Yearly</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="trial_days" class="form-label">Trial Days</label>
                    <input type="number" min="0" max="365" name="trial_days" id="trial_days" class="form-control" value="{{ old('trial_days', $plan->trial_days ?? 14) }}" required>
                </div>
                <div class="col-md-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" min="0" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order ?? 0) }}">
                </div>
            </div>

            <hr>

            <h6 class="fw-semibold mb-3">Usage Limits <span class="text-muted small fw-normal">(-1 = unlimited)</span></h6>

            <div class="row g-3">
                @foreach ($limitKeys as $key)
                    <div class="col-md-4">
                        <label for="limits_{{ $key }}" class="form-label text-capitalize">{{ str_replace('_', ' ', $key) }}</label>
                        <input type="number" name="limits[{{ $key }}]" id="limits_{{ $key }}" class="form-control"
                            value="{{ old("limits.$key", $limits[$key] ?? 0) }}" min="-1">
                    </div>
                @endforeach
            </div>

            <div class="d-flex gap-4 mt-4">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" @checked(old('is_active', $plan->is_active ?? true))>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_default" id="is_default" value="1" class="form-check-input" @checked(old('is_default', $plan->is_default ?? false))>
                    <label for="is_default" class="form-check-label">Default plan</label>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white text-end">
            <a href="{{ route('central.plans.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Plan</button>
        </div>
    </div>
</form>
