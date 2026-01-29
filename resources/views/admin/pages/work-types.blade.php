@extends('admin.layout.master')
@section('title', 'Products')
@section('content')
    <!-- ========================
       Start Page Content
      ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Work Type</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div>
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>Add Work Type</a>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="isax isax-search-normal fs-12"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 bg-white" placeholder="Search">
                    </div>
                </div> <!-- end col -->
            </div>
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

            <div class="table-responsive border border-bottom-0 rounded">
                <table class="table table-nowrap m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Work Type</th>
                            <th>Slug</th>
                            <th class="no-sort">Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workTypes as $worktype)
                            <tr>
                                <td>
                                    <h6 class="fs-14 fw-medium mb-0">{{ $worktype->name }}</h6>
                                </td>

                                <td>
                                    <h6 class="fs-14 fw-medium mb-0">{{ $worktype->slug }}</h6>
                                </td>

                                <td>
                                    @if ($worktype->status === 'active')
                                        <span class="badge badge-soft-success d-inline-flex align-items-center">
                                            Active <i class="isax isax-tick-circle ms-1"></i>
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger d-inline-flex align-items-center">
                                            Inactive <i class="isax isax-close-circle ms-1"></i>
                                        </span>
                                    @endif
                                </td>

                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#edit_modal{{ $worktype->id }}"><i
                                                    class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal{{ $worktype->id }}"><i
                                                    class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Start Modal -->
                            <div id="edit_modal{{ $worktype->id }}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Work Type</h4>
                                            <button type="button" class="btn-close btn-close-modal custom-btn-close"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa-solid fa-x"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('work-types.update', $worktype->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Name <span class="text-danger ms-1">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="edit_name_{{ $worktype->id }}" value="{{ $worktype->name }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Slug<span
                                                            class="text-danger ms-1">*</span></label>
                                                    <input type="text" name="slug" id="edit_slug_{{ $worktype->id }}"
                                                        class="form-control" value="{{ $worktype->slug }}" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="select" required>
                                                        <option value="active"
                                                            {{ $worktype->status === 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="inactive"
                                                            {{ $worktype->status === 'inactive' ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-outline-white"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                            <!-- Start Modal  -->
                            <div class="modal fade" id="delete_modal{{ $worktype->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">

                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                            <form action="{{ route('work-types.destroy', $worktype->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <h6 class="mb-1">Delete Work Type</h6>
                                                <p class="mb-3">Are you sure, you want to delete {{ $worktype->name }}?
                                                </p>
                                                <div class="d-flex justify-content-center">
                                                    <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                                                        data-bs-dismiss="modal">Cancel</a>
                                                    <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div> <!-- end modal-body -->
                                    </div> <!-- end modal-content -->
                                </div>
                            </div>
                            <!-- End Modal  -->
                        @endforeach
                    </tbody>
                </table> <!-- end table -->
            </div>

        </div>
        <!-- End Content -->



    </div>

    <!-- ========================
       End Page Content
      ========================= -->

    <!-- Start Modal -->
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Work Type</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <form action="{{ route('work-types.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="name" id="nameInput"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Enter work type name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="slug" id="slugInput"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                placeholder="Auto-generated from name" readonly>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->




@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all name inputs (add + edit modals)
            document.addEventListener('input', function(e) {
                // Check if input is a name field
                if (e.target.name === 'name' && e.target.id) {
                    let slugId = '';

                    // Determine corresponding slug input ID
                    if (e.target.id.startsWith('edit_name_')) {
                        const id = e.target.id.replace('edit_name_', '');
                        slugId = 'edit_slug_' + id;
                    } else if (e.target.id === 'nameInput') {
                        slugId = 'slugInput';
                    }

                    const slugInput = document.getElementById(slugId);
                    if (slugInput) {
                        generateSlug(e.target.value, slugInput);
                    }
                }
            });

            // Auto-generate slug on page load for existing values
            document.querySelectorAll('[id^="edit_name_"], #nameInput').forEach(function(nameInput) {
                const slugId = nameInput.id.replace('name', 'slug').replace('edit_name', 'edit_slug');
                const slugInput = document.getElementById(slugId);

                if (nameInput.value && slugInput && !slugInput.value) {
                    generateSlug(nameInput.value, slugInput);
                }
            });

            // Slug generation function
            function generateSlug(name, slugInput) {
                if (!name) {
                    slugInput.value = '';
                    return;
                }

                let slug = name
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');

                slugInput.value = slug;
            }
        });
    </script>
@endpush
