@extends("admin.layout.master")
@section("title","Category")
@section("content")
<!-- ========================
			Start Page Content
		========================= -->

        <div class="page-wrapper">

			<!-- Start Content -->
            <div class="content content-two">

                <!-- Page Header -->
                <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div>
                        <h6>Category</h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <div>
                            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>New Category</a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <!-- Table Search -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="table-search d-flex align-items-center mb-0">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Table Search -->

                <!-- Table List -->
                <div class="table-responsive">
                    <table class="table table-nowrap datatable">
                        <thead class="thead-light">
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th>Category Name</th>
                                <th class="no-sort">Status</th>
                                <th class="no-sort">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as  $category)
                            
                        
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);">{{ $category->name }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    @if($category->is_active)
                                        <span class="badge badge-soft-success d-inline-flex align-items-center">  
                                        Active <i class="isax isax-tick-circle ms-1"></i> </span>
                                @else
                                    <span class="badge badge-soft-danger d-inline-flex align-items-center">Inactive<i class="isax isax-close-circle ms-1"></i></span>
                                @endif                             
                                </td>
                                <td class="action-item">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $category->id }}"><i class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $category->id }}"><i class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                              <!-- Edit Modal Start -->
                            <div id="edit_modal{{ $category->id }}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit  Category</h4>
                                            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                                        </div>
                                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                            <div class="modal-body">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Name<span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control"  id="edit_name" name="name" value="{{ $category->name }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">Slug</label>
                                                    <input type="text" class="form-control" id="edit_slug" name="slug" value="{{ $category->slug }}">
                                                </div>
                                                <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="is_active" class="select" required>
                                                    <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                                                <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Modal End -->
                                <!-- Delete Modal Start -->
                                <div class="modal fade" id="delete_modal{{ $category->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                        
                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                             <form action="{{ route('category.delete', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <h6 class="mb-1">Delete Category</h6>
                                            <p class="mb-3">Are you sure, you want to delete category {{ $category->name }}?</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                            </div>
                                            </form>
                                        </div> <!-- end modal-body -->
                                    </div> <!-- end modal-content -->
                                </div>
                            </div>
                                <!-- Delete Modal End  -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /Table List -->

            </div>
			<!-- End Content -->


           

        </div>

        <!-- ========================
			End Page Content
		========================= -->

        <!-- Add Modal Start -->
        <div id="add_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Add New</button>
                </div>
            </form>
                </div>
            </div>
        </div>
        <!-- Add Modal End -->

      

       
@endsection
@push('scripts')


@if(session('success'))
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

@if(session('error'))
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
<script>
function generateSlug(sourceId, targetId) {
    const source = document.getElementById(sourceId);
    const target = document.getElementById(targetId);

    if (!source || !target) return;

    source.addEventListener('keyup', function () {
        let slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');

        target.value = slug;
    });
}

// Add category
generateSlug('name', 'slug');

// Edit category
generateSlug('edit_name', 'edit_slug');
</script>

@endpush