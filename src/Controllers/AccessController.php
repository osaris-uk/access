<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use Illuminate\Routing\Controller;
use OsarisUk\Access\Models\Permission;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

/**
 * Class AccessController
 * @package OsarisUk\Access\Controllers
 */
class AccessController extends Controller
{
    /** @var Model $users */
    public $users;

    /**
     * AccessController constructor.
     */
    public function __construct()
    {
        $this->users = app()->make(Config::get('auth.providers.users.model'));
    }

    public function index(): View
    {
        /** @phpstan-ignore-next-line */
        return view('access::index', [
            'roles' => Role::get(),
            'permissions' => Permission::get(),
        ]);
    }

    public function getUserRoles(): View
    {
        /** @phpstan-ignore-next-line */
        return view('access::roles', [
            'roles' => Role::get(),
            'users' => $this->users->get(),
        ]);
    }

    public function postUserRoles(Request $request): RedirectResponse
    {
        foreach($request->userRoles as $userId => $roles)
        {
            /** @var Model $user */
            $user = $this->users->find($userId);

            /** @phpstan-ignore-next-line */
            $user->updateRoles(array_keys($roles));
        }

        return back();
    }

    public function getRolePermissions(): View
    {
        /** @phpstan-ignore-next-line */
        return view('access::role_permissions', [
            'roles' => Role::get(),
            'permissions' => Permission::get(),
        ]);
    }

    public function postRolePermissions(Request $request): RedirectResponse
    {
        foreach($request->rolePermissions as $roleId => $permissions)
        {
            /** @var Role $role */
            $role = Role::find($roleId);

            $role->updatePermissions(array_keys($permissions));
        }

        return back();
    }
}