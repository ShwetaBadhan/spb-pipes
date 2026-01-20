@extends('admin.layout.master')
@section('title', 'Customers')
@section('content')


    <!-- ========================
       Start Page Content
      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Customers</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="isax isax-export-1 me-1"></i>Export
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Download as PDF</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Download as Excel</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="{{ route('add-customer') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="isax isax-add-circle5 me-1"></i>New Customer
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Table Search Start -->
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn-searchset"><i
                                        class="isax isax-search-normal fs-12"></i></a>
                            </div>
                        </div>
                        <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center"
                            href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                            <i class="isax isax-filter me-1"></i>Filter
                        </a>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-sort me-1"></i>Sort By : <span class="fw-normal ms-1">Latest</span>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Latest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="isax isax-grid-3 me-1"></i>Column
                            </a>
                            <ul class="dropdown-menu  dropdown-menu">
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Customer</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Phone</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Counrty</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Balance</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Total Invoice</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Created On</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch">
                                        <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Status</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter Info -->
                <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                    <h6 class="fs-13 fw-semibold">Filters</h6>
                    <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Customers
                        Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                    <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">1</span>$10,000
                        - $25,000<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                    <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">2</span>Status
                        Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                    <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                </div>
                <!-- /Filter Info -->
            </div>
            <!-- Table Search End -->

            <!-- Table List -->
            <div class="table-responsive">
                <table class="table table-nowrap datatable">
                    <thead class="thead-light">
                        <tr>
                            <th class="no-sort">
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>City</th>
                            {{-- <th class="no-sort">Total Invoice</th> --}}
                            <th>Created On</th>
                            {{-- <th class="no-sort">Status</th> --}}
                            {{-- <th class="no-sort">Invoice/Ledger</th> --}}
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($customers as $customer)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div>

                                        <a href="">
                                            <h6 class="fs-14 fw-medium mb-0"><a href="">{{ $customer->name }}</a>
                                            </h6>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    {{ $customer->email }}
                                </td>
                                <td>
                                    {{ $customer->phone }}
                                </td>

                                <td>
                                    <div class="">

                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);">Billing:
                                                    {{ $customer->billingStateRelation?->name ?? '-' }}</a></h6>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);"> Shipping:
                                                    {{ $customer->shippingStateRelation?->name ?? '-' }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="">

                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);">Billing:
                                                    {{ $customer->billingCityRelation?->name ?? '-' }}</a></h6>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);"> Shipping:
                                                    {{ $customer->shippingCityRelation?->name ?? '-' }}</h6></a></h6>
                                        </div>
                                    </div>
                                </td>


                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                                {{-- <td>
                                    @if ($user->is_active)
                                        <span class="badge badge-soft-success d-inline-flex align-items-center">  
                                        Active <i class="isax isax-tick-circle ms-1"></i> </span>
                                @else
                                    <span class="badge badge-soft-danger d-inline-flex align-items-center">Inactive<i class="isax isax-close-circle ms-1"></i></span>
                                @endif                             
                                </td> --}}
                                {{-- <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('add-invoice') }}" class="btn btn-sm btn-outline-white d-inline-flex align-items-center me-1">
                                            <i class="isax isax-add-circle me-1"></i> Invoice
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-white d-inline-flex align-items-center me-1" data-bs-toggle="modal" data-bs-target="#view-ledger">
                                            <i class="isax isax-document-text-1 me-1"></i> Ledger
                                        </a>
                                    </div>
                                </td> --}}
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        {{-- <li>
                                            <a href="{{ route('customer-details', $customer->id) }}" class="dropdown-item d-flex align-items-center"><i class="isax isax-eye me-2"></i>View</a>
                                        </li> --}}
                                        <li>
                                            <a href="{{ route('edit-customer', $customer->id) }}"
                                                class="dropdown-item d-flex align-items-center"><i
                                                    class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        {{-- <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i class="isax isax-archive-2 me-2"></i>Archive</a>
                                        </li> --}}
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $customer->id }}"><i
                                                    class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Delete Modal Start -->
                            <div class="modal fade" id="delete_modal{{ $customer->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                            <h6 class="mb-1">Delete Customer {{ $customer->name }}</h6>
                                            <p class="mb-3">Are you sure, you want to delete Customer?</p>
                                            <form action="{{ route('customers.destroy', $customer->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                                                        data-bs-dismiss="modal">Cancel</a>
                                                    <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Delete Modal  End -->
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /Table List -->

        </div>
        <!-- End Content -->



    </div>

    <!-- ========================
       End Page Content
      ========================= -->


    <!-- View Ledger Modal Start -->
    <div id="view-ledger" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Customer Ledger</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-x"></i></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 p-3 rounded mb-3">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-white me-3"><i
                                    class="isax isax-printer me-1"></i>Print</button>
                            <button type="button" class="btn btn-outline-white"><i
                                    class="isax isax-document-download me-1"></i>Download PDF</button>
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#add_ledger">
                                <i class="isax isax-add-circle5 me-1"></i>Create Ledger
                            </a>
                        </div>
                    </div>
                    <div
                        class="bg-light d-flex align-items-center justify-content-between flex-wrap row-gap-3 p-3 rounded mb-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md rounded-circle me-2 flex-shrink-0">
                                <img src="assets/img/profiles/avatar-16.jpg" class="rounded-circle" alt="img">
                            </a>
                            <div>
                                <h6 class="fs-14 fw-medium mb-0"><a href="">Mitchel Johnson</a></h6>
                                <p class="mb-0"><a
                                        href="https://kanakku.dreamstechnologies.com/cdn-cgi/l/email-protection"
                                        class="__cf_email__"
                                        data-cfemail="4d272225233e22230d28352c203d2128632e2220">[email&#160;protected]</a>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-white d-inline-flex align-items-center me-3"><i
                                    class="isax isax-refresh-circle me-1 text-info"></i>Closing Balance : $400</span>
                            <span class="badge badge-sm badge-soft-success d-inline-flex align-items-center me-2"><i
                                    class="fa-solid fa-circle fs-6 me-1"></i>Credit</span>
                            <span class="badge badge-sm badge-soft-danger d-inline-flex align-items-center"><i
                                    class="fa-solid fa-circle fs-6 me-1"></i>Debit</span>
                        </div>
                    </div>
                    <!-- Table List -->
                    <div class="table-responsive border border-bottom-0">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th class="no-sort">Payment Mode</th>
                                    <th>Amount</th>
                                    <th>Closing Balance</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYOUT -1</h6>
                                    </td>
                                    <td>22 Feb 2025</td>
                                    <td>Cash</td>
                                    <td class="text-danger">$10,000</td>
                                    <td>$5,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYOUT -2</h6>
                                    </td>
                                    <td>07 Feb 2025</td>
                                    <td>Cheque</td>
                                    <td class="text-danger">$25,750</td>
                                    <td>$10,750</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYIN -1</h6>
                                    </td>
                                    <td>30 Jan 2025</td>
                                    <td>Bank Transfer</td>
                                    <td class="text-success">$50,125</td>
                                    <td>$20,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYIN -2</h6>
                                    </td>
                                    <td>17 Jan 2025</td>
                                    <td>Paypal</td>
                                    <td class="text-success">$75,900</td>
                                    <td>$50,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYOUT -3</h6>
                                    </td>
                                    <td>09 Dec 2025</td>
                                    <td>Stripe</td>
                                    <td class="text-danger">$1,20,000</td>
                                    <td>$60,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYOUT -4</h6>
                                    </td>
                                    <td>02 Dec 2025</td>
                                    <td>Cash</td>
                                    <td class="text-danger">$2,50,000</td>
                                    <td>$1,25,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYIN -3</h6>
                                    </td>
                                    <td>15 Nov 2025</td>
                                    <td>Cheque</td>
                                    <td class="text-success">$5,00,750</td>
                                    <td>$5,00,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYIN -4</h6>
                                    </td>
                                    <td>30 Nov 2025</td>
                                    <td>Bank Transfer</td>
                                    <td class="text-success">$7,50,300</td>
                                    <td>$5,00,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="fw-medium fs-14">PAYOUT -5</h6>
                                    </td>
                                    <td>12 Oct 2025</td>
                                    <td>Paypal</td>
                                    <td class="text-danger">$9,99,999</td>
                                    <td>$4,00,000</td>
                                    <td class="action-item">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <i class="isax isax-more"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#view_ledger"><i
                                                        class="isax isax-eye me-2"></i>View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#edit_ledger"><i
                                                        class="isax isax-edit me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                                    data-bs-target="#delete_ledger"><i
                                                        class="isax isax-trash me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="tfoot-light">
                                <tr class="bg-light">
                                    <td class="text-dark fw-semibold" colspan="2">Closing Balance as on 22 Feb 2025
                                    </td>
                                    <td></td>
                                    <td class="text-dark fw-semibold">$5,00,750</td>
                                    <td class="text-dark fw-semibold">$2,50,000</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /Table List -->
                </div>
            </div>
        </div>
    </div>
    <!-- /View Ledger Modal End -->

    <!-- Add Ledger Start -->
    <div id="add_ledger" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Ledger</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-x"></i></button>
                </div>
                <form action="">
                    <div class="modal-body pb-1">
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <div class="input-group position-relative">
                                <input type="text" class="form-control datetimepicker rounded-end"
                                    placeholder="dd/mm/yyyy">
                                <span class="input-icon-addon fs-16 text-gray-9">
                                    <i class="isax isax-calendar-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mode</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-1">
                                    <label class="form-check-label" for="Radio-sm-1">
                                        Credit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-2"
                                        checked="">
                                    <label class="form-check-label" for="Radio-sm-2">
                                        Debit
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Modal End -->

    <!-- Edit Ledger Start -->
    <div id="edit_ledger" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Ledger</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-x"></i></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control" value="$450">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <div class="input-group position-relative">
                                <input type="text" class="form-control datetimepicker rounded-end"
                                    placeholder="31/10/2024">
                                <span class="input-icon-addon fs-16 text-gray-9">
                                    <i class="isax isax-calendar-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mode</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-1">
                                    <label class="form-check-label" for="Radio-sm-1">
                                        Credit
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Radio" id="Radio-sm-2"
                                        checked="">
                                    <label class="form-check-label" for="Radio-sm-2">
                                        Debit
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Ledger End -->

    <!-- Delete Ledger Start -->
    <div class="modal fade" id="delete_ledger">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="assets/img/icons/delete.svg" alt="img">
                    </div>
                    <h6 class="mb-1">Delete Ledger</h6>
                    <p class="mb-3">Are you sure, you want to delete Ledger?</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                            data-bs-dismiss="modal">Cancel</a>
                        <a href="" class="btn btn-primary">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Ledger  End -->

    <!-- Delete Modal Start -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="assets/img/icons/delete.svg" alt="img">
                    </div>
                    <h6 class="mb-1">Delete Customer</h6>
                    <p class="mb-3">Are you sure, you want to delete Customer?</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                            data-bs-dismiss="modal">Cancel</a>
                        <a href="" class="btn btn-primary">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal  End -->



@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

@endpush
