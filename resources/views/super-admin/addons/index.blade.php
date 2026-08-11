@extends('super-admin.layouts.master')

@section('title', 'Add-ons')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Add-ons</h6>
        <a href="{{ route('super-admin.addons.create') }}" class="btn btn-sm btn-success">+ New Add-on</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Add-on</th>
                    <th>Price</th>
                    <th>Unlocks Feature</th>
                    <th>Tenants</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($addons as $addon)
                    <tr>
                        <td><strong>{{ $addon->name }}</strong><div class="small text-muted">{{ $addon->slug }}</div></td>
                        <td>${{ number_format($addon->price_monthly, 2) }}/mo</td>
                        <td><code>{{ $addon->feature ?? '—' }}</code></td>
                        <td>{{ $addon->tenants_count }}</td>
                        <td>
                            <span class="badge bg-{{ $addon->is_active ? 'success' : 'secondary' }}">{{ $addon->is_active ? 'active' : 'inactive' }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('super-admin.addons.edit', $addon) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('super-admin.addons.destroy', $addon) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this add-on?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No add-ons yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
