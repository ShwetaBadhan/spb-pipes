@extends('admin.layout.master')

@section('page-title', 'Invoice Templates')

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

                              <div class="row gx-3">
    @if($settings && $settings->invoice_image)
    <div class="col-xl-3 col-md-6">
        <div class="card invoice-template">
            <div class="card-body p-2">
                <div class="invoice-img">
                    <img src="{{ Storage::url($settings->invoice_image) }}" alt="Template" class="w-100">
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <a href="#">Custom Template 1</a>
                    <a href="javascript:void(0);" class="invoice-star">
                        <i class="isax isax-star"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
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