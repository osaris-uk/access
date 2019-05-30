<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OsarisUk\Access\Models\Permission;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        if($request->new_permission) {
            Permission::create([
                'name' => $request->new_permission
            ]);
        }

        return back();
    }

    public function destroy(Request $request, $id)
    {
        Permission::destroy($id);

        return back();
    }
}