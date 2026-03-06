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
                       <div class="col-xl-9 col-lg-8">
								<div class="mb-3">
									<div class="pb-3 border-bottom mb-3">
										<h6 class="mb-0">Saas Settings</h6>
									</div>
									<form action="https://kanakku.dreamstechnologies.com/html/template/sass-settings.html">
										<div class="card-body vh-100 border-bottom mb-3">
											<div class="row align-items-center mb-3">
												<div class="col-md-8 col-sm-12">
													<label class="form-label fw-medium">Default Currency</label>
												</div>
												<div class="col-md-4 col-sm-12">
													<select class="select form-control">
														<option>Dollar</option>
														<option>USD</option>
														<option>Euro</option>
														<option>Pound</option>
														<option>Rupee</option>
													</select>
												</div>
											</div>
											<div class="row align-items-center mb-3">
												<div class="col-md-8 col-sm-12">
													<label class="form-label fw-medium">Days between initial warning and subscription ends</label>
												</div>
												<div class="col-md-4 col-sm-12">
													<input type="text" class="form-control">
												</div>
											</div> 
											<div class="row align-items-center mb-3">
												<div class="col-md-8 col-sm-12">
													<label class="form-label fw-medium">Interval days between warnings</label>
												</div>
												<div class="col-md-4 col-sm-12">
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="row align-items-center mb-3">
												<div class="col-md-8 col-sm-12">
													<label class="form-label fw-medium">Maximum Free Domain A Subscriber Can Create</label>
												</div>
												<div class="col-md-4 col-sm-12">
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="row align-items-center mb-3">
												<div class="col-9">
													<label class="form-label fw-medium">Email Verification</label>
												</div>
												<div class="col-3 d-flex justify-content-end">
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox" role="switch" checked>
													</div>
												</div>
											</div>
											<div class="row align-items-center">
												<div class="col-9">
													<label class="form-label fw-medium">Auto approve Domain creation request</label>
												</div>
												<div class="col-3 d-flex justify-content-end">
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox" role="switch" checked />
													</div>
												</div>
											</div>
										</div>
										
										<div class="modal-footer justify-content-between">
											<a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-back me-2 border">Cancel</a>
											<a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary">Save Changes</a>
										</div>
									</form>
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
