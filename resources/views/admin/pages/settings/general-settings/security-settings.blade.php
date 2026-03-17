@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
<div class="content">
<div class="row justify-content-center">
<div class="col-xl-12">
<div class="row settings-wrapper d-flex">

<!-- Sidebar -->
<div class="col-xl-3 col-lg-4">
    @include('admin.components.settings-sidebar')
</div>

<!-- Main Content -->
<div class="col-xl-9 col-lg-8">
<div class="mb-3">
    <div class="pb-3 border-bottom mb-3">
        <h6 class="mb-0">Security</h6>
    </div>

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


    <!-- Password -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-lock-circle text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Password</h5>
                <p class="fs-14">Set a unique password to secure the account</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge badge-md badge-soft-danger me-3">
                Last Changed, {{ $user->password_changed_at?->format('M d, Y') ?? 'Never' }}
            </span>
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#change_password">
                <span class="badge badge-soft-light text-dark"><i class="isax isax-edit"></i></span>
            </a>
        </div>
    </div>

    <!-- 2FA -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-security-safe text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Two Factor Authentication</h5>
                <p class="fs-14">Use your mobile phone to receive security PIN.</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
    <form action="{{ route('security-settings.update') }}" method="POST">
        @csrf
         <div class="d-flex align-items-center justify-content-between">
          <span class="badge badge-md badge-soft-danger d-flex align-items-center  me-5">
            {{ $settings->is_2fa_enabled ? 'Enabled' : 'Disabled' }}, 
            {{ \Carbon\Carbon::parse($settings->updated_at)->format('M d, Y') }}
        </span>
        <label class="form-switch ps-3">
            <!-- Hidden input sends 0 when checkbox is unchecked -->
            <input type="hidden" name="is_2fa_enabled" value="0">
            <input class="form-check-input" type="checkbox" name="is_2fa_enabled" value="1" 
                   {{ $settings->is_2fa_enabled ? 'checked' : '' }} onchange="this.form.submit()">
        </label>
        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#two-factor">
            <span class="badge badge-soft-light text-dark"><i class="isax isax-setting-2"></i></span>
        </a>
         </div>
       
    </form>
</div>
    </div>

    <!-- Google Auth -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2">
                <img src="{{ asset('assets/img/icons/google-icon.svg') }}" class="w-75" alt="google">
            </span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Google Authentication</h5>
                <p class="fs-14">Connect to Google</p>
            </div>
        </div>
       <div class="d-flex align-items-center">
    <form action="{{ route('security-settings.update') }}" method="POST">
        @csrf
        <div class="d-flex align-items-center justify-content-between">
         <span class="badge badge-outline-light text-dark border  d-flex align-items-center  me-5">
            <i class="fa fa-circle text-success fs-8 me-1"></i>
            {{ $settings->is_google_enabled ? 'Connected' : 'Not Connected' }}
        </span>
        <label class="d-flex align-items-center form-switch ps-3">
            <!-- Hidden input sends 0 when checkbox is unchecked -->
            <input type="hidden" name="is_google_enabled" value="0">
            <input class="form-check-input" type="checkbox" name="is_google_enabled" value="1"
                   {{ $settings->is_google_enabled ? 'checked' : '' }} onchange="this.form.submit()">
        </label>
        </div>
       
    </form>
</div>
    </div>

    <!-- Phone -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-call text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Phone Number Verification</h5>
                <p class="fs-14">Phone Number associated with the account</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge badge-md badge-soft-success me-3">
                {{ $settings->phone_verified_at ? 'Verified' : 'Not Verified' }}
                <i class="isax isax-tick-circle ms-1"></i>
            </span>
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#phone_verification" class="me-3">
                <span class="badge badge-soft-light text-dark"><i class="isax isax-edit"></i></span>
            </a>
            @if($settings->phone_number)
            <form action="{{ route('security-settings.phone.remove') }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this phone number?')">
                @csrf @method('DELETE')
                <button type="submit" class="badge badge-soft-light text-dark border-0"><i class="isax isax-trash"></i></button>
            </form>
            @endif
        </div>
    </div>

    <!-- Email -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-sms-tracking text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Email Verification</h5>
                <p class="fs-14">Email Address associated with the account</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge badge-md badge-soft-success me-3">
                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                <i class="isax isax-tick-circle ms-1"></i>
            </span>
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#email_verification" class="me-3">
                <span class="badge badge-soft-light text-dark"><i class="isax isax-edit"></i></span>
            </a>
        </div>
    </div>

    <!-- Devices -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-device-message text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Browsers & Devices</h5>
                <p class="fs-14">The browsers & devices associated with the account</p>
            </div>
        </div>
        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_device">
            <span class="badge badge-soft-light text-dark"><i class="isax isax-eye"></i></span>
        </a>
    </div>

   <!-- Deactivate Account -->
