@extends('super-admin.layouts.master')

@section('title', 'Plans')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Plans</h6>
        <a href="{{ route('super-admin.plans.create') }}" class="btn btn-sm btn-success">+ New Plan</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Users</th>
                    <th>Products</th>
                    <th>Invoices/mo</th>
                    <th>Tenants</th>
                    <th>Stripe ID</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td><strong>{{ $plan->name }}</strong><div class="small text-muted">{{ $plan->slug }}</div></td>
                        <td>${{ number_format($plan->price_monthly, 2) }}/mo</td>
                        <td>{{ $plan->max_users ?? '∞' }}</td>
                        <td>{{ $plan->max_products ?? '∞' }}</td>
                        <td>{{ $plan->max_invoices_per_month ?? '∞' }}</td>
                        <td>{{ $plan->tenants_count }}</td>
                        <td><code class="small">{{ $plan->stripe_price_id ?? '—' }}</code></td>
                        <td>
                            <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">{{ $plan->is_active ? 'active' : 'inactive' }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('super-admin.plans.edit', $plan) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('super-admin.plans.destroy', $plan) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this plan?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No plans yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
