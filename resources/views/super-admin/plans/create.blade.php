@extends('super-admin.layouts.master')

@section('title', 'Create Plan')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Create Plan</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('super-admin.plans.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price (monthly)</label>
                    <input type="number" step="0.01" min="0" name="price_monthly" class="form-control" value="{{ old('price_monthly') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trial (days)</label>
                    <input type="number" name="trial_days" class="form-control" value="{{ old('trial_days', 14) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stripe Price ID</label>
                    <input type="text" name="stripe_price_id" class="form-control" value="{{ old('stripe_price_id') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Users</label>
                    <input type="number" name="max_users" class="form-control" value="{{ old('max_users') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Products</label>
                    <input type="number" name="max_products" class="form-control" value="{{ old('max_products') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Invoices/mo</label>
                    <input type="number" name="max_invoices_per_month" class="form-control" value="{{ old('max_invoices_per_month') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Storage (MB)</label>
                    <input type="number" name="max_storage_mb" class="form-control" value="{{ old('max_storage_mb') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label d-block">Features</label>
                    <div class="row">
                        @foreach($features as $key => $feature)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="{{ $key }}"
                                           id="feat-{{ $key }}" @if(in_array($key, old('features', []), true)) checked @endif>
                                    <label class="form-check-label" for="feat-{{ $key }}">{{ $feature['label'] }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create Plan</button>
        </form>
    </div>
</div>
@endsection
