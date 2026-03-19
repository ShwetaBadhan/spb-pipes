@extends('admin.layout.master')

@section('page-title', 'Payment Methods')

@section('content')
    <div class="page-wrapper">
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

            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row settings-wrapper d-flex">
                        <div class="col-xl-3 col-lg-4">
                            @include('admin.components.settings-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-8">
                            <div class="mb-0">
                                <div class="pb-3 border-bottom mb-3 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Payment Methods</h6>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#add_payment_method">
                                        <i class="isax isax-add me-1"></i> Add New
                                    </button>
                                </div>

                                <div class="card-body">
                                    <div class="row align-items-center saas-settings">
                                        @forelse($paymentMethods as $method)
                                            <div class="col-md-6">
                                                <div class="card shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <span>
                                                                @if ($method->logo)
                                                                    <img src="{{ Storage::url($method->logo) }}"
                                                                        alt="{{ $method->name }}" style="max-width: 100px;">
                                                                @else
                                                                    <img src="{{ asset('assets/img/icons/paypal-name.svg') }}"
                                                                        alt="{{ $method->name }}">
                                                                @endif
                                                            </span>
                                                            <span
                                                                class="badge badge-soft-{{ $method->is_connected ? 'success' : 'primary' }} d-inline-flex align-items-center ms-2">
                                                                <span
                                                                    class="badge-dot bg-{{ $method->is_connected ? 'success' : 'dark' }} me-1"></span>
                                                                {{ $method->is_connected ? 'Connected' : 'Not Connected' }}
                                                            </span>
                                                        </div>
                                                        <p class="text-truncate line-clamb-2">
                                                            {{ $method->name }} payment gateway integration
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="card-footer bg-light d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            @if (
                                                                $method->slug !== 'paypal' &&
                                                                    $method->slug !== 'stripe' &&
                                                                    $method->slug !== 'razorpay' &&
                                                                    $method->slug !== 'applepay')
                                                                <button href="javascript:void(0);"
                                                                    class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete_modal{{ $method->id }}">
                                                                    <i class="isax isax-trash me-2"></i></button>

                                                                &nbsp;
                                                            @endif

                                                            <button
                                                                class="btn btn-sm btn-dark rounded-2 d-inline-flex align-items-center justify-content-center p-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit_payment_{{ $method->id }}">
                                                                <i class="isax isax-setting-2"></i>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('payment-methods.toggle', $method->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input m-0" type="checkbox"
                                                                    {{ $method->is_active ? 'checked' : '' }}
                                                                    onchange="this.form.submit()">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div id="edit_payment_{{ $method->id }}" class="modal fade">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{ $method->name }}</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('payment-methods.update', $method->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                {{-- Current Logo Display --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Current Logo</label>
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="border rounded p-2"
                                                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                                            @if ($method->logo && Storage::disk('public')->exists($method->logo))
                                                                                <img src="{{ Storage::url($method->logo) }}"
                                                                                    alt="{{ $method->name }}"
                                                                                    class="img-fluid"
                                                                                    style="max-height: 60px; object-fit: contain;">
                                                                            @else
                                                                                {{-- Default icon agar logo nahi hai --}}
                                                                                <img src="{{ asset('assets/img/icons/default-payment.svg') }}"
                                                                                    alt="{{ $method->name }}"
                                                                                    class="img-fluid"
                                                                                    style="max-height: 60px;">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Upload New Logo --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Upload New Logo</label>
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="logo-preview-box border rounded p-2"
                                                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                                                            <img id="edit-logo-preview-{{ $method->id }}"
                                                                                src="#" alt="Preview"
                                                                                style="max-width: 100%; max-height: 100%; display: none;">
                                                                            <span
                                                                                id="edit-logo-placeholder-{{ $method->id }}"
                                                                                class="text-muted small">No image</span>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <input type="file" name="logo"
                                                                                class="form-control" accept="image/*"
                                                                                onchange="previewEditLogo(this, {{ $method->id }})">
                                                                            <small class="text-muted">Leave empty to keep
                                                                                current logo</small>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Email Address <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="email" name="email"
                                                                        class="form-control"
                                                                        value="{{ old('email', $method->email) }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">API Key <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="api_key"
                                                                        class="form-control"
                                                                        placeholder="Enter new API key (leave blank to keep current)">
                                                                </div>
                                                                <div class="mb-0">
                                                                    <label class="form-label">Secret Key <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="secret_key"
                                                                        class="form-control"
                                                                        placeholder="Enter new Secret key (leave blank to keep current)">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="modal-footer d-flex align-items-center justify-content-between gap-1">
                                                                <button type="button" class="btn btn-outline-white"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Start Modal  -->
                                            <div class="modal fade" id="delete_modal{{ $method->id }}">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">

                                                            <div class="mb-3">
                                                                <img src="assets/img/icons/delete.svg" alt="img">
                                                            </div>
                                                            <form
                                                                action="{{ route('payment-methods.destroy', $method->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <h6 class="mb-1">Delete Payment Method</h6>
                                                                <p class="mb-3">Are you sure, you want to delete Payment
                                                                    Method?</p>
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-outline-white me-3"
                                                                        data-bs-dismiss="modal">Cancel</a>
                                                                    <button type="submit" class="btn btn-primary">Yes,
                                                                        Delete</button>
                                                                </div>
                                                            </form>
                                                        </div> <!-- end modal-body -->
                                                    </div> <!-- end modal-content -->
                                                </div>
                                            </div>
                                            <!-- End Modal  -->
                                        @empty
                                            <div class="col-12 text-center py-5">
                                                <p class="text-muted">No payment methods configured yet.</p>
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

    <!-- Add New Payment Method Modal -->
    <!-- Add New Payment Method Modal -->
    <div id="add_payment_method" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment Method</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Payment Method Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug (unique identifier) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control" required
                                placeholder="e.g., paypal, stripe">
                        </div>

                        {{-- ✅ Logo Upload Field --}}
                        <div class="mb-3">
                            <label class="form-label">Logo <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="logo-preview-box border rounded p-2"
                                    style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                    <img id="logo-preview" src="#" alt="Preview"
                                        style="max-width: 100%; max-height: 100%; display: none;">
                                    <span id="logo-placeholder" class="text-muted small">No image</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control" accept="image/*"
                                        onchange="previewLogo(this)" required>
                                    <small class="text-muted">PNG, JPG up to 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <input type="text" name="api_key" class="form-control">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Secret Key</label>
                            <input type="text" name="secret_key" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Payment Method</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
@push('scripts')
    {{-- Logo Preview Script --}}
    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logo-preview');
                    const placeholder = document.getElementById('logo-placeholder');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewEditLogo(input, id) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`edit-logo-preview-${id}`);
                    const placeholder = document.getElementById(`edit-logo-placeholder-${id}`);
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
