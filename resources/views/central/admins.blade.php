@extends('central.layout')

@section('title', 'Admin Users')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Create Admin User</h5></div>
                <div class="card-body">
                    <form action="{{ route('central.admins.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" class="form-check-input"
                                {{ old('is_superadmin') ? 'checked' : '' }}>
                            <label for="is_superadmin" class="form-check-label">Super Admin</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create Admin</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Admin Users</h5></div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if ($admin->is_superadmin)
                                            <span class="badge bg-primary">Super Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($admin->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($admin->id !== auth('central')->id())
                                            <form action="{{ route('central.admins.toggle', $admin) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('central.admins.destroy', $admin) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this admin user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-muted fs-14">You</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No admin users yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
