@extends('central.layout')

@section('title', 'Central Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Central Admin Dashboard</h6>
            <p class="text-muted fs-14 mb-0">Manage all tenants, settings and platform admins from here.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <a href="{{ route('central.tenants.index') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="isax isax-add-square me-1"></i> Create Tenant
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                            <i class="isax isax-building fs-20"></i>
                        </span>
                        <div>
                            <p class="mb-1 text-truncate">Total Tenants</p>
                            <h6 class="fs-16 fw-semibold mb-0">{{ number_format($stats['tenants']) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                            <i class="isax isax-global fs-20"></i>
                        </span>
                        <div>
                            <p class="mb-1 text-truncate">Total Domains</p>
                            <h6 class="fs-16 fw-semibold mb-0">{{ number_format($stats['domains']) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                            <i class="isax isax-profile-2user fs-20"></i>
                        </span>
                        <div>
                            <p class="mb-1 text-truncate">Tenant Users</p>
                            <h6 class="fs-16 fw-semibold mb-0">{{ number_format($stats['tenant_users']) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                            <i class="isax isax-user-tag fs-20"></i>
                        </span>
                        <div>
                            <p class="mb-1 text-truncate">Admin Users</p>
                            <h6 class="fs-16 fw-semibold mb-0">{{ number_format($stats['admins']) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tenants -->
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h6 class="mb-0">Recent Tenants</h6>
            <a href="{{ route('central.tenants.index') }}" class="fs-14 text-primary">View All</a>
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
                        @forelse ($tenants->take(8) as $tenant)
                            <tr>
                                <td><code>{{ $tenant->id }}</code></td>
                                <td>{{ $tenant->name }}</td>
                                <td>
                                    @forelse ($tenant->domains as $domain)
                                        <a href="http://{{ $domain->domain }}:8000" target="_blank" class="text-primary">{{ $domain->domain }}</a>
                                    @empty
                                        <span class="text-muted">—</span>
                                    @endforelse
                                </td>
                                <td>{{ $tenant->created_at?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('central.tenants.index') }}" class="btn btn-sm btn-soft-primary">Manage</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No tenants yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
