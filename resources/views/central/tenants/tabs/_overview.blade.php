<div class="row g-3">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header bg-white py-3"><h6 class="mb-0">Tenant Information</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Tenant ID</label>
                        <p class="fw-medium mb-0"><code>{{ $tenant->id }}</code></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Name</label>
                        <p class="fw-medium mb-0">{{ $tenant->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Admin Name</label>
                        <p class="mb-0">{{ $tenant->admin_name ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Admin Email</label>
                        <p class="mb-0">{{ $tenant->admin_email ?? '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Created</label>
                        <p class="mb-0">{{ $tenant->created_at?->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fs-13">Domain</label>
                        <p class="mb-0">
                            @forelse ($tenant->domains as $domain)
                                <a href="http://{{ $domain->domain }}:8000" target="_blank">{{ $domain->domain }}</a>
                            @empty
                                —
                            @endforelse
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header bg-white py-3"><h6 class="mb-0">Subscription Summary</h6></div>
            <div class="card-body">
                @if($tenant->activeSubscription)
                    @php $sub = $tenant->activeSubscription; @endphp
                    <div class="mb-2">
                        <label class="form-label text-muted fs-13">Plan</label>
                        <p class="fw-medium mb-0">{{ $sub->plan?->name ?? '—' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-muted fs-13">Status</label>
                        <p class="mb-0"><span class="badge badge-soft-{{ $sub->statusColor() }}">{{ ucfirst($sub->status) }}</span></p>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-muted fs-13">Starts</label>
                        <p class="mb-0">{{ $sub->starts_at?->format('d M Y') ?? '—' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-muted fs-13">Ends</label>
                        <p class="mb-0">{{ $sub->ends_at?->format('d M Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <label class="form-label text-muted fs-13">Price</label>
                        <p class="mb-0 fw-bold">₹{{ number_format($sub->amount(), 2) }}</p>
                    </div>
                @else
                    <p class="text-muted mb-0">No active subscription</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white py-3"><h6 class="mb-0">Quick Stats</h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Users</span>
                    <strong>{{ $users->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Invoiced</span>
                    <strong>₹{{ number_format($financials['invoice_total'], 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Payments</span>
                    <strong>{{ $allPayments->count() }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
