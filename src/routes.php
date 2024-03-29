<?php

use Illuminate\Support\Facades\Route;

Route::name(config('access.routes.name') . '.')->prefix(config('access.routes.prefix'))->middleware(config('access.routes.middleware'))->group(function () {
    Route::get('/', 'OsarisUk\Access\Controllers\AccessController@index')->name('index');

    Route::resource('/role', 'OsarisUk\Access\Controllers\RoleController')->only(['store', 'destroy']);
    Route::resource('/permission', 'OsarisUk\Access\Controllers\PermissionController')->only(['store', 'destroy']);

    Route::get('/roles', 'OsarisUk\Access\Controllers\AccessController@getUserRoles')->name('roles');
    Route::post('/roles', 'OsarisUk\Access\Controllers\AccessController@postUserRoles');

    Route::get('/rolepermissions', 'OsarisUk\Access\Controllers\AccessController@getRolePermissions')->name('rolepermissions');
    Route::post('/rolepermissions', 'OsarisUk\Access\Controllers\AccessController@postRolePermissions');
});
