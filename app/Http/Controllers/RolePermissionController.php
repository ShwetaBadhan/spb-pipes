<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    /* =========================
       ROLES PAGE
    ========================== */
    public function rolesIndex()
    {
        $roles = Role::with(['permissions', 'users'])->get();
        $permissions = Permission::all();

        return view('admin.pages.admin-roles', compact('roles', 'permissions'));

    }

    /* =========================
       PERMISSIONS PAGE
    ========================== */
    public function permissionsIndex()
{
    $permissions = Permission::with('roles')->get();
    return view('admin.pages.admin-permissions', compact('permissions'));
}

    /* =========================
       STORE ROLE + PERMISSIONS
    ========================== */
        // 👇👇👇 THIS METHOD MUST EXIST
    public function store(Request $request)
    {
        return $this->storeRole($request);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with(
            'success',
            'Role created successfully' .
                ($request->permissions
                    ? ' with ' . count($request->permissions) . ' permissions'
                    : '')
        );
    }

    /* =========================
       UPDATE ROLE NAME
    ========================== */
       // 👇👇👇 THIS METHOD MUST EXIST
 // For updating role name
public function update(Request $request, Role $role)
{
    return $this->updateRole($request, $role);
}

    public function updateRole(Request $request, Role $role)
    {
        if ($role->name === 'admin') {
            return back()->with('error', 'Admin role cannot be renamed');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Role updated successfully!');
    }

    /* =========================
       UPDATE ROLE PERMISSIONS
    ========================== */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with(
            'success',
            'Permissions updated for ' . $role->name .
            ' (' . count($request->permissions ?? []) . ' assigned)'
        );
    }

    /* =========================
       DELETE ROLE
    ========================== */
    public function destroy(Role $role)
{
    return $this->destroyRole($role);
}

    public function destroyRole(Role $role)
    {
        if ($role->name === 'admin') {
            return back()->with('error', 'Admin role cannot be deleted');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully!');
    }

    /* =========================
       STORE PERMISSION
    ========================== */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permission created successfully!');
    }

    /* =========================
       UPDATE PERMISSION
    ========================== */
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permission updated successfully!');
    }

    /* =========================
       DELETE PERMISSION
    ========================== */
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', 'Permission deleted successfully!');
    }
}
