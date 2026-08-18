<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Subscription History</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Starts</th>
                        <th>Ends</th>
                        <th>Cancelled</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allSubscriptions as $sub)
                        <tr>
                            <td><span class="badge badge-soft-primary">{{ $sub->plan?->name ?? '—' }}</span></td>
                            <td><span class="badge badge-soft-{{ $sub->statusColor() }}">{{ ucfirst($sub->status) }}</span></td>
                            <td>{{ $sub->starts_at?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $sub->ends_at?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $sub->cancelled_at?->format('d M Y') ?? '—' }}</td>
                            <td><small>{{ ucfirst($sub->gateway) }}</small></td>
                            <td>₹{{ number_format($sub->amount(), 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No subscriptions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
