<?php

namespace OsarisUk\Access\Controllers;

use App\User;
use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use App\Http\Controllers\Controller;
use OsarisUk\Access\Models\Permission;

class AccessController extends Controller
{
    public function index()
    {
        return view('access::index', [
            'roles' => Role::get(),
            'permissions' => Permission::get()
        ]);
    }

    public function getUserRoles()
    {
        return view('access::roles', [
            'roles' => Role::get(),
            'users' => User::get()
        ]);
    }

    public function postUserRoles(Request $request)
    {
        foreach($request->userRoles as $userId => $roles)
        {
            $user = User::find($userId);

            $user->updateRoles(array_keys($roles));
        }

        return back();
    }

    public function getRolePermissions()
    {
        return view('access::role_permissions', [
            'roles' => Role::get(),
            'permissions' => Permission::get()
        ]);
    }

    public function postRolePermissions(Request $request)
    {
        foreach($request->rolePermissions as $roleId => $permissions)
        {
            $role = Role::find($roleId);

            $role->updatePermissions(array_keys($permissions));
        }

        return back();
    }
}