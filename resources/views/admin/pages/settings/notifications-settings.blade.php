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
                                    <h6 class="fw-bold mb-0">Notifications</h6>
                                </div>
                                <form action="https://kanakku.dreamstechnologies.com/html/template/notifications-settings.html">
                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="card-title-head d-flex align-items-center justify-content-between">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-notification"></i></span> 
												General Notifications
											</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <div class="table-responsive table-nowrap notification-table">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="fs-14">Modules </th>
                                                            <th class="fs-14">Email</th>
                                                            <th class="fs-14">SMS</th>
                                                            <th class="fs-14">In App</th>
                                                            <th class="fs-14">Whatsapp</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6 class="fs-13 fw-medium mb-1">System Updates</h6>
                                                                <p class="fs-12">Get alerts for software updates and maintenance.</p>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox">
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox">
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6 class="fs-13 fw-medium mb-1">Security Alerts</h6>
                                                                <p class="fs-12">Notify about login attempts, password changes.</p>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="card-title-head d-flex align-items-center justify-content-between">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-shopping-cart"></i></span> 
												Sales Notifications
											</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="table-responsive table-nowrap mb-0 notification-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="fs-14">Modules </th>
                                                        <th class="fs-14">Email</th>
                                                        <th class="fs-14">SMS</th>
                                                        <th class="fs-14">In App</th>
                                                        <th class="fs-14">Whatsapp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">New Sale Recorded</h6>
                                                            <p class="fs-12">Get notified when a sale is made.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">Pending Payments</h6>
                                                            <p class="fs-12">Alerts for overdue invoices.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">Transactions</h6>
                                                            <p class="fs-12">Confirmation when a payment is received.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="card-title-head d-flex align-items-center justify-content-between">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-notification-status"></i></span> 
												Invoice Notifications
											</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="table-responsive table-nowrap mb-0 notification-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="fs-14">Modules </th>
                                                        <th class="fs-14">Email</th>
                                                        <th class="fs-14">SMS</th>
                                                        <th class="fs-14">In App</th>
                                                        <th class="fs-14">Whatsapp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">New Invoice Created</h6>
                                                            <p class="fs-12">Alert when a new invoice is generated.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">Invoice Due Reminder</h6>
                                                            <p class="fs-12">Notification before the invoice due date</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="card-title-head d-flex align-items-center justify-content-between">
                                            <h6 class="fs-16 fw-semibold mb-3 d-flex align-items-center">
												<span class="fs-16 me-2 p-1 rounded bg-dark text-white d-inline-flex align-items-center justify-content-center"><i class="isax isax-user-tag"></i></span> 
												User Management
											</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="table-responsive table-nowrap mb-0 notification-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="fs-14">Modules </th>
                                                        <th class="fs-14">Email</th>
                                                        <th class="fs-14">SMS</th>
                                                        <th class="fs-14">In App</th>
                                                        <th class="fs-14">Whatsapp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">New User Added</h6>
                                                            <p class="fs-12">Notify when a new user is registered.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">User Feedback</h6>
                                                            <p class="fs-12">Alerts for received feedback or reviews.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">Role & Permission Changes</h6>
                                                            <p class="fs-12">Notify when user roles are updated</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-13 fw-medium mb-1">Direct Messages & Mentions</h6>
                                                            <p class="fs-12">Get alerts when you are tagged or messaged.</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input" type="checkbox" checked>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-0">
                                        <button type="button" class="btn btn-outline-white me-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div><!-- end col  -->
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
