<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Concerns\EnforcesPlanLimits;

class UserRegisterController extends Controller
{
    use EnforcesPlanLimits;

    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        $roles = Role::all(); // fetch all roles for dropdown

        return view('admin.pages.admin-users', compact('users', 'roles'));
    }
    public function store(Request $request) // For adding new user
    {
        if ($guard = $this->ensurePlanLimit('users', 'user')) {
            return $guard;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|exists:roles,name',
            'is_active' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
        ]);

        if ($request->role) {
            $this->syncRole($user, $request->role);
        }

        return back()->with('success', 'User created successfully!');
    }

   public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:55',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'is_active' => 'required|boolean',
        'role' => 'nullable|exists:roles,name',  // ← Add this validation
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'is_active' => $request->is_active,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    // ← Role update logic add karein
    if ($request->has('role')) {
        $this->syncRole($user, $request->filled('role') ? $request->role : null);
    }

    return back()->with('success', 'User updated successfully!');
}

    public function updateRole(Request $request, User $user) // For changing role on existing user
    {
        $request->validate(['role' => 'nullable|exists:roles,name']);
        $this->syncRole($user, $request->role ?? null);
        return back()->with('success', 'Role updated successfully!');
    }

    private function syncRole(User $user, ?string $roleName): void
    {
        if ($roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $user->roles()->sync([$role->id => ['tenant_id' => tenant()->getTenantKey()]]);

                return;
            }
        }

        $user->roles()->sync([]);
    }

    public function destroy(User $user) // For deleting user
    {
        // Prevent user from deleting themselves
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Prevent deletion of admin users (optional)
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Admin users cannot be deleted!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function show(User $user) // For viewing user details
    {
        return response()->json($user->load('roles'));
    }
}
