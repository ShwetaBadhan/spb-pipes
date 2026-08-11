@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @if (session('success'))
                <script>
                    Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 4000, timerProgressBar: true, showConfirmButton: false });
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}', timer: 4000, timerProgressBar: true, showConfirmButton: false });
                </script>
            @endif
            @if (isset($errors) && $errors->any())
                <script>
                    Swal.fire({ icon: 'error', title: 'Error!', text: '{{ $errors->first() }}', timer: 4000, timerProgressBar: true, showConfirmButton: false });
                </script>
            @endif

            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="card settings-card">
                                <div class="card-header">
                                    <h6 class="mb-0">Branding</h6>
                                </div>
                                <div class="card-body">
                                    @if (! $hasWhiteLabel)
                                        <div class="alert alert-warning">
                                            White-label branding is not available on your current plan.
                                            <a href="{{ route('tenant.billing') }}">Upgrade your plan</a> to upload your
                                            own logo and set a brand color.
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('tenant.branding.update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Company Logo</label>
                                            <input type="file" name="logo" class="form-control" accept="image/*" {{ $hasWhiteLabel ? '' : 'disabled' }}>
                                            @if ($tenant->logo_path)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/'.$tenant->logo_path) }}" alt="Logo"
                                                        style="max-height: 56px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 4px;">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Primary Color</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="color" name="primary_color" class="form-control form-control-color"
                                                    value="{{ $tenant->primary_color ?? '#012d80' }}" style="width: 64px; height: 38px;" {{ $hasWhiteLabel ? '' : 'disabled' }}>
                                                <input type="text" name="primary_color_hex" class="form-control"
                                                    style="max-width: 140px;" value="{{ $tenant->primary_color ?? '#012d80' }}" readonly>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary" {{ $hasWhiteLabel ? '' : 'disabled' }}>
                                            Save Branding
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colorInput = document.querySelector('input[type=color]');
        const hexInput = document.querySelector('input[name=primary_color_hex]');
        if (colorInput) {
            colorInput.addEventListener('input', function () {
                hexInput.value = this.value;
            });
        }
    </script>
@endsection
