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
                                        <h6 class="mb-0">System Backup</h6>
                                    </div>
                                    
									<!-- start row -->
                                    <div class="row justify-content-between align-items-center pb-1">
                                        <div class="col-md-5 mb-3">
											<div class="input-icon-start position-relative">
												<span class="input-icon-addon">
													<i class="isax isax-search-normal"></i>
												</span>
												<input type="text" class="form-control form-control-sm bg-white" placeholder="Search">
											</div>	
                                        </div><!-- end col -->
                                        <div class="col-md-7 text-end mb-3">
                                            <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#generate_modal"><i class="isax isax-folder-connection5 me-1"></i>Generate Backup</a>
                                        </div><!-- end col -->
                                    </div>
									<!-- end row -->

									<!-- Table List -->
									<div class="table-responsive table-nowrap">
										<table class="table border">
											<thead class="table-light">
												<tr>
													<th class="no-sort">Template Name</th>
													<th class="no-sort">Created On</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<p class="text-dark">customer_data_backup_2025.txt</p>
													</td>
													<td>
														22 Feb 2025
													</td>
													<td class="action-item">
														<a href="javascript:void(0);" data-bs-toggle="dropdown">
															<i class="isax isax-more"></i>
														</a>
														<ul class="dropdown-menu">
															<li>
																<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</td>
												</tr>
												<tr>
													<td>
														<p class="text-dark">invoice_records_backup_2024.txt</p>
													</td>
													<td>
														07 Feb 2025
													</td>
													<td class="action-item">
														<a href="javascript:void(0);" data-bs-toggle="dropdown">
															<i class="isax isax-more"></i>
														</a>
														<ul class="dropdown-menu">
															<li>
																<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</td>
												</tr>
												<tr>
													<td>
														<p class="text-dark">sales_transactions_2024.txt</p>
													</td>
													<td>
														30 Jan 2025
													</td>
													<td class="action-item">
														<a href="javascript:void(0);" data-bs-toggle="dropdown">
															<i class="isax isax-more"></i>
														</a>
														<ul class="dropdown-menu">
															<li>
																<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</td>
												</tr>
												<tr>
													<td>
														<p class="text-dark">payment_transactions_2024</p>
													</td>
													<td>
														02 Jan 2025
													</td>
													<td class="action-item">
														<a href="javascript:void(0);" data-bs-toggle="dropdown">
															<i class="isax isax-more"></i>
														</a>
														<ul class="dropdown-menu">
															<li>
																<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
															</li>
														</ul>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Table List -->

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
