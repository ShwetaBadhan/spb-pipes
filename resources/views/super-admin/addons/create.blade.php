@extends('super-admin.layouts.master')

@section('title', 'Create Add-on')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">Create Add-on</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('super-admin.addons.store') }}">
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
                <div class="col-md-6">
                    <label class="form-label">Price (monthly)</label>
                    <input type="number" step="0.01" min="0" name="price_monthly" class="form-control" value="{{ old('price_monthly') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unlocks Feature</label>
                    <select name="feature" class="form-select">
                        <option value="">— None —</option>
                        @foreach($features as $key => $feature)
                            <option value="{{ $key }}" @if(old('feature') === $key) selected @endif>{{ $feature['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create Add-on</button>
        </form>
    </div>
</div>
@endsection
