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
                            <div class="card settings-card">
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
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <!-- End settings sidebar -->

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-4">
                                    <h5 class="mb-0">System Settings</h5>
                                </div>

                            

                                <form action="{{ route('settings.system-settings.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- ============================================ -->
                                    <!-- SECTION 1: LOGO & BRANDING SETTINGS          -->
                                    <!-- ============================================ -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="ri-image-line me-2"></i>Logo & Branding Settings
                                            </h6>
                                        </div>
                                        <div class="card-body">

                                            <!-- White Logo -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">White Logo <span
                                                        class="text-muted small">(For dark backgrounds)</span></label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" name="white_logo"
                                                            id="white_logo" accept="image/*">
                                                        <small class="text-muted">PNG, JPG, SVG (Max 2MB)</small>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        @if ($white_logo)
                                                            <img src="{{ asset('storage/' . $white_logo) }}"
                                                                alt="White Logo" class="img-thumbnail"
                                                                style="max-height: 60px;">
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                onclick="removeImage('white_logo')">
                                                                <i class="isax isax-trash me-2"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Black Logo -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Black Logo <span
                                                        class="text-muted small">(For light backgrounds)</span></label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" name="black_logo"
                                                            id="black_logo" accept="image/*">
                                                        <small class="text-muted">PNG, JPG, SVG (Max 2MB)</small>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        @if ($black_logo)
                                                            <img src="{{ asset('storage/' . $black_logo) }}"
                                                                alt="Black Logo" class="img-thumbnail"
                                                                style="max-height: 60px;">
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                onclick="removeImage('black_logo')">
                                                                <i class="isax isax-trash me-2"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Single Logo -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Single Logo <span
                                                        class="text-muted small">(Default/General use)</span></label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" name="single_logo"
                                                            id="single_logo" accept="image/*">
                                                        <small class="text-muted">PNG, JPG, SVG (Max 2MB)</small>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        @if ($single_logo)
                                                            <img src="{{ asset('storage/' . $single_logo) }}"
                                                                alt="Single Logo" class="img-thumbnail"
                                                                style="max-height: 60px;">
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                onclick="removeImage('single_logo')">
                                                                <i class="isax isax-trash me-2"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Favicon -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Favicon</label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" name="favicon"
                                                            id="favicon" accept="image/*,.ico">
                                                        <small class="text-muted">PNG, ICO (Max 512KB) - Recommended: 32x32
                                                            or 64x64</small>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        @if ($favicon)
                                                            <img src="{{ asset('storage/' . $favicon) }}" alt="Favicon"
                                                                class="img-thumbnail" style="max-height: 40px;">
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                onclick="removeImage('favicon')">
                                                                <i class="isax isax-trash me-2"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cover Image -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Cover Image <span
                                                        class="text-muted small">(Social media, email headers,
                                                        etc.)</span></label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <input type="file" class="form-control" name="cover_image"
                                                            id="cover_image" accept="image/*">
                                                        <small class="text-muted">PNG, JPG (Max 5MB) - Recommended:
                                                            1200x630</small>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        @if ($cover_image)
                                                            <img src="{{ asset('storage/' . $cover_image) }}"
                                                                alt="Cover Image" class="img-thumbnail"
                                                                style="max-height: 80px;">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2 text-end">
                                                        @if ($cover_image)
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                onclick="removeImage('cover_image')">
                                                                <i class="isax isax-trash me-2"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Helpline Number -->
                                            <div class="mb-0">
                                                <label for="helpline_number" class="form-label fw-bold">Helpline
                                                    Number</label>
                                                <input type="text" class="form-control" id="helpline_number"
                                                    name="helpline_number"
                                                    value="{{ old('helpline_number', $helpline_number) }}"
                                                    placeholder="+1 234 567 8900">
                                            </div>

                                        </div>
                                    </div>

                                    <!-- ============================================ -->
                                    <!-- SECTION 2: COMPANY INFORMATION               -->
                                    <!-- ============================================ -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="ri-building-line me-2"></i>Company Information
                                            </h6>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">
                                                <!-- Company Name -->
                                                <div class="col-md-6 mb-4">
                                                    <label for="company_name" class="form-label fw-bold">Company
                                                        Name</label>
                                                    <input type="text" class="form-control" id="company_name"
                                                        name="company_name"
                                                        value="{{ old('company_name', $company_name) }}"
                                                        placeholder="Your Company Name">
                                                </div>

                                                <!-- Company Email -->
                                                <div class="col-md-6 mb-4">
                                                    <label for="company_email" class="form-label fw-bold">Company
                                                        Email</label>
                                                    <input type="email" class="form-control" id="company_email"
                                                        name="company_email"
                                                        value="{{ old('company_email', $company_email) }}"
                                                        placeholder="info@company.com">
                                                </div>

                                                <!-- Company Phone -->
                                                <div class="col-md-6 mb-4">
                                                    <label for="company_phone" class="form-label fw-bold">Company
                                                        Phone</label>
                                                    <input type="text" class="form-control" id="company_phone"
                                                        name="company_phone"
                                                        value="{{ old('company_phone', $company_phone) }}"
                                                        placeholder="+1 234 567 8900">
                                                </div>

                                                <!-- Company Location -->
                                                <div class="col-md-6 mb-4">
                                                    <label for="company_location" class="form-label fw-bold">Company
                                                        Location</label>
                                                    <input type="text" class="form-control" id="company_location"
                                                        name="company_location"
                                                        value="{{ old('company_location', $company_location) }}"
                                                        placeholder="City, State, Country">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i> Save All Settings
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="ri-refresh-line me-1"></i> Reset
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
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
