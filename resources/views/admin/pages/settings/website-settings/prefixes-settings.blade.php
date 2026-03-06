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
                                    <h6 class="fw-bold mb-0">Prefixes</h6>
                                </div>

								<!-- start row -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Product</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">PRO -</span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Invoice</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">INV -</span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">TXN -</span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Purchase</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">PUR - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Reference Number</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">REF - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Debit Note</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">DN - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Credit Note</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">CN - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Purchase Order</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">PO - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Payments</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">PAY - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Quotation</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">QUO - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Expense</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">EXP - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Income</label>
                                            <div class="input-group d-flex align-items-center mb-3">
                                                <span class="input-group-text border-end-0 fs-14 pe-1">INC - </span>
                                                <input type="text" class="form-control border-start-0 ps-0" aria-label="Username">
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
								<!-- end row -->

                            </div> <!-- end col  -->
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
