<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use OsarisUk\Access\Models\Permission;
use OsarisUk\Access\Models\Role;
use OsarisUk\Access\Tests\TestCase;
use OsarisUk\Access\Tests\TestModels\User;

uses(TestCase::class, RefreshDatabase::class);

test('can give roles', function () {
    $user = $this->freshUser();

    expect($user->roles)->toHaveCount(0);

    $user->giveRoles('user', 'admin');

    $user->refresh();

    expect($user->roles)->toHaveCount(2);

    expect($user->giveRoles())->toBeInstanceOf(User::class);
});

test('can withdraw roles', function () {
    $user = $this->freshUser();

    Role::create([
        'name' => 'moderator',
    ]);

    $user->giveRoles('user', 'admin', 'moderator');

    $user->refresh();

    expect($user->roles)->toHaveCount(3);

    $user->withdrawRoles('user', 'admin');

    $user->refresh();

    expect($user->roles)->toHaveCount(1);
});

test('can update roles', function () {
    $user = $this->freshUser();

    Role::create([
        'name' => 'moderator',
    ]);

    $user->giveRoles('user', 'admin');

    $user->refresh();

    expect($user->roles)->toHaveCount(2);

    $user->updateRoles('user', 'admin', 'moderator');

    $user->refresh();

    expect($user->roles)->toHaveCount(3);
});

test('can give permissions', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    expect($user->permissions)->toHaveCount(0);

    $user->givePermissionTo('access admin area', 'update account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(2);

    expect($user->givePermissionTo())->toBeInstanceOf(User::class);
});

test('can withdraw permissions', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    Permission::create([
        'name' => 'vew account settings',
    ]);

    expect($user->permissions)->toHaveCount(0);

    $user->givePermissionTo('access admin area', 'update account settings', 'vew account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(3);

    $user->withdrawPermissionTo('update account settings', 'vew account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(1);
});

test('can update permissions', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    Permission::create([
        'name' => 'vew account settings',
    ]);

    expect($user->permissions)->toHaveCount(0);

    $user->givePermissionTo('access admin area', 'update account settings', 'vew account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(3);

    $user->updatePermissions('update account settings', 'vew account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(2);
});

test('can check roles', function () {
    $user = $this->freshUser();

    Role::create([
        'name' => 'moderator',
    ]);

    $user->giveRoles('user', 'admin', 'moderator');

    $user->refresh();

    expect($user->roles)->toHaveCount(3);

    expect($user->hasRole('user', 'admin', 'moderator'))->toBeTrue();

    expect($user->hasRole('manager'))->toBeFalse();

    expect($user->hasRole('manager', 'admin', 'moderator'))->toBeTrue();

    expect($user->hasRole('admin'))->toBeTrue();
});

test('can check permissions', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    Permission::create([
        'name' => 'vew account settings',
    ]);

    $user->givePermissionTo('access admin area', 'update account settings', 'vew account settings');

    $user->refresh();

    expect($user->permissions)->toHaveCount(3);

    expect($user->hasPermissionTo('vew account settings'))->toBeTrue();

    expect($user->hasPermissionTo('modify account settings'))->toBeFalse();

    expect($user->hasPermissionTo('update account settings'))->toBeTrue();
});

test('can check role has permission', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    Permission::create([
        'name' => 'update account settings',
    ]);

    Permission::create([
        'name' => 'vew account settings',
    ]);

    $role = Role::updateOrCreate([
        'name' => 'admin',
    ]);

    $user->giveRoles('admin');

    $user->refresh();

    expect($user->permissions)->toHaveCount(0);

    $role->givePermissionTo('access admin area', 'update account settings');

    expect($user->hasPermissionTo('vew account settings'))->toBeFalse();

    expect($user->hasPermissionTo('modify account settings'))->toBeFalse();

    expect($user->hasPermissionTo('update account settings'))->toBeTrue();
});

test('has roles', function () {
    $user = $this->freshUser();

    expect($user->roles)->toHaveCount(0);

    $user->giveRoles('user');

    $user->refresh();

    expect($user->roles)->toHaveCount(1);
});

test('has permissions', function () {
    $user = $this->freshUser();

    Permission::create([
        'name' => 'access admin area',
    ]);

    expect($user->permissions)->toHaveCount(0);

    $user->givePermissionTo('access admin area');

    $user->refresh();

    expect($user->permissions)->toHaveCount(1);
});
