@extends('admin.layout.master')
@section('title', 'Welcome to Admin Panel')
@section('content')
    <!-- ========================
                       Start Page Content
                      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
            @can('view-alert-notifications')
                {{-- Low Stock Alert Banner --}}
                @if ($lowStockProducts->count() + $lowStockRawMaterials->count() > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>⚠️ Low Stock Alert!</strong>
                        {{ $lowStockProducts->count() }} product(s) and
                        {{ $lowStockRawMaterials->count() }} raw material(s) are below threshold.
                        <a href="{{ route('inventory.index') }}" class="alert-link">View Inventory</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            @endcan

            <!-- Start Breadcrumb -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Dashboard</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    {{-- <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                        <i class="isax isax-calendar text-gray-5 fs-14 me-1"></i><span class="reportrange-picker-field">16
                            Apr 25 - 16 Apr 25</span>
                    </div> --}}
                    {{-- <div class="dropdown">
							<a class="btn btn-primary d-flex align-items-center justify-content-center dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
								Create New
							</a>
							<ul class="dropdown-menu dropdown-menu-start">
								<li>
									<a href="" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-document-text-1 me-2"></i>Invoice
									</a>
								</li>
								<li>
									<a href="expenses.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-money-send me-2"></i>Expense
									</a>
								</li>
								<li>
									<a href="add-credit-notes.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-money-add me-2"></i>Credit Notes
									</a>
								</li>
								<li>
									<a href="add-debit-notes.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-money-recive me-2"></i>Debit Notes
									</a>
								</li>
								<li>
									<a href="add-purchases-orders.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-document me-2"></i>Purchase Order
									</a>
								</li>
								<li>
									<a href="add-quotation.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-document-download me-2"></i>Quotation
									</a>
								</li>
								<li>
									<a href="add-delivery-challan.html" class="dropdown-item d-flex align-items-center">
										<i class="isax isax-document-forward me-2"></i>Delivery Challan
									</a>
								</li>
							</ul>
						</div> --}}
                    {{-- <div class="dropdown">
							<a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"  data-bs-toggle="dropdown">
								<i class="isax isax-export-1 me-1"></i>Export
							</a>
							<ul class="dropdown-menu">
								<li>
									<a class="dropdown-item" href="javascript:void(0);">Download as PDF</a>
								</li>
								<li>
									<a class="dropdown-item" href="javascript:void(0);">Download as Excel</a>
								</li>
							</ul>
						</div> --}}
                </div>
            </div>
            <!-- End Breadcrumb -->

            <div class="bg-primary rounded welcome-wrap position-relative mb-3">

                <!-- start row -->
                <div class="row">
                    <div class="col-lg-8 col-md-9 col-sm-7">
                        <div>
                            <h5 class="text-white mb-1">
                                Hi, {{ auth()->user()->name }}
                            </h5>
                            <p class="text-white mb-3">You have 15+ invoices saved to draft that has to send to customers
                            </p>
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="d-flex align-items-center fs-13 text-white mb-0"><i
                                        class="isax isax-calendar5 me-1"></i>{{ now()->format('l, d M Y') }}</p>
                                <p class="d-flex align-items-center fs-13 text-white mb-0"><i
                                        class="isax isax-clock5 me-1"></i> <span id="current-time"></span></p>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="position-absolute end-0 top-50 translate-middle-y p-2 d-none d-sm-block">
                    <img src="{{ url('assets/img/icons/dashboard.svg') }}" alt="img">
                </div>
            </div>

            <!-- start row -->
            @canany(['view-overview-stats', 'view-invoice-stats', 'view-sales-stats'])

                <div class="row">


                    @can('view-overview-stats')
                        <div class="col-md-4 d-flex">

                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="d-flex align-items-center mb-1"><i
                                                class="isax isax-category5 text-default me-2"></i>Overview</h6>
                                    </div>
                                    <div class="row g-4">

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                                    <i class="isax isax-document-text-1 fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Invoices</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        {{ number_format($stats['invoices']) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-profile-2user fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Customers</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        {{ number_format($stats['customers']) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-dcube fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Amount Due</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        ₹{{ number_format($stats['amount_due'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-document-text fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Paid Invoices</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        {{ number_format($stats['paid_invoices']) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card body -->
                            </div> <!-- end card -->

                        </div> <!-- end col -->
                    @endcan
                    @can('view-sales-stats')
                        <div class="col-md-4 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="d-flex align-items-center mb-1"><i
                                                class="isax isax-chart-215 text-default me-2"></i>Sales Analytics</h6>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                                    <i class="isax isax-document-forward fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Orders</p>
                                                    <h6 class="fs-16 fw-semibold mb-0">{{ number_format($stats['total_orders']) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-programming-arrow fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Purchase</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        ₹{{ number_format($stats['purchase'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-dollar-circle fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 mb-0">Expenses</p>
                                                    <h6 class="fs-16 fw-semibold text-truncate">
                                                        ₹{{ number_format($stats['expenses'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-flag fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Credits</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        ₹{{ number_format($stats['credits'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    @endcan
                    @can('view-invoice-stats')
                        <div class="col-md-4 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="d-flex align-items-center mb-1"><i
                                                class="isax isax-chart-success5 text-default me-2"></i>Invoice Statistics</h6>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                                                    <i class="isax isax-document fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Invoiced</p>
                                                    <h6 class="fs-16 fw-semibold mb-0">₹{{ number_format($stats['invoiced'], 2) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-document-forward fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Received</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        ₹{{ number_format($stats['received'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-document-previous fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Outstanding</p>
                                                    <h6 class="fs-16 fw-semibold mb-0 text-truncate">
                                                        ₹{{ number_format($stats['outstanding'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="d-flex align-items-center me-2">
                                                <span
                                                    class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                                                    <i class="isax isax-dislike fs-20"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Overdue</p>
                                                    <h6 class="fs-16 fw-semibold text-truncate mb-0">
                                                        ₹{{ number_format($stats['overdue'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    @endcan

                </div>
                <!-- end row -->
            @endcanany
            <!-- start row -->
            @canany(['view-total-products', 'view-total-sales', 'view-total-customers'])
                <div class="row">
                    @can('view-total-products')
                        <div class="col-md-4 d-flex flex-column">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                                        <div>
                                            <p class="mb-1">Total Products</p>
                                            <div class="d-flex align-items-center">
                                                <h6 class="fs-16 fw-semibold me-2">{{ number_format($stats['total_products']) }}
                                                </h6>
                                                @if ($stats['new_products_this_month'] > 0)
                                                    <span class="badge badge-sm badge-soft-success">
                                                        +{{ $stats['new_products_this_month'] }}
                                                        <i class="isax isax-arrow-up-15 ms-1"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                                            <i class="isax isax-document-text fs-16"></i>
                                        </span>
                                    </div>
                                    <a href="{{ route('inventory.index') }}" class="fw-medium text-decoration-underline">View Inventory</a>
                                </div> <!-- end card body -->
                                <div class="position-absolute end-0 bottom-0 z-n1">
                                    <img src="{{ url('assets/img/bg/card-bg-01.svg') }}" alt="img">
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    @endcan
                    @can('view-total-sales')
                        <div class="col-md-4 d-flex flex-column">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                                        <div>
                                            <p class="mb-1">Total Sales</p>
                                            <div class="d-flex align-items-center">
                                                <h6 class="fs-16 fw-semibold me-2">{{ number_format($stats['total_sales']) }}</h6>
                                                @if ($stats['sales_this_month'] > 0)
                                                    <span class="badge badge-sm badge-soft-success">
                                                        +{{ $stats['sales_this_month'] }}
                                                        <i class="isax isax-arrow-up-15 ms-1"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                                            <i class="isax isax-document-text fs-16"></i>
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.invoices.index') }}" class="fw-medium text-decoration-underline">View Invoices</a>
                                </div> <!-- end card body -->
                                <div class="position-absolute end-0 bottom-0 z-n1">
                                    <img src="{{ url('assets/img/bg/card-bg-02.svg') }}" alt="img">
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    @endcan
                    @can('view-total-customers')
                        <div class="col-md-4 d-flex flex-column">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between border-bottom mb-2 pb-2">
                                        <div>
                                            <p class="mb-1">Total Customers</p>
                                            <div class="d-flex align-items-center">
                                                <h6 class="fs-16 fw-semibold me-2">{{ number_format($stats['total_customers']) }}
                                                </h6>
                                                @if ($stats['new_customers_this_month'] > 0)
                                                    <span class="badge badge-sm badge-soft-success">
                                                        +{{ $stats['new_customers_this_month'] }}
                                                        <i class="isax isax-arrow-up-15 ms-1"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="avatar avatar-lg bg-light text-dark avatar-rounded">
                                            <i class="isax isax-profile-2user fs-16"></i>
                                        </span>
                                    </div>
                                    <a href="{{ route('customers.index') }}" class="fw-medium text-decoration-underline">View All</a>
                                </div> <!-- end card body -->
                                <div class="position-absolute end-0 bottom-0 z-n1">
                                    <img src="{{ url('assets/img/bg/card-bg-03.svg') }}" alt="img">
                                </div>
                            </div> <!-- end card -->
                        </div>
                    @endcan

                </div>
                <!-- end row -->
            @endcanany

            <div class="row">
                @can('view-recent-orders')
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <h3 class="mb-0 fs-18">Recent Orders</h3>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View all Orders</a>
                                </div>
                            </div>
                            @php
                                // Filter if needed, then limit to recent 5 orders
                                // Note: It is better to limit this in your Controller (e.g., Order::latest()->take(5)->get())
                                // but here we limit the collection directly for the dashboard view.
                                $filteredOrders = isset($statusFilter)
                                    ? $orders->where('status', $statusFilter)
                                    : $orders;
                                $dashboardOrders = $filteredOrders->sortByDesc('created_at')->take(5);
                            @endphp

                            @if ($dashboardOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered custom-table-bordered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Created On</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dashboardOrders as $order)
                                                <tr>
                                                    <!-- Order ID -->
                                                    <td>
                                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                                            class="link-default fw-medium">
                                                            {{ $order->order_number }}
                                                        </a>
                                                    </td>

                                                    <!-- Customer -->
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 bg-light text-primary d-flex align-items-center justify-content-center"
                                                                style="width: 32px; height: 32px;">
                                                                <span
                                                                    class="fs-12 fw-bold">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</span>
                                                            </div>
                                                            <div>
                                                                <h3 class="fs-14 fw-medium mb-0 text-dark">
                                                                    {{ $order->customer_name }}</h3>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Created On -->
                                                    <td class="text-muted fs-14">
                                                        {{ $order->created_at->format('d M Y') }}
                                                    </td>

                                                    <!-- Amount -->
                                                    <td class="text-dark fw-medium">
                                                        ₹{{ number_format($order->total, 2) }}
                                                    </td>

                                                    <!-- Status -->
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $order->status === 'pending'
                                                                ? 'warning'
                                                                : ($order->status === 'confirmed'
                                                                    ? 'info'
                                                                    : ($order->status === 'processing'
                                                                        ? 'primary'
                                                                        : (in_array($order->status, ['shipped', 'delivered'])
                                                                            ? 'success'
                                                                            : ($order->status === 'cancelled'
                                                                                ? 'danger'
                                                                                : 'secondary')))) }} rounded-pill px-3">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i data-feather="inbox" class="mb-2" style="width: 64px; height: 64px;"></i>
                                        <h5 class="mt-3">No recent orders</h5>
                                        <p class="text-muted">There are no orders to display at the moment.</p>
                                    </div>
                                </div>
                            @endif
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                @endcan

            </div>



        </div>
        <!-- End Content -->



    </div>


@endsection
