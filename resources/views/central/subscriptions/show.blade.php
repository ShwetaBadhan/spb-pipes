@extends('central.layout')

@section('title', 'Subscription Details')

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Subscription Details</h6>
            <small class="text-muted">
                Tenant:
                @if($tenant)
                    <a href="{{ route('central.tenants.show', $tenant) }}" class="text-primary">{{ $tenant->name }}</a>
                @else
                    Deleted tenant
                @endif
                · Plan: {{ $subscription->plan?->name ?? 'N/A' }}
            </small>
        </div>
        <a href="{{ route('central.subscriptions.index') }}" class="btn btn-sm btn-soft-secondary"><i class="isax isax-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row g-3">
        {{-- Subscription Info --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3"><h6 class="mb-0">Subscription</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Status</label>
                            @php $sc = match($subscription->status) { 'active' => 'success', 'trialing' => 'info', 'past_due' => 'danger', 'canceled' => 'danger', 'expired' => 'secondary', 'incomplete' => 'warning', default => 'secondary' }; @endphp
                            <p><span class="badge badge-soft-{{ $sc }} fs-14">{{ ucfirst($subscription->status) }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Billing Cycle</label>
                            <p class="mb-0">{{ ucfirst($subscription->plan?->billing_period ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Amount</label>
                            <p class="mb-0 fs-16 fw-bold">₹{{ number_format($subscription->amount(), 2) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Gateway</label>
                            <p class="mb-0">{{ ucfirst($subscription->gateway) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Starts</label>
                            <p class="mb-0">{{ $subscription->starts_at?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Ends / Renewal</label>
                            <p class="mb-0">{{ $subscription->ends_at?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Cancelled At</label>
                            <p class="mb-0">{{ $subscription->cancelled_at?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fs-13">Next Billing</label>
                            <p class="mb-0">{{ $subscription->next_billing_at?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted fs-13">Notes</label>
                            <p class="mb-0">{{ $subscription->notes ?: '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment History --}}
            <div class="card mt-3">
                <div class="card-header bg-white py-3"><h6 class="mb-0">Payment History</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr><th>Date</th><th>Amount</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($subscription->payments()->latest()->get() as $payment)
                                    <tr>
                                        <td><small>{{ $payment->paid_at?->format('d M Y H:i') ?? $payment->created_at->format('d M Y') }}</small></td>
                                        <td>₹{{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @php $pc = match($payment->status) { 'paid' => 'success', 'failed' => 'danger', 'refunded' => 'warning', default => 'secondary' }; @endphp
                                            <span class="badge badge-soft-{{ $pc }}">{{ ucfirst($payment->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-3">No payments.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Actions --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white py-3"><h6 class="mb-0">Admin Actions</h6></div>
                <div class="card-body">

                    {{-- Upgrade --}}
                    @if($subscription->status !== 'canceled' && $subscription->status !== 'expired')
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold">Upgrade Plan</label>
                        <form action="{{ route('central.subscriptions.upgrade', $subscription) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="input-group input-group-sm">
                                <select name="plan_id" class="form-select" required>
                                    @foreach (\App\Models\Plan::active()->where('price', '>', $subscription->plan?->price ?? 0)->get() as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }} — ₹{{ number_format($plan->price) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Upgrade this subscription?')">Upgrade</button>
                            </div>
                        </form>
                    </div>

                    {{-- Downgrade --}}
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold">Downgrade Plan</label>
                        <form action="{{ route('central.subscriptions.downgrade', $subscription) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="input-group input-group-sm">
                                <select name="plan_id" class="form-select" required>
                                    @foreach (\App\Models\Plan::active()->where('price', '<', $subscription->plan?->price ?? 0)->get() as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }} — ₹{{ number_format($plan->price) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Downgrade this subscription?')">Downgrade</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    {{-- Extend --}}
                    @if(in_array($subscription->status, ['active', 'trialing', 'past_due']))
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold">Extend Subscription</label>
                        <form action="{{ route('central.subscriptions.extend', $subscription) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="input-group input-group-sm">
                                <input type="number" name="days" class="form-control" value="30" min="1" max="365">
                                <span class="input-group-text">days</span>
                                <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Extend subscription?')">Apply</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    {{-- Cancel / Resume --}}
                    @if($subscription->status === 'canceled')
                        <form action="{{ route('central.subscriptions.resume', $subscription) }}" method="POST" class="mb-3">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success w-100" onclick="return confirm('Resume this subscription?')">
                                <i class="isax isax-play-circle me-1"></i> Resume Subscription
                            </button>
                        </form>
                    @elseif(in_array($subscription->status, ['active', 'trialing', 'past_due']))
                        <form action="{{ route('central.subscriptions.cancel', $subscription) }}" method="POST" class="mb-3">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Cancel this subscription? This can be resumed later.')">
                                <i class="isax isax-close-circle me-1"></i> Cancel Subscription
                            </button>
                        </form>
                    @endif

                    {{-- Change Renewal Date --}}
                    @if(in_array($subscription->status, ['active', 'past_due']))
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold">Change Renewal Date</label>
                        <form action="{{ route('central.subscriptions.renewal-date', $subscription) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="input-group input-group-sm">
                                <input type="date" name="ends_at" class="form-control" value="{{ $subscription->ends_at?->format('Y-m-d') }}" required>
                                <button type="submit" class="btn btn-outline-primary">Set</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    {{-- Notes --}}
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold">Notes</label>
                        <form action="{{ route('central.subscriptions.notes', $subscription) }}" method="POST">
                            @csrf @method('PATCH')
                            <textarea name="notes" class="form-control form-control-sm mb-2" rows="3" placeholder="Internal notes about this subscription...">{{ $subscription->notes }}</textarea>
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Save Notes</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
