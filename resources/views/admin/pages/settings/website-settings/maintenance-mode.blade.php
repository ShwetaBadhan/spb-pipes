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
                          
                        </div><!-- end col -->

                        <!-- End settings sidebar -->

                        <div class="col-xl-9 col-lg-8">
    <div class="mb-3 pb-3 border-bottom">
        <h6 class="fw-bold mb-0">Maintenance Mode</h6>
    </div>

   

    <!-- Updated Form Action & Method -->
    <form action="{{ route('maintenance-mode.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Image <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center flex-wrap row-gap-3 mb-3">
                <div class="d-flex align-items-center bg-light justify-content-center avatar avatar-xxl border me-3 flex-shrink-0 text-dark frames">
                    @if($setting?->image_path)
                        <img src="{{ $setting->image_url }}" alt="Maintenance Image" class="img-fluid rounded" style="max-height: 100px;">
                    @else
                        <i class="isax isax-image text-gray-4 fs-12"></i>
                    @endif
                </div>
                <div class="profile-upload">
                    <div class="profile-uploader d-flex align-items-center">
                        <div class="drag-upload-btn btn btn-md btn-primary">
                            <i class="isax isax-image fs-14 me-1"></i> Upload Image
                            <input type="file" name="image" class="form-control image-sign" accept="image/*">
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="fs-12">JPG or PNG format, not exceeding 5MB.</p>
                        @if($setting?->image_path)
                            <p class="fs-12 text-muted mb-0">Current: {{ basename($setting->image_path) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @error('image')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description <span class="text-danger ms-1">*</span></label>
            <!-- Use a textarea or your rich editor with name="meta_description" -->
            <textarea name="meta_description" class="form-control editor" rows="5" required>{{ old('meta_description', $setting?->meta_description) }}</textarea>
            @error('meta_description')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-check form-check-sm form-switch me-2">
            <label class="form-check-label form-label mt-0 mb-0 fw-normal">
                <input class="form-check-input form-label me-2" type="checkbox" name="is_active" role="switch" 
                    {{ old('is_active', $setting?->is_active ?? true) ? 'checked' : '' }}> 
                Status
            </label>
        </div>

        <div class="pt-4 mt-4 border-top mb-3">
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-outline-white me-3">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
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
