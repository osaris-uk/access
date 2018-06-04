<?php

Route::get('/access', function () {
    dd('access route');
});

Route::group(['prefix' => config('access.route.prefix'), 'middleware' => config('access.route.middleware')], function () {
    Route::get('/', 'OsarisUk\Access\Controllers\AccessController@index')->name('access.index');
});