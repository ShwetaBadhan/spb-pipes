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
                                    <h6 class="fw-bold mb-0">Company Settings</h6>
                                </div>
                                <form action="https://kanakku.dreamstechnologies.com/html/template/company-settings.html">
                                    <div class="border-bottom mb-3">
                                        <div class="card-title-head">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-info-circle"></i></span> 
												General Information
											</h6>
                                        </div>

										<!-- start row -->
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Company Name <span class="text-danger">*</span>
                                                    </label>
                                                     <input type="text" class="form-control" id="company_name"
                                                        name="company_name"
                                                        value="{{ old('company_name', $company_name) }}"
                                                        placeholder="Your Company Name">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-6 col-lg-6 col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Email Address <span class="text-danger">*</span>
                                                    </label>
                                                      <input type="email" class="form-control" id="company_email"
                                                        name="company_email"
                                                        value="{{ old('company_email', $company_email) }}"
                                                        placeholder="info@company.com">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Mobile Number <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="company_phone"
                                                        name="company_phone"
                                                        value="{{ old('company_phone', $company_phone) }}"
                                                        placeholder="+1 234 567 8900">
                                                </div>
                                            </div><!-- end col -->
                                             <div class="col-md-6 mb-4">
                                                    <label for="company_location" class="form-label fw-bold">Company
                                                        Location</label>
                                                    <input type="text" class="form-control" id="company_location"
                                                        name="company_location"
                                                        value="{{ old('company_location', $company_location) }}"
                                                        placeholder="City, State, Country">
                                                </div>
                                        </div>
										<!-- end row -->
                                    </div>
                                    <div class="border-bottom mb-3 pb-3">
                                        <div class="card-title-head">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-image"></i></span> 
												Company Images
											</h6>
                                        </div>

										<!-- start row -->
                                        <div class="row align-items-center pb-3 mb-3 border-bottom">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Logo</h6>
                                                            <p class="fs-12">Upload Icon of your Company</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-light border">
                                                    <img src="assets/img/settings/company-setting-1.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

										<!-- start row -->
                                        <div class="row align-items-center pb-3 mb-3 border-bottom">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Dark Logo</h6>
                                                            <p class="fs-12">Upload Dark Logo of your company </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-dark border">
                                                    <img src="assets/img/settings/company-setting-2.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

										<!-- start row -->
                                        <div class="row align-items-center pb-3 mb-3 border-bottom">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Mini Logo</h6>
                                                            <p class="fs-12">Upload Logo of your company </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-light border">
                                                    <img src="assets/img/settings/company-setting-1.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

										<!-- start row -->
                                        <div class="row align-items-center pb-3 mb-3 border-bottom">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Dark Mini Logo</h6>
                                                            <p class="fs-12">Upload Dark Mini Logo of your company </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-dark border">
                                                    <img src="assets/img/settings/company-setting-4.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

										<!-- start row -->
                                        <div class="row align-items-center pb-3 mb-3 border-bottom">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Favicon</h6>
                                                            <p class="fs-12">Upload Logo of your company </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-light border">
                                                    <img src="assets/img/settings/company-setting-3.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

										<!-- start row -->
                                        <div class="row align-items-center">
                                            <div class="col-xl-9">
                                                <div class="row gy-3 align-items-center">
                                                    <div class="col-lg-6">
                                                        <div class="logo-info">
                                                            <h6 class="fs-14 fw-medium mb-1">Apple Icon</h6>
                                                            <p class="fs-12">Upload Logo of your company </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="profile-pic-upload mb-0 justify-content-lg-end">
                                                            <div class="new-employee-field">
                                                                <div class="mb-0">
                                                                    <div class="image-upload mb-1">
                                                                        <input type="file">
                                                                        <div class="image-uploads">
                                                                            <h4><i class="ti ti-upload me-1"></i>Change Photo</h4>
                                                                        </div>
                                                                    </div>
                                                                    <span class="fs-12">Recommended size is 250 px*100 px</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-xl-3">
                                                <div class="new-logo ms-xl-auto bg-light border">
                                                    <img src="assets/img/settings/company-setting-3.svg" alt="Logo">
                                                    <a href="javascript:void(0);" class="logo-trash bg-white text-danger me-1 mt-1"><i class="isax isax-trash"></i></a>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

                                    </div>
                                    <div class="company-address pb-2 mb-3 border-bottom">
                                        <div class="card-title-head">
                                            <h6 class="fs-16 fw-bold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-map"></i></span> 
												Address Information
											</h6>
                                        </div>

										<!-- start row -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Address <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Country <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>USA</option>
                                                        <option>India</option>
                                                        <option>French</option>
                                                        <option>Australia</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        State <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Alaska</option>
                                                        <option>Mexico</option>
                                                        <option>Tasmania</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        City <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Anchorage</option>
                                                        <option>Tijuana</option>
                                                        <option>Hobart</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Postal Code <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div><!-- end col -->
                                        </div>
										<!-- end row -->

                                    </div>
                                    <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-0">
                                        <button type="button" class="btn btn-outline-white me-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
@push('scripts')
    <script>
        // Get base URL for remove image route
        const removeImageBaseUrl = "{{ url('admin/settings/system-settings/remove-image') }}";

        // Remove Image Function
        function removeImage(type) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove this image!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${removeImageBaseUrl}/${type}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed!',
                                    text: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to remove image. Please try again.'
                            });
                        });
                }
            });
        }

        // Add event listeners to all remove buttons
        document.querySelectorAll('.remove-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                removeImage(type);
            });
        });

        // Image Preview Function
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        console.log('File selected:', file.name);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush