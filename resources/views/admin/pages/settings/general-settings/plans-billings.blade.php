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
                            {{-- <div class="card settings-card">
                                <div class="card-header">
                                    <h6 class="mb-0">Settings</h6>
                                </div>
                                <div class="card-body">
                                    <div class="sidebars settings-sidebar">
                                        <div class="sidebar-inner">
                                            <div class="sidebar-menu p-0">
                                                <ul>
                                                    <li class="submenu-open">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);" class="active">
                                                                    <i class="isax isax-setting-2 fs-18"></i>
                                                                    <span class="fs-14 fw-medium ms-2">General
                                                                        Settings</span>

                                                                </a>

                                                            </li>



                                                            <li class="submenu">
                                                                <a href="{{ route('settings.system-settings') }}">
                                                                    <i class="isax isax-more-2 fs-18"></i>
                                                                    <span class="fs-14 fw-medium ms-2">System
                                                                        Settings</span>

                                                                </a>

                                                            </li>

                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card --> --}}
                        </div><!-- end col -->

                        <!-- End settings sidebar -->

                      <div class="col-xl-9 col-lg-8">
								<div class="mb-3">
                                    <div class="pb-3 border-bottom mb-3">
                                        <h6 class="mb-0">Plans & Billings</h6>
                                    </div>
									<div class="d-flex align-items-center mb-3">
										<span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-info-circle fs-14"></i></span>
										<h6 class="fs-16 fw-semibold mb-0">Current Plan Information</h6>
									</div>
									<form action="https://kanakku.dreamstechnologies.com/html/template/account-settings.html">
										<div class="mb-3 border-bottom">
											<div class="card shadow-none bg-light">
												<div class="card-body">
													<div class="mb-0">		
														<div class="d-flex align-items-center justify-content-between">
															<div class="">
																<h6 class="fw-bold mb-2 fs-14">Basic Plan</h6>
																<div class="progress-container">
																	<svg class="progress-circle me-2" viewBox="0 0 36 36">
																		<circle class="progress-bar" cx="18" cy="18" r="16"></circle>
																		<circle class="progress-bar-fill" cx="18" cy="18" r="16"></circle>
																	</svg>		
																	<span class="fs-14">20 Days Left</span>													
																</div>															
															</div>	
															<div>														
																<button type="button" class="btn btn-primary btn-md d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#upgrade"> <i class="isax isax-crown me-1"></i>Upgrade</button>
															</div>		
														</div>																							
													</div>
													
												</div><!-- end card body -->
											</div><!-- end card -->
										</div>
										<div class="mb-0">
											<div class="d-flex align-items-center mb-3">
												<span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-card fs-14"></i></span>
												<h6 class="fs-16 fw-semibold mb-0">Saved Cards</h6>
											</div>

											<!-- start row -->
											<div class="row">
												<div class="col-xl-6">
													<div class="card shadow-none">
														<div class="card-body">
															<div class="d-flex align-items-center mb-3">
																<a href="javascript:void(0);">
																	<img src="assets/img/settings/payment-icon-01.svg" class="img-fluid me-2" alt="clock">
																</a>
																<div>
																	<p class="mb-1">James Peterson</p>
																	<h6 class="fs-14 fw-medium mb-1">Visa •••• 1568</h6>
																</div>
															</div>
															<div class="d-flex align-items-center justify-content-between">
																<a href="javascript:void(0);" class="badge badge-success bg-success">Default</a>
																<div class="d-flex align-items-center">
																	<a href="javascript:void(0);" class="avatar text-dark avatar-md border rounded-circle me-2 bg-light"><i class="isax isax-edit text-gray"></i></a>
																	<a href="javascript:void(0);" class="avatar text-dark avatar-md border rounded-circle bg-light" data-bs-toggle="modal" data-bs-target="#delete_card"><i class="isax isax-trash text-gray"></i></a>
																</div>
															</div>
														</div><!-- end card body -->
													</div><!-- end card -->
												</div><!-- end col -->
												<div class="col-xl-6">
													<div class="card shadow-none">
														<div class="card-body">
															<div class="d-flex align-items-center mb-3">
																<a href="javascript:void(0);">
																	<img src="assets/img/settings/payment-icon-02.svg" class="img-fluid me-2" alt="clock">
																</a>
																<div>
																	<p class="mb-1">Raymond Rowley</p>
																	<h6 class="fs-14 fw-medium mb-1">Mastercard •••• 1279</h6>
																</div>
															</div>
															<div class="d-flex align-items-center justify-content-between">
																<a href="javascript:void(0);" class="text-primary text-decoration-underline">Set as Default</a>
																<div class="d-flex align-items-center">
																	<a href="javascript:void(0);" class="avatar text-dark avatar-md border rounded-circle me-2 bg-light"><i class="isax isax-edit text-gray"></i></a>
																	<a href="javascript:void(0);" class="avatar text-dark avatar-md border rounded-circle bg-light" data-bs-toggle="modal" data-bs-target="#delete_card"><i class="isax isax-trash text-gray"></i></a>
																</div>
															</div>
														</div><!-- end card body -->
													</div><!-- end card -->
												</div><!-- end col -->
											</div>
											<!-- end row -->

										</div>
										<div class="mb-3 border-top pt-4">
											<div class="d-flex align-items-center mb-3">
												<span class="bg-dark avatar avatar-sm me-2 flex-shrink-0"><i class="isax isax-transaction-minus fs-14"></i></span>
												<h6 class="fs-16 fw-semibold mb-0">Transactions</h6>
											</div>
											<div>
												<!-- Table Search -->
												<div class="mb-3">
													<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
														<div class="d-flex align-items-center flex-wrap gap-2">
															<div class="input-icon-start position-relative me-2">
																<span class="input-icon-addon">
																	<i class="isax isax-search-normal"></i>
																</span>
																<input type="text" class="form-control form-control-sm bg-white" placeholder="Search">															
															</div>
														</div>
														<div class="d-flex align-items-center flex-wrap gap-2">
															<div class="dropdown">
																<a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"  data-bs-toggle="dropdown">
																	<i class="isax isax-export-1 me-1"></i>Export
																</a>
																<ul class="dropdown-menu">
																	<li>
																		<a class="dropdown-item" href="#"></a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#">Download as Excel</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>			
													
												</div>
												<!-- /Table Search -->

												<!-- Table List -->
												<div class="table-responsive table-nowrap overflow-visible">
													<table class="table border mb-0">
														<thead class="table-light">
															<tr>
																<th>Plan Name</th>
																<th>Amount</th>
																<th>Purchased Date</th>
																<th>End Date</th>
																<th>Status</th>
																<th class="no-sort"></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td><p class="text-dark">Basic</p></td>
																<td>$99</td>
																<td>22 Feb 2025</td>
																<td>22 Mar 2025</td>
																<td>
																	<span class="badge badge-soft-success d-inline-flex align-items-center">Completed
																		<i class="isax isax-tick-circle5 ms-1"></i>
																	</span>
																</td>
																<td class="action-item">
																	<a href="javascript:void(0);" data-bs-toggle="dropdown">
																		<i class="isax isax-more"></i>
																	</a>
																	<ul class="dropdown-menu">
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
																		</li>
																	</ul>
																</td>
															</tr>
															<tr>
																<td><p class="text-dark">Premium</p></td>
																<td>$199</td>
																<td>22 Jan 2025</td>
																<td>22 Feb 2025</td>
																<td>
																	<span class="badge badge-soft-success d-inline-flex align-items-center">Completed
																		<i class="isax isax-tick-circle5 ms-1"></i>
																	</span>
																</td>
																<td class="action-item">
																	<a href="javascript:void(0);" data-bs-toggle="dropdown">
																		<i class="isax isax-more"></i>
																	</a>
																	<ul class="dropdown-menu">
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
																		</li>
																	</ul>
																</td>
															</tr>
															<tr>
																<td><p class="text-dark">Enterprise</p></td>
																<td>$299</td>
																<td>22 Dec 2025</td>
																<td>22 Jan 2025</td>
																<td>
																	<span class="badge badge-soft-success d-inline-flex align-items-center">Completed
																		<i class="isax isax-tick-circle5 ms-1"></i>
																	</span>
																</td>
																<td class="action-item">
																	<a href="javascript:void(0);" data-bs-toggle="dropdown">
																		<i class="isax isax-more"></i>
																	</a>
																	<ul class="dropdown-menu">
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-2"></i>Delete</a>
																		</li>
																	</ul>
																</td>
															</tr>
															<tr>
																<td><p class="text-dark">Premium</p></td>
																<td>$199</td>
																<td>22 Nov 2025</td>
																<td>22 Dec 2025</td>
																<td>
																	<span class="badge badge-soft-success d-inline-flex align-items-center">Completed
																		<i class="isax isax-tick-circle5 ms-1"></i>
																	</span>
																</td>
																<td class="action-item">
																	<a href="javascript:void(0);" data-bs-toggle="dropdown">
																		<i class="isax isax-more"></i>
																	</a>
																	<ul class="dropdown-menu">
																		<li>
																			<a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i class="isax isax-edit me-2"></i>Edit</a>
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
												<!-- /Table List -->
											</div>
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

