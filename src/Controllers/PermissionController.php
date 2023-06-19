<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OsarisUk\Access\Models\Permission;

/**
 * Class PermissionController
 * @package OsarisUk\Access\Controllers
 */
class PermissionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if($request->new_permission) {
            Permission::create([
                'name' => $request->new_permission
            ]);
        }

        return back();
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        $permission->delete();

        return back();
    }
}