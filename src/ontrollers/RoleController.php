<?php

namespace OsarisUk\Access\Controllers;

use Illuminate\Http\Request;
use OsarisUk\Access\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        if($request->new_role) {
            Role::create([
                'name' => $request->new_role
            ]);
        }

        return back();
    }

    public function destroy(Request $request, $id)
    {
        Role::destroy($id);

        return back();
    }
}