@extends('super-admin.layouts.master')

@section('title', 'Edit ' . $tenant->name)

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Edit Tenant</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('super-admin.tenants.update', $tenant) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $tenant->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $tenant->slug) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $tenant->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $tenant->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['trial', 'active', 'suspended', 'canceled'] as $s)
                            <option value="{{ $s }}" @if(old('status', $tenant->status) === $s) selected @endif>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Save</button>
            <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="btn btn-secondary mt-4">Cancel</a>
        </form>
    </div>
</div>
@endsection
