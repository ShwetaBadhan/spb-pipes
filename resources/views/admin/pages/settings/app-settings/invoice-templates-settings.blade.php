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
								<div class="mb-0">
									<div class="pb-3 border-bottom mb-3">
										<h6 class="mb-0">Invoice Templates</h6>
									</div>
									<form action="https://kanakku.dreamstechnologies.com/html/template/invoice-setting.html">
										<ul class="nav nav-tabs nav-tabs-bottom border-bottom mb-3">
											<li class="nav-item">
												<a id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice_tab" type="button" role="tab" aria-controls="invoice_tab" aria-selected="true" href="javascript:void(0);" class="nav-link active">Invoice</a>
											</li>
											<li class="nav-item">
												<a id="purchases-tab" data-bs-toggle="tab" data-bs-target="#purchases_tab" type="button" role="tab" aria-controls="purchases_tab" aria-selected="true" class="nav-link"href="javascript:void(0);">Purchases</a>
											</li>
											<li class="nav-item">
												<a id="receipt-tab" data-bs-toggle="tab" data-bs-target="#receipt_tab" type="button" role="tab" aria-controls="receipt_tab" aria-selected="true" class="nav-link" href="javascript:void(0);">Receipt</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab" tabindex="0">
												
												<!-- start row -->
												<div class="row gx-3">
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-01.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_1"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-1.html">General Invoice 1</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-02.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_2"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-2.html">General Invoice 2</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-03.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_3"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-3.html">General Invoice 3</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-04.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_4"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-4.html">General Invoice 4</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-05.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_5"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-5.html">General Invoice 5</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-06.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_6"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-6.html">General Invoice 6</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-07.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_7"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-7.html">General Invoice 7</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-08.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_8"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-8.html">General Invoice 8</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-09.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_9"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-9.html">General Invoice 9</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-10.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_10"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="general-invoice-10.html">General Invoice 10</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
												</div>
												<!-- end row -->

											</div>
											<div class="tab-pane" id="purchases_tab" role="tabpanel" aria-labelledby="purchases-tab" tabindex="0">
												
												<!-- start row -->
												<div class="row gx-3">
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-11.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_11"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="bus-booking-invoice.html">Bus Booking</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-12.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_12"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="car-booking-invoice.html">Car Booking</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-13.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_13"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="coffee-shop-invoice.html">Coffee Shop</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-14.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_14"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="domain-hosting-invoice.html">Domain & Hosting</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-15.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_15"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="ecommerce-invoice.html">Ecommerce</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-16.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_16"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="fitness-center-invoice.html">Fitness</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-17.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_17"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="flight-booking-invoice.html">Dream Flights</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-18.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_18"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="hotel-booking-invoice.html">Hotel Booking</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-19.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_19"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="internet-billing-invoice.html">Internet Billing</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-20.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_20"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="invoice-medical.html">Medical</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-21.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_21"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="money-exchange-invoice.html">Money Exchange</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-22.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_22"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="movie-ticket-booking-invoice.html">Movie Ticket</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-23.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_23"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="restaurants-invoice.html">Restaurant</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-24.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_24"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="student-billing-invoice.html">Student Billing</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-25.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_25"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="train-ticket-invoice.html">Train Ticket</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div><!-- end card body -->
														</div><!-- end card -->
													</div><!-- end col -->
												</div>
												<!-- end row -->

											</div>
											<div class="tab-pane" id="receipt_tab" role="tabpanel" aria-labelledby="receipt-tab" tabindex="0">
												<div class="row gx-3">
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-26.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_26"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="receipt-invoice-1.html">Receipt Invoice 1</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-27.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_27"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="receipt-invoice-2.html">Receipt Invoice 2</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-28.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_28"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="receipt-invoice-3.html">Receipt Invoice 3</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-3 col-md-6">
														<div class="card invoice-template">
															<div class="card-body p-2">
																<div class="invoice-img">
																	<a href="#">
																		<img src="assets/img/invoice/general-invoice-29.svg" alt="invoice" class="w-100">
																	</a>
																	<a href="#" class="invoice-view-icon" data-bs-toggle="modal" data-bs-target="#invoice_view_29"><i class="isax isax-eye"></i></a>
																</div>
																<div class="d-flex justify-content-between align-items-center">
																	<a href="receipt-invoice-4.html">Receipt Invoice 4</a>
																	<a href="javascript:void(0);" class="invoice-star d-flex align-items-center justify-content-center">
																		<i class="isax isax-star"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>
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
