@extends('admin.layout.master')
@section('content')
    <!-- ========================
                   Start Page Content
                  ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
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
            <!-- start row -->
            <div class="row justify-content-center">

                <div class="col-xl-12">

                    <!-- start row -->
                    <div class="row settings-wrapper d-flex">

                        <!-- Start settings sidebar -->

                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')

                        </div><!-- end col -->
                    <!-- End settings sidebar -->
                            <div class="col-xl-9 col-lg-8">
                                <div>
                                    <div class="pb-3 border-bottom mb-3">
                                        <h6 class="mb-0">Email Templates</h6>
                                    </div>
                                    <div class="mb-3">
                                        
										<!-- start row -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-icon-start position-relative mb-3">
                                                    <span class="input-icon-addon">
														<i class="isax isax-search-normal"></i>
													</span>
                                                    <input type="text" class="form-control form-control-sm bg-white" placeholder="Search">

                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-9">
                                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-2 mb-3">
                                                    <div>
                                                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>New Templates</a>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        <!-- Table List -->
                                        <div class="table-responsive table-nowrap">
                                            <table class="table border mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Template Name</th>
                                                        <th>Created On</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">Welcome Email</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">24 Jan 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">Booking Confirmation</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">27 Dec 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">Booking Reminder</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">19 Dec 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">Booking Cancellation</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">08 Dec 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">Seasonal Promotions & Discounts</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">25 Nov 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-medium fs-14"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_email">System Update</a></h6>
                                                        </td>
                                                        <td>
                                                            <p class="text-dark">20 Nov 2025</p>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-item">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                    <i class="isax isax-more"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#view_email"><i class="isax isax-eye me-2"></i>View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <!-- /Table List -->
                                    </div>
                                </div>
                            </div><!-- end col -->
                    </div>
                    <!-- end row -->

                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- End Content -->


    </div>

    <!-- ========================
                   End Page Content
                  ========================= -->
@endsection
