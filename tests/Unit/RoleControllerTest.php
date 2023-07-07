<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use OsarisUk\Access\Controllers\RoleController;
use OsarisUk\Access\Models\Role;
use OsarisUk\Access\Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can store roles', function () {
    Role::get()->each(function ($role) {
        $role->delete();
    });

    $controller = new RoleController();

    $request = new Request();

    $request->new_role = 'admin';

    $controller->store($request);

    expect(Role::get()->count())->toEqual(1);
});

test('can delete roles', function () {
    Role::get()->each(function ($role) {
        $role->delete();
    });

    $controller = new RoleController();

    $request = new Request();

    $request->new_role = 'admin';

    $controller->store($request);

    $role = Role::get();

    expect($role->count())->toEqual(1);

    $controller->destroy(new Request(), $role->first());

    expect(Role::get()->count())->toEqual(0);
});
