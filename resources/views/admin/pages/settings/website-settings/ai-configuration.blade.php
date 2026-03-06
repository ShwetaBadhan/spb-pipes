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
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="fw-bold mb-0">AI Configuration</h6>
                                </div>
                                <form action="https://kanakku.dreamstechnologies.com/html/template/ai-configuration.html">

                                    <!-- start row -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label text-dark d-block mb-0">API Key</label>
                                            <span class="fs-13">Enter Your API Key</span>
                                        </div><!-- end col -->
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-end">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-9">
                                            <label class="form-label d-block mb-0 text-dark">Enable AI Chat Globally</label>
                                            <span class="fs-13">Seamless AI Chat Support Across the Globe</span>
                                        </div><!-- end col -->
                                        <div class="col-3">
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-9">
                                            <label class="form-label d-block mb-0 text-dark">Enable AI for Admin</label>
                                            <span class="fs-13">Empower Admins with AI-Driven Automation</span>
                                        </div><!-- end col -->
                                        <div class="col-3">
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-9">
                                            <label class="form-label d-block mb-0 text-dark">Enable AI for Users</label>
                                            <span class="fs-13">Enhance User Experience with AI Assistance</span>
                                        </div><!-- end col -->
                                        <div class="col-3">
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check form-check-sm form-switch">
                                                    <input class="form-check-input form-label" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="pt-4 mt-4 border-top mb-3">
                                        <div class="d-flex justify-content-between">
                                            <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
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
