@extends('central.layout')

@section('title', 'Admin Users')

@section('content')
    <!-- Page Header -->
    <div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h6 class="mb-1">Admin Users</h6>
            <p class="text-muted fs-14 mb-0">Manage the central admin accounts that can access this panel.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <button type="button" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#addAdminModal">
                <i class="isax isax-add-square me-1"></i> Add Admin
            </button>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 fs-14">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if ($admin->is_superadmin)
                                        <span class="badge bg-primary-subtle text-primary">Superadmin</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Admin</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($admin->is_active)
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <form action="{{ route('central.admins.toggle', $admin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm btn-soft-{{ $admin->is_active ? 'danger' : 'success' }}">
                                            {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('central.admins.destroy', $admin->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this admin? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No admin users yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('central.admins.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">Add Admin User</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" minlength="8" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" class="form-check-input">
                            <label for="is_superadmin" class="form-check-label">Superadmin (full access)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
