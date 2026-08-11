@extends('super-admin.layouts.master')

@section('title', 'Tenants')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0">All Tenants</h6>
        <div class="d-flex gap-2 align-items-center">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search name / slug / email">
                <select name="status" class="form-select form-select-sm" style="width:auto;">
                    <option value="">All statuses</option>
                    @foreach(['trial', 'active', 'suspended', 'canceled'] as $s)
                        <option value="{{ $s }}" @if(request('status') === $s) selected @endif>{{ $s }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
            </form>
            <a href="{{ route('super-admin.tenants.create') }}" class="btn btn-sm btn-success">+ New Tenant</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Slug</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Trial ends</th>
                    <th>Users</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->name }}</td>
                        <td><code>{{ $tenant->slug }}</code></td>
                        <td>{{ $tenant->email ?? '—' }}</td>
                        <td>{{ $tenant->plan?->name ?? ($tenant->plan_slug ?? '—') }}</td>
                        <td>
                            @if($tenant->status === 'active')
                                <span class="badge bg-success">active</span>
                            @elseif($tenant->status === 'trial')
                                <span class="badge bg-primary">trial</span>
                            @elseif($tenant->status === 'suspended')
                                <span class="badge bg-danger">suspended</span>
                            @else
                                <span class="badge bg-secondary">{{ $tenant->status }}</span>
                            @endif
                        </td>
                        <td>{{ $tenant->trial_ends_at?->format('M d, Y') ?? '—' }}</td>
                        <td>{{ $tenant->users_count ?? '' }}</td>
                        <td class="text-end">
                            <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No tenants found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tenants->hasPages())
        <div class="card-footer">
            {{ $tenants->links() }}
        </div>
    @endif
</div>
@endsection
