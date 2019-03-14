<?php

return [

    /*
    |-------------------------------------------------------------------------
    | Access Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default access settings.  The default role is
    | assigned to all users on registration.
    |
    */

    'default' => [
        'role' => 'user',
    ],
    'routes' => [
        'name' => 'access',
        'prefix' => 'access',
        'middleware' => [
            'web',
            'access:admin'
        ]
    ],
];
