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
                                <div class="mb-3 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <h6 class="fw-bold mb-0">Language</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="dropdown me-2">
                                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                                <i class="isax isax-language-square me-1"></i>Language
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg p-2">
                                                <li>
                                                    <label class="dropdown-item d-flex align-items-center rounded-1">
                                                        English
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item d-flex align-items-center rounded-1">
                                                        German
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item d-flex align-items-center rounded-1">
                                                        Arabic
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item d-flex align-items-center rounded-1">
                                                        French
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_language"><i class="isax isax-add-circle5 me-1"></i>Add New Language</a>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                                        <div class="input-icon-start position-relative me-2">
                                            <span class="input-icon-addon">
                                                <i class="isax isax-search-normal"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-sm bg-white" placeholder="Search">                                      
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"><i class="isax isax-import me-1"></i>Import Sample</a>
                                </div>

                                <!-- Custom Data Table -->
                                <div class="custom-datatable-filter table-nowrap table-responsive border rounded mb-3">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Language</th>
                                                <th>Code</th>
                                                <th>RTL</th>
                                                <th>Default</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class=" me-2 flex-shrink-0"><img src="assets/img/flags/us.svg" alt="img" class="avatar avatar-xs rounded-circle"></a>
                                                        <a href="language-setting2.html">English</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    en
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">Web</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">App</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white">Admin</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex rounded-circle p-1 align-items-center justify-content-center btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="isax isax-more"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_language"><i class="isax isax-edit me-2"></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="flex-shrink-0 me-2"><img src="assets/img/flags/de.svg" alt="img" class="avatar avatar-xs rounded-circle"></a>
                                                        <a href="language-setting2.html">German</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    de
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">Web</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">App</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white">Admin</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex rounded-circle p-1 align-items-center justify-content-center btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="isax isax-more"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_language"><i class="isax isax-edit me-2"></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="flex-shrink-0 me-2"><img src="assets/img/flags/ae.svg" alt="img" class="avatar avatar-xs rounded-circle"></a>
                                                        <a href="language-setting2.html">Arabic</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    ar
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">Web</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">App</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white">Admin</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex rounded-circle p-1 align-items-center justify-content-center btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="isax isax-more"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_language"><i class="isax isax-edit me-2"></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="flex-shrink-0 me-2"><img src="assets/img/flags/fr.svg" alt="img" class="avatar avatar-xs rounded-circle"></a>
                                                        <a href="language-setting2.html">French</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    fr
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-sm form-switch">
                                                        <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">Web</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white me-2">App</a>
                                                        <a href="language-setting2.html" class="btn btn-sm btn-outline-white">Admin</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex rounded-circle p-1 align-items-center justify-content-center btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="isax isax-more"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_language"><i class="isax isax-edit me-2"></i>Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item rounded-1" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Custom Data Table -->
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
