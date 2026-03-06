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
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="fw-bold mb-0">Integrations</h6>
                                </div>

								<!-- start row -->
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center border-0 mb-3 pb-0">
                                                    <div class="d-flex align-items-center">
                                                        <span class="avatar avatar-lg p-2 bg-light rounded flex-shrink-0 me-2"><img src="assets/img/icons/mail-icon.svg" alt="Img"></span>
                                                        <p class="fw-medium text-gray-9">Gmail</p>
                                                    </div>
                                                </div>
                                                <p>Send invoices, payment reminders and customer communication directly </p>
                                            </div> <!-- end card body -->
                                            <div class="card-footer bg-light d-flex align-items-center justify-content-between ">
                                                <a class="btn btn-sm btn-dark rounded-2 p-1" href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input m-0" type="checkbox" checked="">
                                                </div>
                                            </div> <!-- end card footer -->
                                        </div> <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center border-0 mb-3 pb-0">
                                                    <div class="d-flex align-items-center">
                                                        <span class="avatar avatar-lg p-2 bg-light rounded flex-shrink-0 me-2"><img src="assets/img/icons/calender-icon.svg" alt="Img"></span>
                                                        <p class="fw-medium text-gray-9">Google Calendar</p>
                                                    </div>
                                                </div>
                                                <p>Automatically schedule invoice due dates and set up payment follow-up.</p>
                                            </div> <!-- end card body -->
                                            <div class="card-footer bg-light d-flex align-items-center justify-content-between ">
                                                <a class="btn btn-sm btn-dark rounded-2 p-1" href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input m-0" type="checkbox" checked="">
                                                </div>
                                            </div> <!-- end card footer -->
                                        </div> <!-- end card -->
                                    </div> <!-- end col -->
                                </div>
								<!-- end row -->
								 
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
