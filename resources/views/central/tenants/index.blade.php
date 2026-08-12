@extends('central.layout')

@section('title', 'Manage Tenants')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Create Tenant</h5></div>
                <div class="card-body">
                    <form action="{{ route('central.tenants.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tenant Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">Tenant ID (slug)</label>
                            <input type="text" name="id" id="id" class="form-control" value="{{ old('id') }}" required placeholder="e.g. acme">
                        </div>
                        <div class="mb-3">
                            <label for="subdomain" class="form-label">Subdomain</label>
                            <div class="input-group">
                                <input type="text" name="subdomain" id="subdomain" class="form-control" value="{{ old('subdomain') }}" required placeholder="e.g. acme">
                                <span class="input-group-text">.localhost</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create Tenant</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Tenants</h5></div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Domain</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tenants as $tenant)
                                <tr>
                                    <td><code>{{ $tenant->id }}</code></td>
                                    <td>{{ data_get($tenant->data, 'name') }}</td>
                                    <td>
                                        @forelse ($tenant->domains as $domain)
                                            <a href="http://{{ $domain->domain }}:8000" target="_blank">{{ $domain->domain }}</a>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('central.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Delete this tenant and its domains?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No tenants yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
