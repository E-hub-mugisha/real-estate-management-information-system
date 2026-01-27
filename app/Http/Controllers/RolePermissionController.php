<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // Show user list with roles and permissions
    public function index(Request $request)
    {
        $user = null;
        if ($request->has('user_id')) {
            $user = User::with('roles', 'permissions')->find($request->user_id);
        }

        $permissions = Permission::all();
        $roles = Role::all();

        return view('users.role', compact('user', 'permissions', 'roles'));
    }


    // Update user permissions via toggle
    public function updatePermissions(Request $request, User $user)
    {
        $user->syncPermissions($request->permissions ?? []);
        return back()->with('success', 'Permissions updated successfully');
    }

    // Update user roles via toggle
    public function updateRoles(Request $request, User $user)
    {
        $user->syncRoles($request->roles ?? []);
        return back()->with('success', 'Roles updated successfully');
    }
}
