<?php

return [

    /*
    |-------------------------------------------------------------------------
    | Access Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default access settings.  The default role is
    | assigned to all users on registration.  Use the views setting to turn
    | access's admin templates and routes for on or off.
    |
    */

    'default' => [
        'role' => 'user',
        'views' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Access Routes
    |--------------------------------------------------------------------------
    |
    | This option controls the access admin routes.  The default route prefix is
    | /admin/access.  You can also add any custom middleware here too.
    |
    */

    'route' => [
        'prefix' => '/admin/access',
        'middleware' => [
            'web',
            'access:admin',
        ],
    ],

];
