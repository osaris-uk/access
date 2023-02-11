<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use App\Http\Controllers\Controller;

/**
 * Class RoleController
 * @package OsarisUk\Access\Controllers
 */
class RoleController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if($request->new_role) {
            Role::create([
                'name' => $request->new_role
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
        Role::destroy($id);

        return back();
    }
}