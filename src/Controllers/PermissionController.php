<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OsarisUk\Access\Models\Permission;

/**
 * Class PermissionController
 * @package OsarisUk\Access\Controllers
 */
class PermissionController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if($request->new_permission) {
            Permission::create([
                'name' => $request->new_permission
            ]);
        }

        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        Permission::destroy($id);

        return back();
    }
}