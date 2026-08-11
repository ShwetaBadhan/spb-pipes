@extends('super-admin.layouts.master')

@section('title', 'Create Tenant')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Create Tenant</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('super-admin.tenants.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                    <div class="form-text">Used for the subdomain: <code>slug.{{ config('saas.tenancy.central_domain') }}</code></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Plan</label>
                    <select name="plan_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" @if((string) old('plan_id') === (string) $plan->id) selected @endif>
                                {{ $plan->name }} — ${{ $plan->price_monthly }}/mo
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['trial', 'active', 'suspended'] as $s)
                            <option value="{{ $s }}" @if(old('status', 'trial') === $s) selected @endif>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Trial Length (days, if trial)</label>
                    <input type="number" name="trial_days" class="form-control" value="{{ old('trial_days') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create Tenant</button>
        </form>
    </div>
</div>
@endsection
