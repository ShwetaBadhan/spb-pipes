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
                                        <h6 class="mb-0">Currencies</h6>
                                    </div>
                                    <div class="mb-3">
										
										<!-- start row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-icon-start position-relative mb-3">
                                                    <span class="input-icon-addon">
														<i class="isax isax-search-normal"></i>
													</span>
                                                    <input type="text" class="form-control form-control-sm bg-white" placeholder="Search">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-8">
                                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-2 mb-3">
                                                    <div>
                                                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>New Currency</a>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

                                        <!-- Start Table List -->
                                        <div class="table-responsive border border-bottom-0 rounded">
                                            <table class="table mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Currency</th>
                                                        <th>Code</th>
                                                        <th class="no-sort">Symbol</th>
                                                        <th>Exchange Rate</th>
                                                        <th class="no-sort">Default</th>
                                                        <th class="no-sort">Status</th>
                                                        <th class="no-sort"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14 fw-medium mb-0">Dollar</h6></td>
                                                        <td>USD</td>
                                                        <td>$</td>
                                                        <td>01</td>
                                                        <td class="default-star">
                                                            <a class="active" href="javascript:void(0);">
                                                                <i class="isax isax-star"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td class="action-item">
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                <i class="isax isax-more"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14 fw-medium mb-0">Rupee</h6></td>
                                                        <td>INR</td>
                                                        <td>₹</td>
                                                        <td>86.62</td>
                                                        <td class="default-star">
                                                            <a href="javascript:void(0);">
                                                                <i class="isax isax-star"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td class="action-item">
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                <i class="isax isax-more"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14 fw-medium mb-0">Pound</h6></td>
                                                        <td>GBP</td>
                                                        <td>£</td>
                                                        <td>0.81</td>
                                                        <td class="default-star">
                                                            <a href="javascript:void(0);">
                                                                <i class="isax isax-star"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td class="action-item">
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                <i class="isax isax-more"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14 fw-medium mb-0">Euro</h6></td>
                                                        <td>EUR</td>
                                                        <td>€</td>
                                                        <td>0.96</td>
                                                        <td class="default-star">
                                                            <a href="javascript:void(0);">
                                                                <i class="isax isax-star"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch">
                                                            </div>
                                                        </td>
                                                        <td class="action-item">
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                <i class="isax isax-more"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14 fw-medium mb-0">Dhirams</h6></td>
                                                        <td>AED</td>
                                                        <td>د.إ</td>
                                                        <td>3.67</td>
                                                        <td class="default-star">
                                                            <a href="javascript:void(0);">
                                                                <i class="isax isax-star"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                                            </div>
                                                        </td>
                                                        <td class="action-item">
                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                                                <i class="isax isax-more"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="isax isax-edit me-2"></i>Edit</a>
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
                                        <!-- End Table List -->

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
