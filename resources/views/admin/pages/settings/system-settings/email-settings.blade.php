@extends('admin.layout.master')

@section('page-title', 'Email Settings')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            {{-- Messages --}}
            <!-- end row -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    let errorMessages = [];
                    @foreach ($errors->all() as $error)
                        errorMessages.push("{{ $error }}");
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessages.join('<br>'),
                        timer: 6000,
                        timerProgressBar: true,
                        showConfirmButton: true
                    });
                </script>
            @endif

            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div>
                                <div class="pb-3 d-flex align-items-center justify-content-between border-bottom mb-3">
                                    <h6 class="mb-0">Email Settings</h6>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#send_test_email">
                                        <i class="isax isax-send-25 me-1"></i>Send Test Email
                                    </button>
                                </div>

                                <div class="mb-0">
                                    <div class="row">
                                        @forelse($emailSettings as $setting)
                                            <div class="col-md-6 d-flex">
                                                <div class="card flex-fill">
                                                    <div class="card-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="avatar avatar-lg bg-light me-2 p-2 flex-shrink-0">
                                                                    <img src="{{ asset($setting->logo) }}" class="img-fluid"
                                                                        alt="{{ $setting->name }}">
                                                                </span>
                                                                <p class="text-gray-9 fw-medium">{{ $setting->name }}</p>
                                                            </div>
                                                            <span
                                                                class="badge badge-soft-{{ $setting->is_connected ? 'success' : 'primary' }} d-flex align-items-center">
                                                                <span
                                                                    class="badge-dot bg-{{ $setting->is_connected ? 'success' : 'dark' }} me-1"></span>
                                                                {{ $setting->is_connected ? 'Connected' : 'Not Connected' }}
                                                            </span>
                                                        </div>
                                                        <p class="fs-13">{{ $setting->description }}</p>
                                                    </div>
                                                    <div class="card-footer bg-light">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                {{-- Delete Button (Only for custom providers) --}}
                                                                @if (!in_array($setting->provider, ['php_mailer', 'smtp', 'sendgrid']))
                                                                    <form
                                                                        action="{{ route('email-settings.destroy', $setting->id) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Delete this email provider?')">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1 me-2">
                                                                            <i class="isax isax-trash fs-14"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif

                                                                {{-- Edit Button --}}
                                                                <button type="button"
                                                                    class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1 me-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit_email_{{ $setting->provider }}">
                                                                    <i class="isax isax-setting-2 fs-14"></i>
                                                                </button>
                                                            </div>
                                                            {{-- Toggle Switch --}}
                                                            <form
                                                                action="{{ route('email-settings.toggle', $setting->id) }}"
                                                                method="POST">
                                                                @csrf @method('PATCH')
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input ms-0" type="checkbox"
                                                                        role="switch" name="is_active" value="1"
                                                                        {{ $setting->is_active ? 'checked' : '' }}
                                                                        onchange="this.form.submit()"
                                                                        {{ !$setting->is_connected ? 'disabled title="Configure first"' : '' }}>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Edit Modal (Per Provider) --}}
                                            <div id="edit_email_{{ $setting->provider }}" class="modal fade">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{ $setting->name }} Settings</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('email-settings.update', $setting->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <div class="modal-body">
                                                                {{-- Dynamic fields based on provider --}}
                                                                @if (in_array($setting->provider, ['php_mailer', 'smtp']))
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Mail Host <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    name="config[mail_host]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.mail_host', $setting->getConfigValue('mail_host')) }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Mail Port <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="number"
                                                                                    name="config[mail_port]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.mail_port', $setting->getConfigValue('mail_port')) }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Username</label>
                                                                                <input type="text"
                                                                                    name="config[mail_username]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.mail_username', $setting->getConfigValue('mail_username')) }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Password</label>
                                                                                <input type="password"
                                                                                    name="config[mail_password]"
                                                                                    class="form-control"
                                                                                    placeholder="Enter new password (leave blank to keep current)">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Encryption</label>
                                                                                <select name="config[mail_encryption]"
                                                                                    class="form-select">
                                                                                    <option value="tls"
                                                                                        {{ $setting->getConfigValue('mail_encryption') == 'tls' ? 'selected' : '' }}>
                                                                                        TLS</option>
                                                                                    <option value="ssl"
                                                                                        {{ $setting->getConfigValue('mail_encryption') == 'ssl' ? 'selected' : '' }}>
                                                                                        SSL</option>
                                                                                    <option value=""
                                                                                        {{ !$setting->getConfigValue('mail_encryption') ? 'selected' : '' }}>
                                                                                        None</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">From
                                                                                    Email</label>
                                                                                <input type="email"
                                                                                    name="config[mail_from_address]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.mail_from_address', $setting->getConfigValue('mail_from_address')) }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">From Name</label>
                                                                                <input type="text"
                                                                                    name="config[mail_from_name]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.mail_from_name', $setting->getConfigValue('mail_from_name')) }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @elseif($setting->provider == 'sendgrid')
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">API Key <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="password"
                                                                                    name="config[api_key]"
                                                                                    class="form-control"
                                                                                    placeholder="Enter new API key (leave blank to keep current)">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">From Email <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="email"
                                                                                    name="config[from_email]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.from_email', $setting->getConfigValue('from_email')) }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">From Name</label>
                                                                                <input type="text"
                                                                                    name="config[from_name]"
                                                                                    class="form-control"
                                                                                    value="{{ old('config.from_name', $setting->getConfigValue('from_name')) }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="form-check form-switch mt-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="is_active" value="1"
                                                                        {{ old('is_active', $setting->is_active) ? 'checked' : '' }}
                                                                        {{ !$setting->is_connected ? 'disabled' : '' }}>
                                                                    <label class="form-check-label">Enable
                                                                        {{ $setting->name }}</label>
                                                                </div>
                                                                @if (!$setting->is_connected)
                                                                    <small class="text-muted d-block mt-1">Configure all
                                                                        required fields to enable</small>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    Settings</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center py-5">
                                                <p class="text-muted">No email providers configured.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Send Test Email Modal --}}
    <div id="send_test_email" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Test Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" id="test_email_form" method="POST">
                    @csrf
                    <input type="hidden" name="provider_id" id="test_provider_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Email Provider</label>
                            <select name="provider" id="test_provider_select" class="form-select" required
                                onchange="updateTestFormAction()">
                                <option value="">-- Select Provider --</option>
                                @foreach ($emailSettings->where('is_connected', true) as $setting)
                                    <option value="{{ $setting->id }}">{{ $setting->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Email <span class="text-danger">*</span></label>
                            <input type="email" name="to_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control"
                                value="Test Email from {{ config('app.name') }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="4">This is a test email to verify your email configuration.</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Test Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateTestFormAction() {
            const providerId = document.getElementById('test_provider_select').value;
            const form = document.getElementById('test_email_form');
            if (providerId) {
                form.action = `/email-settings/${providerId}/send-test`;
            } else {
                form.action = '';
            }
        }
    </script>
@endsection
