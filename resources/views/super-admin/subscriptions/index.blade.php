@extends('super-admin.layouts.master')

@section('title', 'Subscriptions')

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach(['trial', 'active', 'past_due', 'canceled', 'expired'] as $s)
                    <option value="{{ $s }}" @if(request('status') === $s) selected @endif>{{ $s }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Stripe Status</th>
                    <th>Stripe ID</th>
                    <th>Ends</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->tenant?->name }}</td>
                        <td>{{ $subscription->plan?->name ?? '—' }}</td>
                        <td><span class="badge bg-info">{{ $subscription->status }}</span></td>
                        <td>{{ $subscription->stripe_status ?? '—' }}</td>
                        <td><code class="small">{{ $subscription->stripe_id ?? '—' }}</code></td>
                        <td>{{ $subscription->ends_at?->format('M d, Y') ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('super-admin.subscriptions.show', $subscription) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No subscriptions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subscriptions->hasPages())
        <div class="card-footer">{{ $subscriptions->links() }}</div>
    @endif
</div>
@endsection
