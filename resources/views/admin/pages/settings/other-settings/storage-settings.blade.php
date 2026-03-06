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
                                        <h6 class="mb-0">Storage</h6>
                                    </div>

									<!-- start row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="avatar avatar-md bg-light rounded p-2 me-2">
                                                                <img src="assets/img/icons/storage-icon-01.svg" class="img-fluid" alt="Img">
                                                            </span>
                                                            <p class="fw-medium text-dark">Local Storage</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" id="user1" class="form-check-input" role="switch" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card shadow-none">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="avatar avatar-md bg-light rounded p-2 me-2">
                                                                <img src="assets/img/icons/storage-icon-02.svg" class="img-fluid" alt="Img">
                                                            </span>
                                                            <p class="fw-medium text-dark">AWS</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-light rounded-2 d-inline-flex align-items-center justify-content-center p-1 me-2" data-bs-toggle="modal" data-bs-target="#aws_modal"><i class="isax isax-setting-2 fs-14"></i></a>
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" id="user2" class="form-check-input" role="switch" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div>
                                    </div>
									<!-- end row -->

                                </div>
                            </div>
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
