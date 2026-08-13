@extends('admin.layout.master')
@section('content')
    <!-- ========================
       Start Page Content
      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

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
                            <div class="mb-3">
                                <div class="pb-3 border-bottom mb-3">
                                    <h6 class="mb-0">Account Settings</h6>
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

                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0">
                                        <i class="isax isax-info-circle fs-14"></i>
                                    </span>
                                    <h6 class="fs-16 fw-semibold mb-0">General Information</h6>
                                </div>

                                <form action="{{ route('account-settings.update') }}" method="POST"
                                    enctype="multipart/form-data" id="accountSettingsForm">
                                    @csrf
                                    @method('PUT')

                                    {{-- Profile Image --}}
                                    <div class="mb-3">
                                        <span class="text-gray-9 fw-bold mb-2 d-flex">
                                            Profile Image<span class="text-danger ms-1">*</span>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0">
                                                <div class="position-relative d-flex align-items-center">
                                                    <img src="{{ tenant_storage_url($accountSetting?->profile_image) ?? asset('assets/img/users/user-01.jpg') }}"
                                                        class="avatar avatar-xl" alt="User Profile" id="profilePreview">
                                                    @if ($accountSetting?->profile_image)
                                                        <a href="javascript:void(0);"
                                                            class="rounded-trash trash-top d-flex align-items-center justify-content-center"
                                                            onclick="confirmDeleteImage()">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="isax isax-image me-1"></i>Upload Image
                                                    <input type="file" name="profile_image"
                                                        class="form-control image-sign position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                                        accept="image/png, image/jpeg, image/jpg"
                                                        onchange="previewImage(this)">
                                                </div>
                                                <span class="text-gray-9 fs-12">JPG or PNG format, not exceeding 5MB.</span>
                                                @error('profile_image')
                                                    <span class="text-danger fs-12">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="row gx-3">
                                            {{-- Name --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $accountSetting?->name ?? Auth::user()?->name) }}"
                                                        required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Email --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email', $accountSetting?->email ?? Auth::user()?->email) }}"
                                                        required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Mobile --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Mobile Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="mobile_number"
                                                        class="form-control @error('mobile_number') is-invalid @enderror"
                                                        value="{{ old('mobile_number', $accountSetting?->mobile_number) }}"
                                                        placeholder="e.g., +91 9876543210">
                                                    @error('mobile_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Gender --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Gender</label>
                                                    <select name="gender"
                                                        class="select @error('gender') is-invalid @enderror">
                                                        <option value="">Select</option>
                                                        <option value="male"
                                                            {{ old('gender', $accountSetting?->gender) == 'male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="female"
                                                            {{ old('gender', $accountSetting?->gender) == 'female' ? 'selected' : '' }}>
                                                            Female</option>
                                                        <option value="other"
                                                            {{ old('gender', $accountSetting?->gender) == 'other' ? 'selected' : '' }}>
                                                            Other</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- DOB --}}
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Date of Birth</label>
                                                    <div class="input-group position-relative mb-3">
                                                        <input type="date" name="dob"
                                                            class="form-control rounded-end @error('dob') is-invalid @enderror"
                                                            value="{{ old('dob', $accountSetting?->dob?->format('Y-m-d')) }}">
                                                        <span class="input-icon-addon fs-16 text-gray-9">
                                                            <i class="isax isax-calendar-2"></i>
                                                        </span>
                                                    </div>
                                                    @error('dob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Address Section --}}
                                    <div class="border-bottom mb-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="bg-dark avatar avatar-sm me-2 flex-shrink-0">
                                                <i class="isax isax-info-circle fs-14"></i>
                                            </span>
                                            <h6 class="fs-16 fw-semibold mb-0">Address Information</h6>
                                        </div>

                                        <div class="row gx-3">
                                            {{-- Address --}}
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $accountSetting?->address) }}</textarea>
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- State --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">State</label>
                                                    <select name="state_id"
                                                        class="select @error('state_id') is-invalid @enderror"
                                                        id="stateSelect"
                                                        data-cities-url="{{ route('account-settings.cities', ['stateId' => ':id']) }}">
                                                        <option value="">Select State</option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id', $accountSetting?->state_id) == $state->id ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('state_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- City --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">City <span
                                                            class="text-danger ms-1">*</span></label>
                                                    <select name="city_id"
                                                        class="select @error('city_id') is-invalid @enderror"
                                                        id="citySelect">
                                                        <option value="">Select City</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                {{ old('city_id', $accountSetting?->city_id) == $city->id ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('city_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Postal Code --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Postal Code <span
                                                            class="text-danger ms-1">*</span></label>
                                                    <input type="text" name="postal_code"
                                                        class="form-control @error('postal_code') is-invalid @enderror"
                                                        value="{{ old('postal_code', $accountSetting?->postal_code) }}"
                                                        placeholder="e.g., 144001">
                                                    @error('postal_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-outline-white"
                                            onclick="window.history.back()">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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

    <!-- Hidden form for image deletion -->
    <form id="delete-image-form" method="POST" action="{{ route('account-settings.image.delete') }}" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <!-- ========================
       End Page Content
      ========================= -->
@endsection

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .trash-top {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            background: #dc3545;
            border-radius: 50%;
            color: white;
            font-size: 12px;
        }

        .trash-top:hover {
            background: #c82333;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {


            // Load cities on page load if state is already selected (edit mode)
            const initialState = @json(old('state_id', $accountSetting?->state_id));
            const initialCity = @json(old('city_id', $accountSetting?->city_id));

            if (initialState) {
                loadCities(initialState, initialCity);
            }

            // State change handler
            $('#stateSelect').on('change', function() {
                let stateId = $(this).val();
                let selectedCity = initialCity;

                if (stateId) {
                    loadCities(stateId, selectedCity);
                } else {
                    $('#citySelect').html('<option value="">Select City</option>');
                    if ($.fn.select2) {
                        $('#citySelect').trigger('change');
                    }
                }
            });

            // Reusable function to load cities via AJAX
            function loadCities(stateId, selectedCityId = null) {
                let citySelect = $('#citySelect');
                let baseUrl = $('#stateSelect').data('cities-url');
                let url = baseUrl.replace(':id', stateId);

                citySelect.html('<option value="">Loading...</option>');
                if ($.fn.select2) {
                    citySelect.trigger('change');
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        citySelect.empty().append('<option value="">Select City</option>');

                        $.each(data, function(key, city) {
                            let selected = (city.id == selectedCityId) ? 'selected' : '';
                            citySelect.append(
                                `<option value="${city.id}" ${selected}>${city.name}</option>`
                            );
                        });

                        if ($.fn.select2) {
                            citySelect.trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        citySelect.html('<option value="">Error loading cities</option>');
                        if ($.fn.select2) {
                            citySelect.trigger('change');
                        }
                    }
                });
            }
        });

        // Preview uploaded image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profilePreview');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Confirm and delete profile image
        function confirmDeleteImage() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Red color for delete
                cancelButtonColor: '#6c757d', // Grey color for cancel
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if user clicks "Yes"
                    document.getElementById('delete-image-form').submit();
                }
            });
        }
    </script>
@endpush
