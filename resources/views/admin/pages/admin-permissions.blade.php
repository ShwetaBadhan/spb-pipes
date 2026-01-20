@extends("admin.layout.master")
@section("title","Permissions")
@php
    use Spatie\Permission\Models\Permission;
@endphp

@section("content")
  <!-- ========================
			Start Page Content
		========================= -->

        <div class="page-wrapper">

			<!-- Start conatiner -->
            <div class="content content-two">

                <!-- Page Header -->
                <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div>
                        <h6>
                            <a href="{{ route("roles.index") }}">
								<i class="isax isax-arrow-left me-1"></i>
								Roles
							</a>
                        </h6>
                    </div>
                    
 <div>
                            <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add_modal">
                                <i class="isax isax-add-circle5 me-1"></i>New Permission
                            </a>
                        </div>

                </div>
                <!-- End Page Header -->

                <!-- Start Table List -->
                 <!-- start row -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0">
								<i class="isax isax-search-normal fs-12"></i>
							</span>
                            <input type="text" class="form-control border-start-0 ps-0 bg-white" placeholder="Search">
                        </div>
                    </div><!-- end col -->
                </div>
				<!-- end row -->

                <!-- Table List -->
               <!-- Table List -->
<div class="table-responsive table-nowrap">
    <table class="table border mb-0">
        <thead class="table-light">
            <tr>
                <th>Permission Name</th>
                <th>Roles Using This</th>
                <th>Guard Name</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
                <tr>
                    <td class="bg-light"><span class="text-gray-3">{{ $permission->name }}</span></td>
                    <td class="bg-light">
                        @php $roleCount = $permission->roles->count(); @endphp
                        @if($roleCount > 0)
                            <span class="badge bg-success">{{ $roleCount }} role(s)</span>
                            <small class="text-muted d-block">
                                @foreach($permission->roles->take(3) as $role)
                                    {{ $role->name }}@if(!$loop->last), @endif
                                @endforeach
                                @if($roleCount > 3)
                                    +{{ $roleCount - 3 }} more
                                @endif
                            </small>
                        @else
                            <span class="badge bg-secondary">Not assigned</span>
                        @endif
                    </td>
                    <td class="bg-light">{{ $permission->guard_name }}</td>
                    <td class="bg-light">{{ $permission->created_at->format('M d, Y') }}</td>
                    <td class="action-item bg-light">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown">
                            <i class="isax isax-more"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editPermissionModal{{ $permission->id }}">
                                    <i class="isax isax-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deletePermissionModal{{ $permission->id }}">
                                    <i class="isax isax-trash me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                        <!-- Start Edit Modal  -->
<div class="modal fade" id="editPermissionModal{{ $permission->id }}">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <!-- modal header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Role</h4>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                                            @csrf @method('PUT')
    <div class="modal-body">
        <div class="mb-0">
            <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
                                                        <small class="text-muted">Use kebab-case: view-users</small>
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
<!-- / End Edit Modal -->

<div class="modal fade" id="deletePermissionModal{{ $permission->id }}">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
<form action="{{ route('permissions.destroy', $permission) }}" method="POST">
                                            @csrf @method('DELETE')

                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="assets/img/icons/delete.svg" alt="img">
                    </div>
                    <h6 class="mb-1">Delete Permission <code>{{ $permission->name }}</code></h6>
                      <p>Are you sure you want to delete the permission ?</p>
                                                    <p class="text-danger"><small>This will remove this permission from all roles that have it.</small></p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
                           
            
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No permissions found.</td>
                </tr>
                
            @endforelse
        </tbody>
    </table>
</div>
<!-- /Table List -->

                <!-- /Table List -->
                <!-- End Table List -->

            </div>
			<!-- End Content -->

        

        </div>
        <!-- ========================
			End Page Content
		========================= -->

        <!-- start Add Modal  -->
        <div id="add_modal" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Permission</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-x"></i></button>
                    </div>
                    <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Permission Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. view-appointments, edit-patients" required>
                        <small class="text-muted d-block mt-1">Use kebab-case format (lowercase with hyphens)</small>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->

       



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