@extends("admin.layout.master")
@section("title","Supplier Payments")
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
                        <h6>Supplier Payments</h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
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
                            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_payment">
                                <i class="isax isax-add-circle5 me-1"></i>New payment
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
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <i class="isax isax-grid-3 me-1"></i>Column
                                </a>
                                <ul class="dropdown-menu  dropdown-menu">
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            <span>Suppliers</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            <span>Payment ID</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            <span>Paid Date</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            <span>Amount</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item d-flex align-items-center form-switch">
                                            <i class="fa-solid fa-grip-vertical me-3 text-default"></i>
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            <span>Payment Mode</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Info -->
                    <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                        <h6 class="fs-13 fw-semibold">Filters</h6>
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Suppliers Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">1</span>$10,000 - $25,500<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                    </div>
                    <!-- /Filter Info -->
                </div>
                <!-- Table Search End -->

                <!-- Table List Start -->
                <div class="table-responsive">
                    <table class="table table-nowrap datatable">
                        <thead class="thead-light">
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th>Supplier</th>
                                <th class="no-sort">Payment ID</th>
                                <th>Paid Date</th>
                                <th>Amount</th>
                                <th class="no-sort">Payment method</th>
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
                                            <h6 class="fs-14 fw-medium mb-0">Emma Rose</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="link-default">PAY00025</a>
                                </td>
                                <td>22 Feb 2025</td>
                                <td class="text-dark">$10,000</td>
                                <td class="text-dark">Cash</td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_payment"><i class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
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


          <!-- Add Customer Modal Start -->
        <div id="add_payment" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Payment</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <form action="">
                                <div class="row gx-3">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment ID<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Supplier<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>Emma Rose</option>
                                                <option>Ethan James</option>
                                                <option>Olivia Grace</option>
                                                <option>Liam Michael</option>
                                                <option>Sophia Marie</option>
                                                <option>Noah Daniel</option>
                                                <option>Isabella Faith</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Invoice<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>INC00025</option>
                                                <option>INC00024</option>
                                                <option>INC00023</option>
                                                <option>INC00022</option>
                                                <option>INC00021</option>
                                                <option>INC00020</option>
                                                <option>INC00019</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Reference Number<span class="text-danger ms1">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Date<span class="text-danger ms-1">*</span></label>
                                            <div class="input-group position-relative">
                                                <input type="text" class="form-control datetimepicker rounded-end" placeholder="dd/mm/yyyy">
                                                <span class="input-icon-addon fs-16 text-gray-9">
                                                    <i class="isax isax-calendar-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Mode<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>Cash</option>
                                                <option>Cheque</option>
                                                <option>Bank Transfer</option>
                                                <option>Paypal</option>
                                                <option>Stripe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Paid Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="$5200" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Due Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="$10000" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <label class="form-label">Attachment</label>
                                            <div class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column">
                                                <span class="upload-img d-block mb-2"><i class="isax isax-folder-open text-primary"></i></span>
                                                <p class="mb-0 text-gray-9">Drop your files here or <a href="#" class="text-primary text-decoration-underline">
                                                        Browse</a></p>
                                                <input type="file" accept="video/image">
                                                <p>Maximum size : 50 MB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <button type="button" class="btn btn-outline-white">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Customer Modal End -->

        <!-- Edit Customer Modal Start -->
        <div id="edit_payment" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Payment</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <form action="">
                                <div class="row gx-3">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment ID<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="PAY00025">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Supplier<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option selected>Emma Rose</option>
                                                <option>Ethan James</option>
                                                <option>Olivia Grace</option>
                                                <option>Liam Michael</option>
                                                <option>Sophia Marie</option>
                                                <option>Noah Daniel</option>
                                                <option>Isabella Faith</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Invoice<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option selected>INC00025</option>
                                                <option>INC00024</option>
                                                <option>INC00023</option>
                                                <option>INC00022</option>
                                                <option>INC00021</option>
                                                <option>INC00020</option>
                                                <option>INC00019</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Reference Number<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="REF17420">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Date<span class="text-danger ms-1">*</span></label>
                                            <div class="input-group position-relative">
                                                <input type="text" class="form-control datetimepicker rounded-end" placeholder="22 Feb 2025">
                                                <span class="input-icon-addon fs-16 text-gray-9">
                                                    <i class="isax isax-calendar-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Mode<span class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option selected>Cash</option>
                                                <option>Cheque</option>
                                                <option>Bank Transfer</option>
                                                <option>Paypal</option>
                                                <option>Stripe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="$4800">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Paid Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="$5200" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Due Amount<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" value="$10000" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <textarea class="form-control" rows="3">Payment for raw materials</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-3">
                                            <label class="form-label">Attachment</label>
                                            <div class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column">
                                                <span class="upload-img d-block mb-2"><i class="isax isax-folder-open text-primary"></i></span>
                                                <p class="mb-0 text-gray-9">Drop your files here or <a href="#" class="text-primary text-decoration-underline">
                                                        Browse</a></p>
                                                <input type="file" accept="video/image">
                                                <p>Maximum size : 50 MB</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 mb-3 border rounded-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/img/icons/document-icon.svg" alt="document-icon">
                                                    <div class="ms-2">
                                                        <p class="text-dark fw-medium mb-0">Attachment</p>
                                                        <p>15.45 KB</p>
                                                    </div>
                                                </div>
                                                <a class="btn btn-sm bg-light text-dark rounded-circle"><i class="isax isax-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <button type="button" class="btn btn-outline-white">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Customer Modal End -->

        <!-- Delete Modal Satrt -->
        <div class="modal fade" id="delete_modal">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <img src="{{ url('assets/img/icons/delete.svg')}}" alt="img">
                        </div>
                        <h6 class="mb-1">Delete Payment</h6>
                        <p class="mb-3">Are you sure, you want to delete Payment?</p>
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