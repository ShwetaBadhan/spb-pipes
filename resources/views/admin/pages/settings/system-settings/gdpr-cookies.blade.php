@extends('admin.layout.master')

@section('page-title', 'GDPR Cookies')

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
                        <div class="mb-3">
                            <div class="pb-3 d-flex align-items-center justify-content-between border-bottom mb-3">
                                <h6 class="mb-0">GDPR Cookies</h6>
                                {{-- Toggle Switch for Active/Inactive --}}
                                <form action="{{ route('gdpr-cookies.toggle') }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               name="is_active" value="1" {{ $gdprSettings->is_active ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label ms-2">
                                            {{ $gdprSettings->is_active ? 'Enabled' : 'Disabled' }}
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <form action="{{ route('gdpr-cookies.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    {{-- Cookie Position --}}
                                    <div class="row mb-3 align-items-center justify-content-between">
                                        <div class="col-xl-4 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Cookies Position <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div>
                                                <select name="cookie_position" class="select @error('cookie_position') is-invalid @enderror" required>
                                                    <option value="">Select Position</option>
                                                    <option value="right" {{ old('cookie_position', $gdprSettings->cookie_position) == 'right' ? 'selected' : '' }}>Right</option>
                                                    <option value="left" {{ old('cookie_position', $gdprSettings->cookie_position) == 'left' ? 'selected' : '' }}>Left</option>
                                                    <option value="bottom" {{ old('cookie_position', $gdprSettings->cookie_position) == 'bottom' ? 'selected' : '' }}>Bottom</option>
                                                    <option value="top" {{ old('cookie_position', $gdprSettings->cookie_position) == 'top' ? 'selected' : '' }}>Top</option>
                                                </select>
                                                @error('cookie_position')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Agree Button Text --}}
                                    <div class="row mb-3 align-items-center justify-content-between">
                                        <div class="col-xl-4 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Agree Button Text <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div>
                                                <input type="text" name="agree_button_text" class="form-control @error('agree_button_text') is-invalid @enderror" 
                                                       value="{{ old('agree_button_text', $gdprSettings->agree_button_text) }}" required>
                                                @error('agree_button_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Decline Button Text --}}
                                    <div class="row mb-3 align-items-center justify-content-between">
                                        <div class="col-xl-4 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Decline Button Text <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div>
                                                <input type="text" name="decline_button_text" class="form-control @error('decline_button_text') is-invalid @enderror" 
                                                       value="{{ old('decline_button_text', $gdprSettings->decline_button_text) }}">
                                                @error('decline_button_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Show Decline Button --}}
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-9 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Show Decline Button <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check form-check-sm form-switch text-end">
                                                <label class="form-check-label form-label m-0">
                                                    <input class="form-check-input form-label" type="checkbox" 
                                                           name="show_decline_button" value="1" role="switch"
                                                           {{ old('show_decline_button', $gdprSettings->show_decline_button) ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Cookie Content Text --}}
                                    <div class="row mb-3">
                                        <div class="col-xl-4 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Cookies Content Text <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div>
                                                <textarea name="cookie_content" class="form-control summernote @error('cookie_content') is-invalid @enderror" 
                                                          rows="5">{{ old('cookie_content', $gdprSettings->cookie_content) }}</textarea>
                                                @error('cookie_content')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Links for Cookies Page --}}
                                    <div class="row align-items-center">
                                        <div class="col-xl-4 d-flex">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label">Links for Cookies Page <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div>
                                                <input type="url" name="cookies_page_link" class="form-control @error('cookies_page_link') is-invalid @enderror" 
                                                       value="{{ old('cookies_page_link', $gdprSettings->cookies_page_link) }}" 
                                                       placeholder="https://yourdomain.com/privacy-policy">
                                                @error('cookies_page_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Link to your privacy/cookies policy page</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-4">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection