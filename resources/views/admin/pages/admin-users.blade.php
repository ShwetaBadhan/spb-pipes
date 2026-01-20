@extends("admin.layout.master")
@section("title","Admin Users")
@php
    use Spatie\Permission\Models\Role;
@endphp
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
                        <h6>Users</h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Download as PDF</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Download as Excel</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal">
                                <i class="isax isax-add-circle5 me-1"></i>New User
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="table-search d-flex align-items-center mb-0">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                            <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                                <i class="isax isax-filter me-1"></i>Filter
                            </a>
                        </div>
                      
                    </div>
                    <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                        <h6 class="fs-13 fw-semibold">Filters</h6>
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Users Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Status Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                        <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap datatable">
                        <thead class="thead-light">
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th>Name</th>
                               
                                <th>Role</th>
                              
                                <th>Create On</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                       
                                        <div>
                                            <h6 class="fs-14 fw-medium mb-0"><a href="javascript:void(0);">{{ $user->name }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                              
                               <td class="text-dark">
                                    {{ $user->getRoleNames()->map(fn($r) => ucfirst($r))->join(', ') ?: 'No Role' }}
                                </td>

                               
                               <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($user->is_active)
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
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $user->id }}"><i class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal{{ $user->id }}"><i class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                                                <!-- Start Modal  -->
                            <div id="edit_modal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit User</h4>
                                            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                                        </div> <!-- end modal-header -->
                                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body pb-0">
                                                <div class="row">
                                                    
                                                
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">User Name<span class="text-danger ms-1">*</span></label>
                                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                                            <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                                        </div>
                                                    </div> <!-- end col -->
                                                
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Password</label>
                                                            <div class="position-relative" id="passwordInput1">
                                                                <input type="password" class="pass-inputs form-control">
                                                                <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Confirm Password<span class="text-danger ms-1">*</span></label>
                                                            <div class="position-relative">
                                                                <input type="password" class="pass-inputa form-control">
                                                                <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Role</label>
                                                            @php
                                                                $userRole = $user->getRoleNames()->first(); // gets first role
                                                            @endphp
                                                            <select name="role" class="select">
                                                                <option value="">Select Role</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>
                                                                        {{ ucfirst($role->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div> <!-- end col -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="is_active" class="select">
                                                                <option value="">Select</option>
                                                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                                            </select>

                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                            </div> <!-- end modal-body -->
                                            <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                                                <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div> <!-- end modal-footer -->
                                        </form>
                                    </div> <!-- end modal-content -->
                                </div>
                            </div>
                            <!-- End Modal -->
                                                <!-- Start Modal  -->
                            <div class="modal fade" id="delete_modal{{ $user->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="mb-3">
                                                <img src="assets/img/icons/delete.svg" alt="img">
                                            </div>
                                             <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <h6 class="mb-1">Delete User {{ $user->name }}</h6>
                                            <p class="mb-3">Are you sure, you want to delete User?</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</a>
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
                    </table>
					<!-- end table -->
					 
                </div>

            </div>
			<!-- End Content -->


        </div>

		<!-- ========================
			End Page Content
		========================= -->	

<!-- Start Modal  -->
<div id="add_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New User</h4>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div> <!-- end modal-header -->
            
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger ms-1">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="pass-inputs form-control" required>
                                    <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Confirm Password <span class="text-danger ms-1">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" class="pass-inputa form-control" required>
                                    <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="select">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="select" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end modal-body -->

                <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                    <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div> <!-- end modal-footer -->
            </form>
        </div> <!-- end modal-content -->
    </div>
</div>

       

        
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