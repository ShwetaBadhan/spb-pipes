@extends('super-admin.layouts.master')

@section('title', 'Domains - ' . $tenant->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Domains for {{ $tenant->name }}</h4>
    <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="btn btn-sm btn-outline-secondary">Back to Tenant</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Register Domain</h6></div>
    <div class="card-body">
        <form method="POST" action="{{ route('super-admin.tenants.domains.store', $tenant) }}" class="d-flex gap-2">
            @csrf
            <input type="text" name="domain" class="form-control" placeholder="acme.example.com" required>
            <select name="type" class="form-select" style="width:auto;">
                <option value="custom">Custom</option>
                <option value="subdomain">Subdomain</option>
            </select>
            <button class="btn btn-primary">Register</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h6 class="mb-0">Registered Domains</h6></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Verified</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($domains as $domain)
                    <tr>
                        <td><code>{{ $domain->domain }}</code></td>
                        <td>{{ $domain->type }}</td>
                        <td>
                            <span class="badge bg-{{ $domain->status === 'active' ? 'success' : ($domain->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ $domain->status }}
                            </span>
                        </td>
                        <td>{{ $domain->verified_at?->format('M d, Y') ?? '-' }}</td>
                        <td>
                            @if ($domain->status !== 'active')
                                <form method="POST" action="{{ route('super-admin.tenants.domains.verify', [$tenant, $domain]) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Verify</button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.tenants.domains.verify', [$tenant, $domain]) }}?force=1" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success">Verify (force)</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('super-admin.tenants.domains.destroy', [$tenant, $domain]) }}" class="d-inline"
                                onsubmit="return confirm('Remove {{ $domain->domain }}?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">No domains registered.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($domains->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header"><h6 class="mb-0">DNS Verification</h6></div>
        <div class="card-body">
            <p class="text-muted mb-2">Add one of the following DNS records for your domain to verify ownership:</p>
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr><th>Type</th><th>Name</th><th>Value</th></tr>
                </thead>
                <tbody>
                    @foreach ($domains->where('status', '!=', 'active') as $domain)
                        <tr>
                            <td>TXT</td>
                            <td><code>_spb-pipes.{{ $domain->domain }}</code></td>
                            <td><code>{{ substr(hash('sha256', $domain->tenant_id.'|'.$domain->domain.'|'.config('app.key')), 0, 32) }}</code></td>
                        </tr>
                        <tr>
                            <td>CNAME</td>
                            <td><code>{{ $domain->domain }}</code></td>
                            <td><code>{{ config('saas.tenancy.central_domain', 'spb-pipes.com') }}</code></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
