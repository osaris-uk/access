<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use Illuminate\Routing\Controller;

/**
 * Class RoleController
 * @package OsarisUk\Access\Controllers
 */
class RoleController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if($request->new_role) {
            Role::create([
                'name' => $request->new_role
            ]);
        }

        return back();
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return back();
    }
}