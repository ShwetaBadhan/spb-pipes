@extends('super-admin.layouts.master')

@section('title', 'Billing')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="label">Collected</div>
            <div class="value text-success">${{ number_format($totals['collected'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="label">Pending</div>
            <div class="value text-warning">${{ number_format($totals['pending'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="label">Payments</div>
            <div class="value">{{ $totals['payments'] }}</div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach(['paid', 'pending', 'failed', 'refunded'] as $s)
                    <option value="{{ $s }}" @if(request('status') === $s) selected @endif>{{ $s }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Stripe Invoice</th>
                    <th>Tenant</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Invoiced</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td><code class="small">{{ $invoice->stripe_invoice_id ?? '#' . $invoice->id }}</code></td>
                        <td>{{ $invoice->tenant?->name }}</td>
                        <td>${{ number_format($invoice->amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'failed' ? 'danger' : 'warning') }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td>{{ $invoice->invoice_date?->format('M d, Y') ?? '—' }}</td>
                        <td>{{ $invoice->due_date?->format('M d, Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
        <div class="card-footer">{{ $invoices->links() }}</div>
    @endif
</div>
@endsection
