<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use OsarisUk\Access\Models\Permission;
use OsarisUk\Access\Models\Role;
use OsarisUk\Access\Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can create roles', function () {
    $user = Role::create([
        'name' => 'user',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    expect($user)->toBeInstanceOf(Role::class)
        ->and($user->name)->toBe('user');
    expect($admin)->toBeInstanceOf(Role::class)
        ->and($admin->name)->toBe('admin');
});

test('can create permissions', function () {
    $permission_1 = Permission::create([
        'name' => 'moderate blog post',
    ]);

    $permission_2 = Permission::create([
        'name' => 'create blog post',
    ]);

    expect($permission_1)->toBeInstanceOf(Permission::class)
        ->and($permission_1->name)->toBe('moderate blog post');

    expect($permission_2)->toBeInstanceOf(Permission::class)
        ->and($permission_2->name)->toBe('create blog post');
});

test('can assign roles permissions', function () {
    Permission::create([
        'name' => 'moderate blog post',
    ]);

    Permission::create([
        'name' => 'create blog post',
    ]);

    $user = Role::create([
        'name' => 'user',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    $user->givePermissionTo('create blog post');

    $admin->givePermissionTo('create blog post', 'moderate blog post');

    expect($user->permissions)->toHaveCount(1)
        ->and($user->permissions->first()->name)->toBe('create blog post');

    expect($admin->permissions)->toHaveCount(2)
        ->and($admin->permissions)->each(function ($permission) {
            $permission->name->toBeIn(['create blog post', 'moderate blog post']);
        });

    expect($user->givePermissionTo())->toBeInstanceOf(Role::class);
});

test('can withdraw roles permissions', function () {
    Permission::create([
        'name' => 'moderate blog post',
    ]);

    Permission::create([
        'name' => 'create blog post',
    ]);

    Permission::create([
        'name' => 'delete blog post',
    ]);

    $user = Role::create([
        'name' => 'user',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    $user->givePermissionTo('create blog post');

    $admin->givePermissionTo('create blog post', 'moderate blog post', 'delete blog post');

    expect($user->permissions)->toHaveCount(1)
        ->and($user->permissions->first()->name)->toBe('create blog post');

    expect($admin->permissions)->toHaveCount(3)
        ->and($admin->permissions)->each(function ($permission) {
            $permission->name->toBeIn(['create blog post', 'moderate blog post', 'delete blog post']);
        });

    $user->withdrawPermissionTo('create blog post');

    $admin->withdrawPermissionTo('create blog post', 'moderate blog post');

    $user->refresh();

    $admin->refresh();

    expect($user->permissions)->toHaveCount(0);

    expect($admin->permissions)->toHaveCount(1)
        ->and($admin->permissions->first()->name)->toBe('delete blog post');
});

test('can update roles permissions', function () {
    Permission::create([
        'name' => 'moderate blog post',
    ]);

    Permission::create([
        'name' => 'create blog post',
    ]);

    Permission::create([
        'name' => 'delete blog post',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    Permission::create([
        'name' => 'view account settings',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    $admin->givePermissionTo('create blog post', 'moderate blog post', 'delete blog post');

    expect($admin->permissions)->toHaveCount(3)
        ->and($admin->permissions)->each(function ($permission) {
            $permission->name->toBeIn(['create blog post', 'moderate blog post', 'delete blog post']);
        });

    $admin->updatePermissions('view account settings', 'update account settings');

    $admin->refresh();

    expect($admin->permissions)->toHaveCount(2)
        ->and($admin->permissions)->each(function ($permission) {
            $permission->name->toBeIn(['view account settings', 'update account settings']);
        });
});

test('can check roles permissions', function () {
    Permission::create([
        'name' => 'moderate blog post',
    ]);

    Permission::create([
        'name' => 'create blog post',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    $admin->givePermissionTo('create blog post');

    expect($admin->permissions)->toHaveCount(1)
        ->and($admin->permissions->first()->name)->toBe('create blog post');

    expect($admin->hasPermission('create blog post'))->toBeTrue();

    expect($admin->hasPermission('moderate blog post'))->toBeFalse();
});

test('check permissions have roles', function () {
    $permission = Permission::create([
        'name' => 'create blog post',
    ]);

    $admin = Role::create([
        'name' => 'admin',
    ]);

    $admin->givePermissionTo('create blog post');

    expect($permission->roles)->toHaveCount(1)
        ->and($permission->roles->first()->name)->toBe('admin');
});
