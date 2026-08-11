@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            @if (session('success'))
                <script>
                    Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 4000, timerProgressBar: true, showConfirmButton: false });
                </script>
            @endif

            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Transactions</h6>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-transaction-minus fs-14"></i></span>
                                    <h6 class="fs-16 fw-semibold mb-0">Billing History</h6>
                                    <a href="{{ route('tenant.billing') }}" class="btn btn-sm btn-outline-primary ms-auto">Back to Plans & Billing</a>
                                </div>

                                <div class="table-responsive table-nowrap">
                                    <table class="table border mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Reference</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($invoices as $invoice)
                                                <tr>
                                                    <td><p class="text-dark mb-0">{{ $invoice->stripe_invoice_id ?? 'Invoice #' . $invoice->id }}</p></td>
                                                    <td>${{ number_format($invoice->amount, 2) }}</td>
                                                    <td>{{ $invoice->invoice_date?->format('M d, Y') ?? '—' }}</td>
                                                    <td>
                                                        <span class="badge badge-soft-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'failed' ? 'danger' : 'warning') }}">
                                                            {{ $invoice->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($invoice->pdf_path)
                                                            <a href="{{ route('tenant.billing.invoice.download', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="isax isax-document-download"></i> PDF
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No transactions yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if ($invoices->hasPages())
                                    <div class="mt-3">{{ $invoices->links() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
