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
                            <a href="#" class="btn btn-outline-white d-inline-flex align-items-center"><i
                                    class="isax isax-eye me-1"></i>Preview</a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Basic Details</h6>
								

                                <form action="{{ route('products.update', $product) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <span class="text-gray-9 fw-bold mb-2 d-flex">Project Primary Image<span
                                                class="text-danger ms-1">*</span></span>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xxl border border-dashed bg-light me-3 flex-shrink-0">
                                                <div class="position-relative d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                        class="avatar avatar-xl " alt="User Img">

                                                </div>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="isax isax-image me-1"></i>Upload Image
                                                    <input type="file" class="form-control image-sign" name="image">
                                                </div>
                                                <span class="text-gray-9 fs-12">JPG or PNG format, not exceeding 5MB.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row gx-3">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" id="product_name"
                                                    value="{{ old('name', $product->name) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Code <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="code"
                                                        id="product_code" value="{{ old('code', $product->code) }}"
                                                        readonly>
                                                    <a href="#"
                                                        class="btn btn-sm btn-dark position-absolute end-0 top-0 bottom-0 mx-2 my-1 d-inline-flex align-items-center">Generate</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Category <span
                                                        class="text-danger">*</span></label>
                                                <select name="category_id" class="select">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        @foreach ($variants as $i => $variant)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Selling Price</label>
                                                    <input type="number"
                                                        name="variants[{{ $i }}][selling_price]"
                                                        class="form-control"
                                                        value="{{ old("variants.$i.selling_price", $variant->selling_price) }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Purchase Price</label>
                                                    <input type="number"
                                                        name="variants[{{ $i }}][purchase_price]"
                                                        class="form-control"
                                                        value="{{ old("variants.$i.purchase_price", $variant->purchase_price) }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" name="variants[{{ $i }}][quantity]"
                                                        class="form-control"
                                                        value="{{ old("variants.$i.quantity", $variant->quantity) }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Alert Quantity <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number"
                                                        name="variants[{{ $i }}][alert_quantity]"
                                                        class="form-control"
                                                        value="{{ old("variants.$i.alert_quantity", $variant->alert_quantity ?? '') }}">

                                                </div>
                                            </div>
                                        @endforeach


                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Units <span class="text-danger">*</span></label>
                                                <select name="unit_id" class="select">
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->short_name }}"
                                                            {{ $product->unit_id == $unit->short_name ? 'selected' : '' }}>
                                                            {{ $unit->name }} ({{ $unit->short_name }})
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="select">
                                                    <option value="">Select</option>
                                                    <option value="1" {{ $product->status ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" {{ !$product->status ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>

                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                               
    <label class="form-label">Product Description</label>

    <!-- Hidden textarea for form submission -->
    <textarea name="description" id="description" class="d-none">{!! old('description', $product->description) !!}</textarea>

    <!-- Quill editor container -->
    <div class="editor">
        {!! old('description', $product->description) !!}
    </div>
</div>

                                          
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 pb-3 border-bottom">
                                                <label class="form-label">Gallery Images</label>

                                                <!-- Upload -->
                                                <div
                                                    class="file-upload drag-file w-100 d-flex align-items-center justify-content-center flex-column mb-3">
                                                    <span class="upload-img d-block mb-2">
                                                        <i class="isax isax-image text-primary"></i>
                                                    </span>
                                                    <p class="mb-0 text-gray-9 fw-semibold">
                                                        Drop Your Files or
                                                        <a href="#"
                                                            class="text-primary text-decoration-underline">Browse</a>
                                                    </p>
                                                    <input type="file" name="gallery[]" multiple
                                                        accept="image/*">
                                                    <p class="fs-13">
                                                        Max Upload Size 800x800px. PNG / JPEG file, Maximum Upload size 5MB
                                                    </p>
                                                </div>

                                                <!-- Existing Gallery -->
                                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                                    @forelse ($product->gallery as $image)
                                                        <div
                                                            class="avatar avatar-xl border gallery-img p-1 position-relative">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                alt="Gallery Image">

                                                            <!-- delete button -->
                                                            <a href="javascript:void(0);" data-id="{{ $image->id }}"
                                                                class="rounded-trash gallery-trash d-flex align-items-center justify-content-center delete-gallery">
                                                                <i class="isax isax-trash"></i>
                                                            </a>
                                                        </div>
                                                    @empty
                                                        <p class="text-muted">No gallery images uploaded</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-outline-white">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
@endpush
