@extends("admin.layout.master")
@section("title","Suppliers")
@section("content")

 <!-- ========================
			Start Page Content
		========================= -->

        <div class="page-wrapper">

            <!-- Start Content -->
            <div class="content content-two">

                <!-- Page Header -->
                <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div>
                        <h6>Supplier</h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
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
                        </div>
                        <div>
                            <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>New Supplier</a>
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
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                            <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                                <i class="isax isax-filter me-1"></i>Filter
                            </a>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="isax isax-sort me-1"></i>Sort By :
                                    <span class="fw-normal ms-1">Latest</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Latest</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <i class="isax isax-grid-3 me-1"></i>Column
                                </a>
                                <ul class="dropdown-menu dropdown-menu">
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            <span>Vendor</span>
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
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            <span>Created On</span>
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
                                            <input class="form-check-input m-0 me-2" type="checkbox">
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
								class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Suppliers Selected
                        <span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
								class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>$10,000 - $25,500<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                    </div>
                    <!-- /Filter Info -->

                </div>
                <!-- Table Search End -->

                <!-- Table List Start -->
                <div class="table-responsive">
                    <table class="table table-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th>Supplier</th>
                                <th>Phone</th>
                                <th>Created On</th>
                                <th>Balance</th>
                                <th>Currency</th>
                                <th class="no-sort"></th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                      
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0">
												<a href="javascript:void(0);">Emma Rose</a>
											</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>+1 202-555-0198</td>
                                <td>22 Feb 2025</td>
                                <td class="text-dark">$10,000</td>
                                <td>USD ($)</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="javascript:void(0);" class="btn btn-outline-white btn-sm justify-content-center d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#ledger_modal"><i
												class="isax isax-document-text-1 me-1"></i>Ledger</a>
                                    </div>
                                </td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
													class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                          
                        </tbody>
                    </table>
                </div>
                <!-- Table List End -->

            </div>
            <!-- End Content -->

           
             
        </div>
        <!-- ========================
			End Page Content
		========================= -->



           <!-- Add Modal Start -->
        <div id="add_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Supplier</h4>
                        <button type="button" class="btn-close custom-btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0">
                                                <i class="isax isax-image text-primary fs-24"></i>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="isax isax-image me-1"></i>Upload Image
                                                    <input type="file" class="form-control image-sign" multiple="">
                                                </div>
                                                <span class="text-gray-9 fs-12">JPG or PNG format, not exceeding 5MB.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Balance</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Modal End -->

        <!-- Edit Modal Start -->
        <div id="edit_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Supplier</h4>
                        <button type="button" class="btn-close custom-btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0">
                                                <div class="position-relative d-flex align-items-center">
                                                    <img src="{{ url('assets/img/profiles/avatar-05.jpg')}}" class="avatar avatar-xl" alt="User Img">
                                                    <a href="javascript:void(0);" class="rounded-trash trash-top d-flex align-items-center justify-content-center"><i
															class="isax isax-trash"></i></a>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="isax isax-image me-1"></i>Upload Image
                                                    <input type="file" class="form-control image-sign" multiple="">
                                                </div>
                                                <span class="text-gray-9 fs-12">JPG or PNG format, not exceeding 5MB.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="Ethan James">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" value="johnson@example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Balance</label>
                                        <input type="text" class="form-control" value="$450">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal End -->

        <!-- Delete Modal Start -->
        <div class="modal fade" id="delete_modal">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <img src="{{ url ('assets/img/icons/delete.svg')}}" alt="img">
                        </div>
                        <h6 class="mb-1">Delete Supplier</h6>
                        <p class="mb-3">Are you sure, you want to delete supplier?</p>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                            <a href="" class="btn btn-primary">Yes, Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal End -->
         

        <!-- supplier Modal Start -->
        <div id="ledger_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Supplier Ledger</h4>
                        <button type="button" class="btn-close custom-btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="javascript:void(0);" class="btn btn-outline-white btn-sm d-flex align-items-center fw-semibold"><i
														class="isax isax-export-1 me-1"></i>Print</a>
                                                <a href="javascript:void(0);" class="btn btn-outline-white btn-sm d-flex align-items-center fw-semibold"><i
														class="isax isax-export-1 me-1"></i>Download</a>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm d-flex align-items-center fw-semibold" data-bs-toggle="modal" data-bs-target="#add_ledger"><i
														class="isax isax-add-circle5 me-1"></i>Create
													Ledger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="supplier-details d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-lg border border-dashed bg-light me-3 flex-shrink-0">
                                                    <img src="{{url ('assets/img/profiles/avatar-16.jpg')}}" alt="image" class="rounded-circle">
                                                </div>
                                                <div class="d-inline-flex flex-column align-items-start">
                                                    <h6 class="fw-medium fs-14">Mitchel Johnson</h6>
                                                    <p><a href="https://kanakku.dreamstechnologies.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="117b7e797f627e7f517469707c617d743f727e7c">[email&#160;protected]</a></p>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="p-1 bg-white rounded d-flex align-items-center fw-semibold text-gray-9">
                                                    <i class="isax isax-refresh-circle5 text-info me-1"></i>Closing Balance : $400
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 justify-content-end mb-3">
                                            <span class="badge badge-sm badge-soft-success d-inline-flex">Credit</span>
                                            <span class="badge badge-sm badge-soft-danger d-inline-flex">Debit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Table List -->
                            <div class="table-responsive border border-bottom-0">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Payment Mode</th>
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
                                            <td>#987654</td>
                                            <td>22 Feb 2025</td>
                                            <td>Cash</td>
                                            <td>
                                                <span class="text-danger">$10,000</span>
                                            </td>
                                            <td>$5,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYOUT -2</h6>
                                            </td>
                                            <td>#654829</td>
                                            <td>07 Feb 2025</td>
                                            <td>Cheque</td>
                                            <td>
                                                <span class="text-danger">$25,750</span>
                                            </td>
                                            <td>$10,750</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYIN -1</h6>
                                            </td>
                                            <td>#910274</td>
                                            <td>30 Jan 2025</td>
                                            <td>Bank Transfer</td>
                                            <td>
                                                <span class="text-success">$50,125</span>
                                            </td>
                                            <td>$20,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYIN -2</h6>
                                            </td>
                                            <td>#837419</td>
                                            <td>17 Jan 2025</td>
                                            <td>Paypal</td>
                                            <td>
                                                <span class="text-success">$75,900</span>
                                            </td>
                                            <td>$50,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYOUT -3</h6>
                                            </td>
                                            <td>#983928</td>
                                            <td>09 Dec 2024</td>
                                            <td>Stripe</td>
                                            <td>
                                                <span class="text-danger">$1,20,500</span>
                                            </td>
                                            <td>$60,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYOUT -4</h6>
                                            </td>
                                            <td>#989479</td>
                                            <td>02 Dec 2024</td>
                                            <td>Cash</td>
                                            <td>
                                                <span class="text-success">$2,50,000</span>
                                            </td>
                                            <td>$1,25,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYIN -3</h6>
                                            </td>
                                            <td>#989479</td>
                                            <td>15 Nov 2024</td>
                                            <td>Cheque</td>
                                            <td>
                                                <span class="text-danger">$5,00,750</span>
                                            </td>
                                            <td>$5,00,000</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYIN -4</h6>
                                            </td>
                                            <td>#994286</td>
                                            <td>30 Nov 2024</td>
                                            <td>Bank Transfer</td>
                                            <td>
                                                <span class="text-success">$7,50,300</span>
                                            </td>
                                            <td>$2,50,500</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="fw-medium fs-14">PAYOUT -5</h6>
                                            </td>
                                            <td>#755815</td>
                                            <td>12 Oct 2024</td>
                                            <td>Paypal</td>
                                            <td>
                                                <span class="text-danger">$9,99,999</span>
                                            </td>
                                            <td>$2,50,500</td>
                                            <td class="action-item">
                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                    <i class="isax isax-more"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_ledger">
                                                            <i class="isax isax-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal_2"><i class="isax isax-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="bg-light">
                                                <h6 class="fw-medium fs-14">
													Closing Balance as on 22 Feb 2025
												</h6>
                                            </td>
                                            <td class="bg-light">
                                                <h6 class="fw-medium fs-14">$5,00,750</h6>
                                            </td>
                                            <td class="bg-light">
                                                <h6 class="fw-medium fs-14">$2,50,000</h6>
                                            </td>
                                            <td class="bg-light"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /Table List -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- supplier Modal End -->

        <!-- Add Ledger Modal Start -->
        <div id="add_ledger" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Ledger</h4>
                        <button type="button" class="btn-close custom-btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group position-relative mb-3">
                                            <input type="text" class="form-control datetimepicker rounded-end" placeholder="25 Mar 2025">
                                            <span class="input-icon-addon fs-16 text-gray-9">
												<i class="isax isax-calendar-2"></i>
											</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Reference</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Mode</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Credit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Debit
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Ledger Modal End -->

        <!-- Edit Ledger Modal Start -->
        <div id="edit_ledger" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Ledger</h4>
                        <button type="button" class="btn-close custom-btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text" class="form-control" value="$450">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <div class="input-group position-relative mb-3">
                                            <input type="text" class="form-control datetimepicker rounded-end" placeholder="25 Mar 2025">
                                            <span class="input-icon-addon fs-16 text-gray-9">
												<i class="isax isax-calendar-2"></i>
											</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Reference</label>
                                        <input type="text" class="form-control" value="#987654">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Mode</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Credit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" checked>
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    Debit
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Ledger Modal End -->

        <!-- Delete Modal Start -->
        <div class="modal fade" id="delete_modal_2">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <img src="{{ url('assets/img/icons/delete.svg')}}" alt="img">
                        </div>
                        <h6 class="mb-1">Delete Ledger</h6>
                        <p class="mb-3">Are you sure,  you want to delete Ledger?</p>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                            <a href="" class="btn btn-primary">Yes, Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal End -->


@endsection