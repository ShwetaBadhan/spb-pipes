@extends('admin.layout.master')
@section('title', 'Roles')
@php
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
@endphp

@section('content')
    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h6>Roles & Permission</h6>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
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
                        <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#add_modal">
                            <i class="isax isax-add-circle5 me-1"></i>New Role
                        </a>
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
                </div><!-- end col -->
            </div>
            <!-- end row -->

            <!-- Table List -->
            <div class="table-responsive table-nowrap">
                <table class="table border mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Role</th>
                            <th>Create On</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="bg-light"><span class="text-gray-3">{{ $role->name }}</span></td>
                                <td class="bg-light"><span
                                        class="text-gray-3">{{ $role->created_at->format('d M Y') }}</span></td>
                                <td class="bg-light">
                                    <a href="javascript:void(0);"
                                        class="btn btn-outline-white d-inline-flex align-items-center"
                                        data-bs-toggle="modal" data-bs-target="#assignPermissionsModal{{ $role->id }}">
                                        <i class="isax isax-shield-tick me-1"></i> Permissions
                                    </a>
                                </td>
                                <td class="action-item bg-light">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <i class="isax isax-more"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#editRole{{ $role->id }}"><i
                                                    class="isax isax-edit me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#deleteRole{{ $role->id }}"><i
                                                    class="isax isax-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <!-- Start Edit Modal  -->
                            <div id="editRole{{ $role->id }}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <!-- modal header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Role</h4>
                                            <button type="button" class="btn-close btn-close-modal custom-btn-close"
                                                data-bs-dismiss="modal"><i class="fa-solid fa-x"></i></button>
                                        </div>

                                        <form action="{{ route('roles.updateRole', ['role' => $role->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-0">
                                                    <label class="form-label">Role Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $role->name }}" required>
                                                </div>
                                            </div>
                                            <div
                                                class="modal-footer d-flex align-items-center justify-content-between gap-1">
                                                <button type="button" class="btn btn-outline-white"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- / End Edit Modal -->

                            <!-- Start Delete Modal  -->
                            <div class="modal fade" id="deleteRole{{ $role->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <form action="{{ route('roles.destroyRole', ['role' => $role->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-body text-center">
                                                <div class="mb-3">
                                                    <img src="assets/img/icons/delete.svg" alt="img">
                                                </div>
                                                <h6 class="mb-1">Delete Role {{ $role->name }}</h6>
                                                <p class="mb-3">Are you sure you want to delete this role?</p>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-outline-white"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- / End Delete Modal  -->
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /Table List -->

        </div>
        <!-- End Content -->



    </div>
    <!-- Start Add Modal  -->
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- Start modal header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Role</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-x"></i></button>
                </div>
                <!-- End modal header -->

                <form action="{{ route('roles.storeRole') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-0">
                            <input type="text" name="name" class="form-control" placeholder="Role name" required>

                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div><!-- End modal content-->
        </div><!-- End modal dialog-->
    </div>
    <!-- / End Add Modal -->

    <!-- Assign Permissions Modal -->
    <div class="modal fade" id="assignPermissionsModal{{ $role->id }}">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <!-- modal header -->
                <div class="modal-header">
                    <h4 class="modal-title">Assing Permissions</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"><i
                            class="fa-solid fa-x"></i></button>
                </div>

                <form action="{{ route('roles.update-permissions', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-0">
                            <label class="form-label">Permissions</label>
                            <select class="select2 form-control select2-multiple" name="permissions[]"
                                multiple="multiple" data-placeholder="Choose permissions...">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->name }}"
                                        {{ $role->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between gap-1">
                        <button type="button" class="btn btn-outline-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
@endpush
