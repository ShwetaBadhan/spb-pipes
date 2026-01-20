@extends('admin.layout.master')
@section('title', 'Products')
@section('content')

    <!-- ========================
                        Start Page Content
                    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- start row -->
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6><a href="{{ route('products.index') }}"><i class="isax isax-arrow-left me-2"></i>Products</a>
                            </h6>
                            <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"><i
                                    class="isax isax-eye me-1"></i>Preview</a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Basic Details</h6>
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Product Main Image -->
                                    <div class="mb-3">
                                        <span class="text-gray-9 fw-bold mb-2 d-flex">Product Image<span
                                                class="text-danger ms-1">*</span></span>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0"
                                                id="product-image-preview">
                                                <i class="isax isax-image text-primary fs-24"></i>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="isax isax-image me-1"></i>Upload Image
                                                    <input type="file" name="image_path" class="form-control image-sign" />
                                                </div>
                                                <span class="text-gray-9 fs-12">JPG or PNG format, not exceeding 5MB.</span>
                                            </div>
                                        </div>
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Start Row -->
                                    <div class="row gx-3">
                                        <!-- Product Name -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="text" name="name" class="form-control" id="product_name"
                                                    value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Product Code -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Code<span
                                                        class="text-danger ms-1">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" name="code" id="product_code"
                                                        class="form-control" value="{{ old('code') }}" readonly required>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-sm btn-dark position-absolute end-0 top-0 bottom-0 mx-2 my-1 d-inline-flex align-items-center"
                                                        onclick="generateCode()">Generate</a>
                                                    @error('code')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Category<span
                                                        class="text-danger ms-1">*</span></label>
                                                <select name="category_id" class="select form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Selling Price -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Selling Price<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="number" step="0.01" name="variants[0][selling_price]"
                                                    class="form-control" required>
                                                @error('variants.0.selling_price')
                                                    <div class="text-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Purchase Price -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Purchase Price<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="number" step="0.01" name="variants[0][purchase_price]"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Quantity<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="number" name="variants[0][quantity]" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Units -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Units<span
                                                        class="text-danger ms-1">*</span></label>
                                                <select name="unit_id" class="select form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->short_name }}"
                                                            {{ old('unit') == $unit->short_name ? 'selected' : '' }}>
                                                            {{ $unit->name }} ({{ $unit->short_name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('unit')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Alert Quantity -->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Alert Quantity<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="number" name="variants[0][alert_quantity]"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <!-- Status -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="select" required>
                                                    <option value="">Select Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Product Description -->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Product Description</label>
                                                <textarea name="description" class="form-control editor">{{ old('description') }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Gallery Images -->
                                        <div class="col-lg-12">
                                            <div class="mb-3 pb-3 border-bottom">
                                                <label class="form-label">Gallery Images</label>
                                                <div
                                                    class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column">
                                                    <span class="upload-img d-block mb-2"><i
                                                            class="isax isax-image text-primary"></i></span>
                                                    <p class="mb-0 text-gray-9 fw-semibold">Drop Your Files or
                                                        <a href="javascript:void(0);"
                                                            class="text-primary text-decoration-underline">Browse</a>
                                                    </p>
                                                    <input type="file" name="gallery[]" multiple accept="image/*"
                                                        class="form-control">
                                                    <p class="fs-13">Max Upload Size 800x800px. PNG / JPEG file, Maximum
                                                        Upload size 5MB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-outline-white">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Create New</button>
                                    </div>
                                </form>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <script>
        function generateCode() {
            const nameInput = document.getElementById('product_name');
            const codeInput = document.getElementById('product_code');

            if (!nameInput.value.trim()) {
                alert('Please enter product name first');
                return;
            }

            fetch('{{ route('products.generate-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: nameInput.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    codeInput.value = data.code; // ✅ THIS LINE WAS KEY
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to generate code');
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.querySelector('input[name="image"]');
            const previewContainer = document.getElementById('product-image-preview');

            if (!imageInput || !previewContainer) {
                console.warn('Image preview elements not found');
                return;
            }

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                // Clear the container completely
                previewContainer.innerHTML = '';

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.classList.add('w-100', 'h-100');
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = 'inherit';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Restore icon if no valid image
                    const icon = document.createElement('i');
                    icon.className = 'isax isax-image text-primary fs-24';
                    previewContainer.appendChild(icon);
                }
            });
        });
    </script>
@endpush
