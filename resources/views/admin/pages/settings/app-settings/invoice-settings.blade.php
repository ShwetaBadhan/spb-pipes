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
            
            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: true
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
                                    <h6 class="mb-0">Invoice Settings</h6>
                                </div>
                                
                                <form action="{{ route('invoice-settings.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- start row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Invoice Image<span class="text-danger ms-1">*</span></label>
                                                <div class="d-flex align-items-center flex-wrap row-gap-3 mb-3">                                                
                                                    <div class="d-flex align-items-center bg-light justify-content-center avatar avatar-xxl border me-3 flex-shrink-0 text-dark frames" id="image-preview-container">
                                                        @if($settings->invoice_image)
                                                            <img src="{{ Storage::url($settings->invoice_image) }}" alt="Invoice Logo" class="img-fluid" id="image-preview" style="max-height: 80px; object-fit: contain;">
                                                        @else
                                                            <i class="isax isax-image text-primary fs-24"></i>
                                                        @endif
                                                    </div>                                              
                                                    <div class="profile-upload">
                                                        <div class="profile-uploader d-flex align-items-center">
                                                            <div class="drag-upload-btn btn btn-md btn-primary">
                                                                <i class="isax isax-image text-white fs-16 me-1"></i>
                                                                Upload Image
                                                                <input type="file" name="invoice_image" class="form-control image-sign" accept="image/png,image/jpeg,image/jpg" onchange="previewImage(this)">
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="fs-12">JPG or PNG format, not exceeding 5MB.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center">
                                        <div class="col-md-8 col-sm-12">
                                            <label class="form-label fw-medium">Invoice Prefix </label>
                                        </div><!-- end col -->
                                        <div class="col-md-4 col-sm-12">
                                            <div class="mb-3">
                                                <input type="text" name="invoice_prefix" class="form-control" value="{{ old('invoice_prefix', $settings->invoice_prefix) }}" placeholder="e.g., INV">
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center">
                                        <div class="col-md-8 col-sm-12">
                                            <label class="form-label fw-medium">Invoice Round Off </label>
                                        </div><!-- end col -->
                                        <div class="col-md-3 col-sm-12">
                                            <div class="mb-3 d-flex align-items-center">
                                                <select name="round_off_value" class="select form-select">
                                                    <option value="">Select</option>
                                                    <option value="5" {{ old('round_off_value', $settings->round_off_value) == 5 ? 'selected' : '' }}>5</option>
                                                    <option value="10" {{ old('round_off_value', $settings->round_off_value) == 10 ? 'selected' : '' }}>10</option>
                                                </select>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-md-1 col-sm-12">
                                            <div class="ms-1 d-flex align-items-center mb-3">
                                               <div class="form-check form-check-sm form-switch">
    <label class="form-check-label form-label m-0">
        <input class="form-check-input form-label" 
               type="checkbox" 
               name="enable_round_off" 
               role="switch" 
               value="1"
               {{ old('enable_round_off', $settings->enable_round_off) ? 'checked' : '' }}>
    </label>
</div>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center">
                                        <div class="col-md-8 col-sm-12">
                                            <label class="form-label fw-medium">Show Company Details </label>
                                        </div><!-- end col -->
                                        <div class="col-md-4 col-sm-12">
                                           <div class="form-check form-check-sm form-switch">
    <label class="form-check-label form-label m-0">
        <input class="form-check-input form-label" 
               type="checkbox" 
               name="show_company_details" 
               role="switch" 
               value="1"
               {{ old('show_company_details', $settings->show_company_details) ? 'checked' : '' }}>
    </label>
</div>
                                        </div><!-- end col -->
                                    </div>	
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row align-items-center">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label fw-medium">Invoice Terms </label>
                                        </div><!-- end col -->
                                        <div class="col-md-8 col-sm-12">
                                            <div class="mb-3">
                                                <textarea name="invoice_terms" id="invoice-terms" class="form-control">{{ old('invoice_terms', $settings->invoice_terms) }}</textarea>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <!-- Save Button -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="isax isax-save-2 me-2"></i>Save Settings
                                                </button>
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

    <script>
        // Image Preview Function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.getElementById('image-preview-container');
                    container.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 80px; object-fit: contain;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize TinyMCE or Quill Editor for Invoice Terms
        document.addEventListener('DOMContentLoaded', function() {
            // If using TinyMCE
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#invoice-terms',
                    height: 200,
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                });
            }
            // If using Quill
            else if (typeof Quill !== 'undefined') {
                var quill = new Quill('#invoice-terms', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
            }
        });
    </script>
@endsection