@php $totalPaid = $allPayments->where('status', 'paid')->sum('amount'); @endphp

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="fw-bold text-success mb-0">₹{{ number_format($totalPaid, 2) }}</h5>
                <small class="text-muted">Total Paid</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="fw-bold mb-0">{{ $allPayments->where('status', 'paid')->count() }}</h5>
                <small class="text-muted">Successful Payments</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="fw-bold text-danger mb-0">{{ $allPayments->where('status', 'failed')->count() }}</h5>
                <small class="text-muted">Failed Payments</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Payment History</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Plan</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allPayments as $payment)
                        <tr>
                            <td>{{ $payment->paid_at?->format('d M Y H:i') ?? $payment->created_at->format('d M Y') }}</td>
                            <td>{{ $payment->subscription?->plan?->name ?? '—' }}</td>
                            <td><small>{{ ucfirst($payment->gateway) }}</small></td>
                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                @php $pc = match($payment->status) { 'paid' => 'success', 'failed' => 'danger', 'refunded' => 'warning', default => 'secondary' }; @endphp
                                <span class="badge badge-soft-{{ $pc }}">{{ ucfirst($payment->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
