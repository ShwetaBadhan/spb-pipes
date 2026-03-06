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
                                    <div class="pb-3 d-flex border-bottom mb-3">
                                        <h6 class="mb-0">Custom CSS</h6>                                        
                                    </div>
                                    <div class="mb-3">
                                        <h5 class="mb-3 text-dark fs-14">Write Custom CSS</h5>
                                        <div class="bg-light text-gray-9 rounded-3 border">
<pre class="language-markup mb-0">
<code class="language-markup mb-0">
    .section-header { 
        margin-bottom: 50px;
    }
    .section-header h2{
        font-size: 36px;
        font-weight: 700;
        color: #0A0A0A;
        margin-bottom: 14px;
    }
    .section-header h5 {
        font-size: 18px;
        color: #680A83;
        font-weight: 600;
        text-align: center;
        margin-bottom: 8px;
    }
</code>
</pre>
                                        </div>
                                        
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-4">
                                        <a href="javascript:void(0);" class="btn btn-outline-white">Cancel</a>
                                        <a href="javascript:void(0);" class="btn btn-primary">Save Changes</a>
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
