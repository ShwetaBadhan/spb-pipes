@extends("admin.layout.master")
@section("title","Products")
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
                        <h6>Units</h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <div>
                            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>New Unit</a>
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
                

                <div class="table-responsive border border-bottom-0 rounded">
                    <table class="table table-nowrap m-0">
                        <thead class="table-light">
                            <tr>
                                <th>Unit Name</th>
                                <th class="no-sort">Short Name</th>
                                <th class="no-sort">Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($units as $unit)
                            <tr>
                                <td>
                                    <h6 class="fs-14 fw-medium mb-0">{{ $unit->name }}</h6></td>
                                <td>{{ $unit->short_name }}</td>
                                <td>
                                    @if($unit->is_active)
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
                                            <a href="#" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $unit->id }}"><i class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $unit->id }}"><i class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Start Modal  -->
                        <div id="edit_modal{{ $unit->id }}" class="modal fade">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Unit</h4>
                                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                                    </div> <!-- end modal-header -->
                                    <form action="{{ route('units.update', $unit->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Name <span class="text-danger ms-1">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="name"
                                                    value="{{ $unit->name }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Short Name <span class="text-danger ms-1">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="short_name"
                                                    value="{{ $unit->short_name }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="is_active" class="select" required>
                                                    <option value="1" {{ $unit->is_active ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$unit->is_active ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>

                                </div> <!-- end modal-content -->
                            </div>
                        </div>
                        <!-- End Modal -->

                            <!-- Start Modal  -->
                            <div class="modal fade" id="delete_modal{{ $unit->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                        
                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                             <form action="{{ route('units.delete', $unit->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <h6 class="mb-1">Delete Unit</h6>
                                            <p class="mb-3">Are you sure, you want to delete unit?</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-outline-white me-3" data-bs-dismiss="modal">Cancel</a>
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

        <!-- Start Modal  -->
        <div id="add_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Unit</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div> <!-- end modal-header -->
                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name<span class="text-danger ms-1">*</span></label>
                                <input type="text"  name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            </div>
                            <div>
                                <label class="form-label">Short Name<span class="text-danger ms-1">*</span></label>
                                <input type="text"  name="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name') }}">
                            </div>
                            <div>
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror


                        </div>
                        </div> <!-- end modal-body -->
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add New</button>
                        </div> <!-- end modal-footer -->
                    </form>
                </div> <!-- end modal-content -->
            </div>
        </div>
        <!-- End Modal -->

     
    

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
@endpush
