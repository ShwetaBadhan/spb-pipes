@extends('central.layout')

@section('title', 'Manage Tenants')

@section('content')
    <!-- Page Header -->
    {{-- <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Manage Tenants</h6>
            <p class="text-muted fs-14 mb-0">Create new tenants with their own database and subdomain, or delete existing ones.</p>
        </div>
    </div> --}}

    <div class="row g-3">
        <div class="col-xl-12">
            <div class="d-flex align-items-center justify-content-between gap-4 mb-3">
                <h6 class="mb-0"><i class="isax isax-building me-1"></i> Tenant</h6>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Add New Tenant
                </button>
            </div>
            <div class="collapse" id="collapseExample">
               <div class="card">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="isax isax-add-square me-1"></i> Create Tenant</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('central.tenants.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Tenant Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="id" class="form-label">Tenant ID (slug)</label>
                                    <input type="text" name="id" id="id" class="form-control" value="{{ old('id') }}" required placeholder="e.g. acme">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="subdomain" class="form-label">Subdomain</label>
                                    <div class="input-group">
                                        <input type="text" name="subdomain" id="subdomain" class="form-control" value="{{ old('subdomain') }}" required placeholder="e.g. acme">
                                        <span class="input-group-text p-1">.localhost</span>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="fw-semibold mb-2">Tenant Admin</h6>

                                <div class="col-md-3 mb-3">
                                    <label for="admin_name" class="form-label">Admin Name</label>
                                    <input type="text" name="admin_name" id="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="admin_email" class="form-label">Admin Email</label>
                                    <input type="email" name="admin_email" id="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="admin_password" class="form-label">Admin Password</label>
                                    <input type="password" name="admin_password" id="admin_password" class="form-control" required minlength="8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="admin_password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Close</button>
                                <button type="submit" class="btn btn-primary ">Create Tenant</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="isax isax-building me-1"></i> Tenants</h6>
                    <span class="badge bg-primary-subtle text-primary">{{ $tenants->count() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Domain</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $tenant)
                                    <tr>
                                        <td><code>{{ $tenant->id }}</code></td>
                                        <td>{{ $tenant->name }}</td>
                                        <td>
                                            @forelse ($tenant->domains as $domain)
                                                <a href="http://{{ $domain->domain }}:8000" target="_blank" class="text-primary">{{ $domain->domain }} <i class="fa-solid fa-arrow-up-right-from-square"></i></a> 
                                            @empty
                                                <span class="text-muted">—</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $tenant->created_at?->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('central.tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tenant and its domains?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-soft-danger"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">No tenants yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
