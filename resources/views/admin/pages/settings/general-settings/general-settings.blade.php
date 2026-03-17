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
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Captcha Settings</h6>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success mb-4">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Domain Status Alert -->
                                <div
                                    class="mb-4 p-3 rounded {{ $is_active ? 'bg-success-subtle border border-success' : 'bg-danger-subtle border border-danger' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5
                                                class="fw-bold {{ $is_active ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                                                Captcha Status: {{ $is_active ? 'ACTIVE' : 'INACTIVE' }}
                                            </h5>
                                            <p
                                                class="small mt-1 {{ $is_active ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                                                Current Domain: <strong>{{ $current_domain }}</strong><br>
                                                Allowed Domain: <strong>{{ $allowed_domain ?? 'Not set' }}</strong>
                                            </p>
                                        </div>
                                        <button type="button" onclick="checkDomain()" class="btn btn-primary btn-sm">
                                            Check Domain
                                        </button>
                                    </div>
                                </div>

                                <form action="{{ route('general-settings.update') }}" method="POST"
                                    class="bg-white p-4 shadow-sm">
                                    @csrf

                                    <!-- Captcha Provider Selection -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Captcha Provider</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="provider"
                                                    id="provider_google" value="google"
                                                    onchange="toggleCaptchaFields('google')"
                                                    {{ $provider == 'google' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="provider_google">
                                                    Google reCAPTCHA
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="provider"
                                                    id="provider_cloudflare" value="cloudflare"
                                                    onchange="toggleCaptchaFields('cloudflare')"
                                                    {{ $provider == 'cloudflare' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="provider_cloudflare">
                                                    Cloudflare Turnstile
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Allowed Domain -->
                                    <div class="mb-4">
                                        <label for="allowed_domain" class="form-label fw-bold">
                                            Allowed Domain <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="allowed_domain" name="allowed_domain"
                                            value="{{ old('allowed_domain', $allowed_domain) }}" placeholder="example.com">
                                        <small class="text-muted d-block mt-1">
                                            Captcha will only be active when accessing from this domain.<br>
                                            Current domain: <strong>{{ $current_domain }}</strong>
                                        </small>
                                    </div>

                                    <!-- Google Fields -->
                                    <div id="google-fields" class="mb-4 p-3 border rounded bg-light"
                                        style="display: {{ $provider == 'google' ? 'block' : 'none' }};">
                                        <h6 class="fw-bold text-dark mb-3">Google reCAPTCHA Keys</h6>
                                        <div class="mb-3">
                                            <label for="google_recaptcha_site_key" class="form-label small text-muted">Site
                                                Key</label>
                                            <input type="text" class="form-control" id="google_recaptcha_site_key"
                                                name="google_recaptcha_site_key"
                                                value="{{ old('google_recaptcha_site_key', $google_recaptcha_site_key) }}">
                                        </div>
                                        <div>
                                            <label for="google_recaptcha_secret" class="form-label small text-muted">Secret
                                                Key</label>
                                            <input type="text" class="form-control" id="google_recaptcha_secret"
                                                name="google_recaptcha_secret"
                                                value="{{ old('google_recaptcha_secret', $google_recaptcha_secret) }}">
                                        </div>
                                    </div>

                                    <!-- Cloudflare Fields -->
                                    <div id="cloudflare-fields" class="mb-4 p-3 border rounded bg-light"
                                        style="display: {{ $provider == 'cloudflare' ? 'block' : 'none' }};">
                                        <h6 class="fw-bold text-dark mb-3">Cloudflare Turnstile Keys</h6>
                                        <div class="mb-3">
                                            <label for="cloudflare_site_key" class="form-label small text-muted">Site
                                                Key</label>
                                            <input type="text" class="form-control" id="cloudflare_site_key"
                                                name="cloudflare_site_key"
                                                value="{{ old('cloudflare_site_key', $cloudflare_site_key) }}">
                                        </div>
                                        <div>
                                            <label for="cloudflare_secret" class="form-label small text-muted">Secret
                                                Key</label>
                                            <input type="text" class="form-control" id="cloudflare_secret"
                                                name="cloudflare_secret"
                                                value="{{ old('cloudflare_secret', $cloudflare_secret) }}">
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Save Settings
                                        </button>
                                        <button type="button" onclick="checkDomain()" class="btn btn-secondary">
                                            Re-check Domain
                                        </button>
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
