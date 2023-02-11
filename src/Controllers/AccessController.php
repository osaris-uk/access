<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use App\Http\Controllers\Controller;
use OsarisUk\Access\Models\Permission;
use Illuminate\Support\Facades\Config;

/**
 * Class AccessController
 * @package OsarisUk\Access\Controllers
 */
class AccessController extends Controller
{
    /**
     * AccessController constructor.
     */
    public function __construct()
    {
        $model = Config::get('auth.providers.users.model');
        $this->users = new $model;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('access::index', [
            'roles' => Role::get(),
            'permissions' => Permission::get()
        ]);
    }

    /**
     * @return mixed
     */
    public function getUserRoles()
    {
        return view('access::roles', [
            'roles' => Role::get(),
            'users' => $this->users->get()
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postUserRoles(Request $request)
    {
        foreach($request->userRoles as $userId => $roles)
        {
            $user = $this->users->find($userId);

            $user->updateRoles(array_keys($roles));
        }

        return back();
    }

    /**
     * @return mixed
     */
    public function getRolePermissions()
    {
        return view('access::role_permissions', [
            'roles' => Role::get(),
            'permissions' => Permission::get()
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
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