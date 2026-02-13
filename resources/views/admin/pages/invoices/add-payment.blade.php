<!-- resources/views/admin/pages/invoices/add-payment.blade.php -->
@extends('admin.layout.master')
@section('title', 'Record Payment - ' . $invoice->invoice_number)
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <a href="{{ route('admin.invoices.show', $invoice->id) }}">
                                    <i class="isax isax-arrow-left me-2"></i>
                                </a>
                                Record Payment - {{ $invoice->invoice_number }}
                            </h5>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="isax isax-danger me-2"></i>Error!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="isax isax-danger me-2"></i>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><i class="isax isax-tick-circle me-2"></i>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="card-body">
                            <!-- Invoice Summary -->
                            <div class="mb-4 p-3 bg-light rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
                                        <p class="mb-1"><strong>Invoice Total:</strong>
                                            ₹{{ number_format($invoice->grand_total, 2) }}</p>
                                        <p class="mb-1"><strong>Invoice Date:</strong>
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <p class="mb-1"><strong class="text-success">Amount Paid:</strong>
                                            ₹{{ number_format($invoice->total_paid, 2) }}</p>
                                        <p class="mb-1"><strong class="text-danger">Outstanding:</strong>
                                            ₹{{ number_format($outstanding, 2) }}</p>
                                        <p class="mb-1"><strong>Status:</strong>
                                            <span
                                                class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'partially_paid' ? 'info' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Form -->
                            <!-- Payment Form -->
                            <form action="{{ route('admin.invoices.record-payment', $invoice->id) }}" method="POST">
                                <!-- ✅ FIXED ROUTE -->
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Payment Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount"
                                        class="form-control @error('amount') is-invalid @enderror" step="0.01"
                                        min="0.01" max="{{ $outstanding }}"
                                        value="{{ old('amount', number_format($outstanding, 2)) }}" required>
                                    <small class="text-muted">Maximum: ₹{{ number_format($outstanding, 2) }}</small>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                    <select name="payment_mode" class="select @error('payment_mode') is-invalid @enderror"
                                        required>
                                        <option value="">Select Payment Mode</option>
                                        <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="bank_transfer"
                                            {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                        </option>
                                        <option value="upi" {{ old('payment_mode') == 'upi' ? 'selected' : '' }}>UPI
                                        </option>
                                        <option value="card" {{ old('payment_mode') == 'card' ? 'selected' : '' }}>Card
                                        </option>
                                        <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>
                                            Cheque</option>
                                    </select>
                                    @error('payment_mode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Transaction ID / Reference</label>
                                    <input type="text" name="transaction_id"
                                        class="form-control @error('transaction_id') is-invalid @enderror"
                                        placeholder="e.g., UPI Transaction ID, Cheque Number, etc."
                                        value="{{ old('transaction_id') }}">
                                    <small class="text-muted">Optional - for tracking purposes</small>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                        placeholder="Payment notes...">{{ old('notes') }}</textarea>
                                    <small class="text-muted">Optional - additional information about this payment</small>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                        class="btn btn-outline-white">
                                        <i class="isax isax-arrow-left me-1"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-tick-circle me-1"></i>Record Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
