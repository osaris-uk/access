<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use OsarisUk\Access\Controllers\PermissionController;
use OsarisUk\Access\Models\Permission;
use OsarisUk\Access\Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can store permissions', function () {
    Permission::get()->each(function ($permission) {
        $permission->delete();
    });

    $controller = new PermissionController();

    $request = new Request();

    $request->new_permission = 'moderate blog posts';

    $controller->store($request);

    expect(Permission::get()->count())->toEqual(1);
});

test('can delete permissions', function () {
    Permission::get()->each(function ($permission) {
        $permission->delete();
    });

    $controller = new PermissionController();

    $request = new Request();

    $request->new_permission = 'moderate blog posts';

    $controller->store($request);

    $permission = Permission::get();

    expect($permission->count())->toEqual(1);

    $controller->destroy(new Request(), $permission->first());

    expect(Permission::get()->count())->toEqual(0);
});
