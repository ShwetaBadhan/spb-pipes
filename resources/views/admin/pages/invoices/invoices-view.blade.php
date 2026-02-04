@extends("admin.layout.master")
@section("title","Invoices")
@section('content')

<div class="page-wrapper">
    <div class="content">
        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <p class="mb-1">Total Invoices</p>
                                <h6 class="fs-16 fw-semibold">{{ $totalInvoices }}</h6>
                                <p class="fs-13 mb-0 text-muted">₹{{ number_format($totalAmount, 2) }}</p>
                            </div>
                            <div>
                                <span class="avatar bg-primary rounded-circle">
                                    <i class="isax isax-receipt-item"></i>
                                </span>
                            </div>
                        </div>
                        <p class="fs-13 mb-0">
                            <span class="text-success">
                                <i class="isax isax-send text-success me-1"></i>
                                {{ $totalInvoices > 0 ? number_format(($totalInvoices / ($totalInvoices + 1)) * 100, 2) : 0 }}%
                            </span> from last month
                        </p>
                        <span class="position-absolute end-0 bottom-0">
                            <img src="{{ url('assets/img/bg/card-overlay-01.svg') }}" alt="User Img">
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <p class="mb-1">Paid Invoices</p>
                                <h6 class="fs-16 fw-semibold">{{ $paidInvoices }}</h6>
                                <p class="fs-13 mb-0 text-muted">₹{{ number_format($paidAmount, 2) }}</p>
                            </div>
                            <div>
                                <span class="avatar bg-success rounded-circle">
                                    <i class="isax isax-tick-circle"></i>
                                </span>
                            </div>
                        </div>
                        <p class="fs-13 mb-0">
                            <span class="text-success">
                                <i class="isax isax-send text-success me-1"></i>
                                {{ $totalInvoices > 0 ? number_format(($paidInvoices / $totalInvoices) * 100, 2) : 0 }}%
                            </span> of total
                        </p>
                        <span class="position-absolute end-0 bottom-0">
                            <img src="{{ url('assets/img/bg/card-overlay-02.svg') }}" alt="User Img">
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <p class="mb-1">Pending Invoices</p>
                                <h6 class="fs-16 fw-semibold">{{ $pendingInvoices }}</h6>
                                <p class="fs-13 mb-0 text-muted">₹{{ number_format($pendingAmount, 2) }}</p>
                            </div>
                            <div>
                                <span class="avatar bg-warning rounded-circle">
                                    <i class="isax isax-timer"></i>
                                </span>
                            </div>
                        </div>
                        <p class="fs-13 mb-0">
                            <span class="text-warning">
                                <i class="isax isax-timer text-warning me-1"></i>
                                {{ $totalInvoices > 0 ? number_format(($pendingInvoices / $totalInvoices) * 100, 2) : 0 }}%
                            </span> of total
                        </p>
                        <span class="position-absolute end-0 bottom-0">
                            <img src="{{ url('assets/img/bg/card-overlay-03.svg') }}" alt="User Img">
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <p class="mb-1">Overdue Invoices</p>
                                <h6 class="fs-16 fw-semibold">{{ $overdueInvoices }}</h6>
                                <p class="fs-13 mb-0 text-muted">₹{{ number_format($overdueAmount, 2) }}</p>
                            </div>
                            <div>
                                <span class="avatar bg-danger rounded-circle">
                                    <i class="isax isax-information"></i>
                                </span>
                            </div>
                        </div>
                        <p class="fs-13 mb-0">
                            <span class="text-danger">
                                <i class="isax isax-received text-danger me-1"></i>
                                {{ $totalInvoices > 0 ? number_format(($overdueInvoices / $totalInvoices) * 100, 2) : 0 }}%
                            </span> of total
                        </p>
                        <span class="position-absolute end-0 bottom-0">
                            <img src="{{ url('assets/img/bg/card-overlay-04.svg') }}" alt="User Img">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">Invoices Management</h4>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                <i class="isax isax-add-circle me-1"></i>Add Invoice
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.invoices.index') }}">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by invoice number..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="partially_paid" {{ request('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="customer_id" class="form-select">
                                <option value="">All Customers</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="isax isax-search-normal me-1"></i>Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="#tab1" data-bs-toggle="tab">All <span class="badge bg-primary ms-1">{{ $allInvoices->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab2" data-bs-toggle="tab">Paid <span class="badge bg-success ms-1">{{ $paid->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab3" data-bs-toggle="tab">Overdue <span class="badge bg-danger ms-1">{{ $overdue->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab4" data-bs-toggle="tab">Upcoming <span class="badge bg-warning ms-1">{{ $upcoming->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab5" data-bs-toggle="tab">Cancelled <span class="badge bg-secondary ms-1">{{ $cancelled->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab6" data-bs-toggle="tab">Partially Paid <span class="badge bg-info ms-1">{{ $partiallyPaid->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab7" data-bs-toggle="tab">Unpaid <span class="badge bg-warning ms-1">{{ $unpaid->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab8" data-bs-toggle="tab">Refunded <span class="badge bg-success ms-1">{{ $refunded->total() }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tab9" data-bs-toggle="tab">Draft <span class="badge bg-info ms-1">{{ $draft->total() }}</span></a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Tab 1: All Invoices -->
            <div class="tab-pane fade show active" id="tab1">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $allInvoices, 'pageName' => 'all_page'])
            </div>
            
            <!-- Tab 2: Paid Invoices -->
            <div class="tab-pane fade" id="tab2">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $paid, 'pageName' => 'paid_page'])
            </div>
            
            <!-- Tab 3: Overdue Invoices -->
            <div class="tab-pane fade" id="tab3">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $overdue, 'pageName' => 'overdue_page'])
            </div>
            
            <!-- Tab 4: Upcoming Invoices -->
            <div class="tab-pane fade" id="tab4">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $upcoming, 'pageName' => 'upcoming_page'])
            </div>
            
            <!-- Tab 5: Cancelled Invoices -->
            <div class="tab-pane fade" id="tab5">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $cancelled, 'pageName' => 'cancelled_page'])
            </div>
            
            <!-- Tab 6: Partially Paid Invoices -->
            <div class="tab-pane fade" id="tab6">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $partiallyPaid, 'pageName' => 'partially_paid_page'])
            </div>
            
            <!-- Tab 7: Unpaid Invoices -->
            <div class="tab-pane fade" id="tab7">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $unpaid, 'pageName' => 'unpaid_page'])
            </div>
            
            <!-- Tab 8: Refunded Invoices -->
            <div class="tab-pane fade" id="tab8">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $refunded, 'pageName' => 'refunded_page'])
            </div>
            
            <!-- Tab 9: Draft Invoices -->
            <div class="tab-pane fade" id="tab9">
                @include('admin.pages.invoices.partials.invoice-table', ['invoices' => $draft, 'pageName' => 'draft_page'])
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables only for active tab
    function initDataTable(tabId) {
        const table = $(tabId + ' .datatable');
        if (table.length && !$.fn.DataTable.isDataTable(table)) {
            table.DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' }
                ],
                "language": {
                    "emptyTable": "No invoices found"
                }
            });
        }
    }
    
    // Initialize for active tab on page load
    initDataTable('.tab-pane.active');
    
    // Reinitialize DataTable when tab changes
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const targetTab = $(e.target).attr('href');
        initDataTable(targetTab);
    });
    
    
    
    // Download PDF
    $(document).on('click', '.download-pdf', function(e) {
        e.preventDefault();
        const invoiceId = $(this).data('id');
        window.location.href = '{{ url('admin/invoices') }}/' + invoiceId + '/pdf';
    });
    
    // Preserve active tab on page reload
    const hash = window.location.hash;
    if (hash) {
        $('.nav-tabs a[href="' + hash + '"]').tab('show');
    }
    
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        const target = $(e.target).attr('href');
        history.replaceState(null, null, target);
    });
});
</script>
@endpush