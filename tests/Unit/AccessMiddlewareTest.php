<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use OsarisUk\Access\Models\Permission;
use OsarisUk\Access\Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('abort if no user', function () {
    $this->get(route('access.index'))->assertNotFound();
});

test('can access unrestricted route', function () {
    $this->get(route('noRestrictionTest'))->assertOk();
});

test('abort if access middleware defined with no role or permission', function () {
    $this->get(route('noPermissionOrRoleTest'))->assertNotFound();
});

test('abort if user does not have required explicit permission', function () {
    $this->get(route('permissionOnlyTest'))->assertNotFound();

    Permission::updateOrCreate([
        'name' => 'view permission test route',
    ]);

    $this->actingAs($this->freshUser())->get(route('permissionOnlyTest'))->assertNotFound();

    $user = $this->user(null, 'view permission test route');

    Permission::get()->map(function (Permission $permission) {
        Gate::define($permission->name, function ($user) use ($permission) {
            return $user->hasPermissionTo($permission->name);
        });
    });

    $this->actingAs($user)->get(route('permissionOnlyTest'))->assertOk();
});


test('can access if user has required explicit permission but not defined role', function () {
    Permission::updateOrCreate([
        'name' => 'view permission test route',
    ]);

    $user = $this->user(null, 'view permission test route');

    Permission::get()->map(function (Permission $permission) {
        Gate::define($permission->name, function ($user) use ($permission) {
            return $user->hasPermissionTo($permission->name);
        });
    });

    $this->get(route('permissionAndRoleTest'))->assertNotFound();

    $this->actingAs($user)->get(route('permissionAndRoleTest'))->assertOk();
});

test('abort if user does not have appropriate role', function () {
    $user = $this->user();

    $this->actingAs($user)->get(route('access.index'))->assertNotFound();
});

test('can access if user has appropriate role', function () {
    $this->setupTestRoles();

    $user = $this->user('admin');

    $this->actingAs($user)->get(route('access.index'))->assertOk();
});