<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 border-bottom mb-3 pb-3">
    <div class="d-flex align-items-center">
        <span class="avatar avatar-lg border bg-light me-2">
            <i class="isax isax-close-circle text-dark fs-24"></i>
        </span>
        <div>
            <h5 class="fs-16 fw-semibold mb-1">Deactivate Account</h5>
            <p class="fs-14">This will shutdown your account. Your account will be reactive when you sign in again</p>
        </div>
    </div>
    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deactivate_modal">
        <span class="badge badge-soft-light text-dark d-inline-flex align-items-center">
            <i class="isax isax-slash"></i>
        </span>
    </a>
</div>
    <!-- Delete -->
    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="d-flex align-items-center">
            <span class="avatar avatar-lg border bg-light me-2"><i class="isax isax-info-circle text-dark fs-24"></i></span>
            <div>
                <h5 class="fs-16 fw-semibold mb-1">Delete Account</h5>
                <p class="fs-14">Your account will be permanently deleted</p>
            </div>
        </div>
        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal">
            <span class="badge badge-soft-light text-dark"><i class="isax isax-trash"></i></span>
        </a>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- ============ MODALS (Simplified) ============ -->

<!-- Change Password Modal -->
<div id="change_password" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('security-settings.password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password *</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password *</label>
                        <input type="password" name="new_password" class="form-control" id="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Phone Verification Modal -->
<div id="phone_verification" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Phone Number</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('security-settings.phone') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Phone</label>
                        <input type="text" class="form-control" value="{{ $settings->phone_number }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Phone Number *</label>
                        <input type="text" name="phone_number" class="form-control" placeholder="+1 234 567 8900" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Password *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Verification Modal -->
<div id="email_verification" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Email Address</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('security-settings.email') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="new@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Password *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Two Factor Modal -->
<div id="two-factor" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SMS Two Factor Authentication</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('security-settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="is_2fa_enabled" value="1">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Phone Number *</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ $settings->phone_number }}" placeholder="+1 234 567 8900" required>
                    </div>
                    <p class="text-muted small">By providing your phone number, you agree to receive text messages for two-factor authentication.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Verify & Enable</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Devices Modal (Server-Rendered, No AJAX) -->
<div id="view_device" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Browsers & Devices</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Device</th><th>Date</th><th>IP Address</th><th>Location</th><th></th></tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                            <tr>
                                <td class="text-dark">
                                    <i class="isax isax-monitor me-1"></i>
                                    {{ $device->browser_name ?? 'Unknown' }} - {{ parseOS($device->user_agent) }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($device->last_active ?? $device->created_at)->format('d M Y, h:i A') }}</td>
                                <td>{{ $device->ip_address }}</td>
                                <td>Unknown</td>
                                <td>
                                    @if($device->id != session('current_device_id'))
                                    <form action="{{ route('security-settings.device.delete', $device->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Logout?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="badge badge-soft-light text-dark border-0"><i class="isax isax-logout"></i></button>
                                    </form>
                                    @else
                                    <span class="badge badge-soft-primary">Current</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No devices found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="delete_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('security-settings.delete') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">Why are you deleting your account?</p>
                    <div class="mb-3">
                        <textarea name="delete_reason" class="form-control" rows="3" placeholder="Optional reason..." required></textarea>
                    </div>
                    <div class="p-3 bg-danger bg-opacity-10 rounded mb-3">
                        <p class="text-danger small mb-0"><i class="isax isax-warning-circle me-1"></i>Warning: This cannot be undone.</p>
                    </div>
                    <div>
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="confirmation_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm & Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Start Deactivate Account Modal -->
<div id="deactivate_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger">Deactivate Account</h4>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <form action="{{ route('security-settings.deactivate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Warning Box -->
                    <div class="p-3 bg-warning bg-opacity-10 rounded border border-warning mb-4">
                        <p class="text-warning fw-semibold mb-1 fs-14">
                            <i class="isax isax-warning-circle me-1"></i>
                            Account Deactivation
                        </p>
                        <p class="text-muted small mb-0">
                            Your account will be temporarily disabled. You can reactivate it anytime by signing in again.
                        </p>
                    </div>

                    <!-- Reason Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Why are you deactivating?</label>
                        <select name="deactivate_reason" class="select" required>
                            <option value="" selected disabled>Select a reason...</option>
                            <option value="taking_break">Taking a break</option>
                            <option value="privacy">Privacy concerns</option>
                            <option value="too_many_emails">Too many notifications</option>
                            <option value="found_alternative">Found an alternative</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Optional Note -->
                    <div class="mb-3">
                        <label class="form-label">Additional Feedback (Optional)</label>
                        <textarea name="deactivate_note" class="form-control" rows="3" placeholder="Help us improve..."></textarea>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="pass-group input-group">
                            <span class="input-group-text border-end-0">
                                <i class="isax isax-lock"></i>
                            </span>
                            {{-- <span class="isax toggle-password-deactivate isax-eye-slash cursor-pointer"></span> --}}
                            <input type="password" name="confirmation_password" class="form-control border-start-0 ps-0" placeholder="Enter your password" required>
                        </div>
                        @error('confirmation_password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="deactivate-confirm-btn">
                        <i class="isax isax-slash me-1"></i>Deactivate Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / End Deactivate Account Modal -->

@endsection
