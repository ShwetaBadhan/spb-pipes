<!-- resources/views/admin/pages/invoices/invoice-details.blade.php -->

@extends('admin.layout.master')
@section('title', 'Invoice Details - ' . $invoice->invoice_number)
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6>
                            <a href="{{ route('admin.invoices.index') }}">
                                <i class="isax isax-arrow-left me-2"></i>Back to Invoices
                            </a>
                        </h6>
                        <div class="d-flex gap-2">
                            @if (in_array($invoice->status, ['unpaid', 'partially_paid']))
                                <a href="{{ route('admin.invoices.add-payment', $invoice->id) }}" class="btn btn-success">
                                    <i class="isax isax-money-3 me-1"></i>Record Payment
                                </a>
                            @endif
                            <a href="{{ route('admin.invoices.pdf', $invoice->id) }}" class="btn btn-outline-primary">
                                <i class="isax isax-document-download me-1"></i>Download PDF
                            </a>
                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-outline-secondary">
                                <i class="isax isax-edit me-1"></i>Edit
                            </a>
                             <!-- ✅ Add View Ledger button here -->
    <a href="javascript:void(0);" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#ledgerModal">
        <i class="isax isax-eye me-1"></i>View Ledger
    </a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <!-- Invoice Summary -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Invoice: {{ $invoice->invoice_number }}</h5>
                                    <p class="mb-1"><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
                                    <p class="mb-1"><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>
                                    <p class="mb-1"><strong>Due Date:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h2 class="text-primary">₹{{ number_format($invoice->grand_total, 0) }}</h2>
                                    <p class="mb-1"><strong class="text-success">Paid:</strong>
                                        ₹{{ number_format($invoice->total_paid, 0) }}</p>
                                    <p class="mb-1"><strong class="text-danger">Pending:</strong>
                                        ₹{{ number_format($invoice->outstanding_amount, 0) }}</p>
                                    <span
                                        class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'partially_paid' ? 'info' : 'warning') }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                    </span>
                                </div>
                            </div>

 <!-- Date Filter -->
                {{-- <form id="ledgerFilterForm" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="date" class="form-control form-control-sm" id="filter-start-date"
                                value="{{ \Carbon\Carbon::now()->subMonths(6)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-5">
                            <input type="date" class="form-control form-control-sm" id="filter-end-date"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="filterLedger()">
                                Apply
                            </button>
                        </div>
                    </div>
                </form> --}}
                {{-- @include('admin.pages.invoices.partials.ledger-table', ['ledgers' => $invoice->ledgers]) --}}
                            <!-- ✅ PAYMENT HISTORY SECTION (LEDGER DETAILS) -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Payment History (Ledger)</h6>
                                    <span class="badge bg-info text-dark">
                                        {{ $invoice->ledgers->count() }} Entries
                                    </span>
                                </div>
                                <div class="card-body">
                                    @if ($invoice->ledgers->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Type</th>

                                                        <th>Paid Amount (₹)</th>
                                                        <th>Balance (₹)</th>
                                                        <th>Payment Mode</th>
                                                        <th>Notes</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <!-- In invoice-details.blade.php payment history table -->
                                                <tbody>
                                                    @foreach ($invoice->ledgers as $entry)
                                                        <tr>
                                                            <td><small>{{ $entry->created_at->format('d M Y, h:i A') }}</small>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $entry->transaction_type == 'invoice_created'
                                                                        ? 'bg-info'
                                                                        : ($entry->transaction_type == 'payment_received'
                                                                            ? 'bg-success'
                                                                            : 'bg-warning') }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $entry->transaction_type)) }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                @if ($entry->credit > 0)
                                                                    <span
                                                                        class="text-success fw-bold">₹{{ number_format($entry->credit, 0) }}</span>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="fw-bold {{ $entry->balance >= 0 ? 'text-dark' : 'text-danger' }}">
                                                                ₹{{ number_format(abs($entry->balance), 0) }}
                                                                <!-- ✅ Show absolute value -->
                                                            </td>
                                                            <td>{{ $entry->payment_mode ? ucfirst(str_replace('_', ' ', $entry->payment_mode)) : '-' }}
                                                            </td>
                                                            <td><small>{{ $entry->notes ?? '-' }}</small></td>
                                                     
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="isax isax-document-text fs-1 mb-2 text-muted"></i>
                                            <p class="text-muted mb-0">No payment history available for this invoice.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Invoice Items Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                                <td>₹{{ number_format($item->rate, 0) }}</td>
                                                <td>{{ $item->discount_percent }}%</td>
                                                <td>₹{{ number_format($item->amount, 0) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end">Subtotal:</th>
                                            <th>₹{{ number_format($invoice->subtotal, 0) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Tax:</th>
                                            <th>₹{{ number_format($invoice->total_tax, 0) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Shipping:</th>
                                            <th>₹{{ number_format($invoice->shipping_cost, 0) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Discount:</th>
                                            <th>₹{{ number_format($invoice->discount_amount, 0) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Grand Total:</th>
                                            <th class="text-primary fw-bold">₹{{ number_format($invoice->grand_total, 0) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Notes Section -->
                            @if ($invoice->notes)
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">Notes:</h6>
                                    <p class="mb-0">{{ $invoice->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Ledger Summary Modal -->
<div class="modal fade" id="ledgerModal" tabindex="-1" aria-labelledby="ledgerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ledgerModalLabel">Payment Ledger Summary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Summary Card -->
                <div class="row mb-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted">Invoice Amount</small>
                            <h5 class="mb-0 text-primary">₹{{ number_format($invoice->grand_total, 0) }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-success-subtle rounded">
                            <small class="text-success">Total Paid</small>
                            <h5 class="mb-0 text-success">₹{{ number_format($invoice->total_paid, 0) }}</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-warning-subtle rounded">
                            <small class="text-danger">Pending</small>
                            <h5 class="mb-0 text-danger">₹{{ number_format($invoice->outstanding_amount, 0) }}</h5>
                        </div>
                    </div>
                </div>

               

                <!-- Filtered Ledger Table -->
                <div class="table-responsive" id="filtered-ledger-container">
                    @include('admin.pages.invoices.partials.ledger-table', ['ledgers' => $invoice->ledgers])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