@push('scripts')
    <script>
        function toggleCaptchaFields(provider) {
            const googleFields = document.getElementById('google-fields');
            const cloudflareFields = document.getElementById('cloudflare-fields');

            if (provider === 'google') {
                googleFields.style.display = 'block';
                cloudflareFields.style.display = 'none';
            } else {
                googleFields.style.display = 'none';
                cloudflareFields.style.display = 'block';
            }
        }

        function checkDomain() {
            fetch("{{ route('general-settings.check-domain') }}")
                .then(response => response.json())
                .then(data => {
                    const icon = data.is_active ? 'success' : 'warning';
                    const statusColor = data.is_active ? '#198754' : '#dc3545';
                    const statusText = data.is_active ? 'Active' : 'Inactive';

                    Swal.fire({
                        icon: icon,
                        title: data.is_active ? 'Domain Verified!' : 'Domain Mismatch',
                        text: data.message,
                        footer: `
                    <div class="text-start w-100">
                        <small class="text-muted">
                            <strong>Current Domain:</strong> ${data.current_domain}<br>
                            <strong>Captcha Status:</strong> <span style="color: ${statusColor}; font-weight: bold;">${statusText}</span>
                        </small>
                    </div>
                `,
                        timer: 10000, // 10 seconds in milliseconds
                        timerProgressBar: true, // Shows progress bar
                        showConfirmButton: true, // Keep button in case they want to close early
                        confirmButtonText: 'OK'
                    });

                    // Reload after 10 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 10000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check domain. Please try again.',
                        timer: 10000,
                        timerProgressBar: true,
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>
@endpush
