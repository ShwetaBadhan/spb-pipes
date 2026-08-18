<div class="card">
    <div class="card-header bg-white py-3"><h6 class="mb-0">Tenant Users</h6></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last Login</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->hasRole('Super Admin'))
                                    <span class="badge badge-soft-danger">Super Admin</span>
                                @elseif($user->hasRole('Admin'))
                                    <span class="badge badge-soft-primary">Admin</span>
                                @else
                                    <span class="badge badge-soft-secondary">{{ $user->getRoleNames()->first() ?? 'User' }}</span>
                                @endif
                            </td>
                            <td>{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                            <td>
                                @if($user->is_active ?? true)
                                    <span class="badge badge-soft-success">Active</span>
                                @else
                                    <span class="badge badge-soft-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
