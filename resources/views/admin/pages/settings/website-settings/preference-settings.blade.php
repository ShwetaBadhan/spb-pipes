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
                                    <h6 class="fw-bold mb-0">Preferences</h6>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Products</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Inventory</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Invoices</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Credit Notes</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Quotations</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Delivery Challans</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Customers</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Purchases</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Purchase Order</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Debit Notes</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Suppliers</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Supplier Payments</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Expenses</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Incomes</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Payments</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Transactions</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Bank Accounts</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">Reports</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-sm-6">
                                        <div class="d-flex justify-content-between align-items-center border rounded bg-white p-3 mb-3">
                                            <p class="text-gray-9 mb-0">User Management</p>
                                            <div class="form-check form-switch ps-2">
                                                <input class="form-check-input m-0" type="checkbox" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  <!-- end col-->
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
