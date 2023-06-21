<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use OsarisUk\Access\Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can access index', function () {
    $this->setupTestRoles();

    $user = $this->user('admin');

    $this->actingAs($user)->get(route('access.index'))->assertOk();
});

test('can get user roles', function () {
    $this->setupTestRoles();

    $user = $this->user('admin');

    $this->actingAs($user)->get(route('access.roles'))->assertOk();
});

test('can post user roles', function () {

});

test('can get role permissions', function () {
    $this->setupTestRoles();

    $user = $this->user('admin');

    $this->actingAs($user)->get(route('access.rolepermissions'))->assertOk();
});

test('can post role permissions', function () {

});
