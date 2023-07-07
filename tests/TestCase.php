<?php

namespace OsarisUk\Access\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use OsarisUk\Access\Models\Role;
use OsarisUk\Access\Tests\TestModels\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use OsarisUk\Access\AccessServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    /**
     * @param  Application  $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            AccessServiceProvider::class,
        ];
    }

    /**
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }

    /**
     * Set up the environment.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('access.routes.use_provided', true);
        $app['config']->set('access.default.roles', null);
        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Define routes setup.
     *
     * @param  Router  $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->middleware([
            'web',
        ])->get('/noRestrictionTest', function () {
            return true;
        })->name('noRestrictionTest');

        $router->middleware([
            'web',
            'access',
        ])->get('/noPermissionOrRoleTest', function () {
            return true;
        })->name('noPermissionOrRoleTest');

        $router->middleware([
            'web',
            'access:,view permission test route',
        ])->get('/permissionOnlyTest', function () {
            return true;
        })->name('permissionOnlyTest');

        $router->middleware([
            'web',
            'access:administrator,view permission test route',
        ])->get('/permissionAndRoleTest', function () {
            return true;
        })->name('permissionAndRoleTest');
    }

    /**
     * @return void
     */
    public function setupTestRoles($roles = ['admin'])
    {
        foreach ($roles as $role) {
            Role::updateOrCreate([
                'name' => $role,
            ]);
        }
    }

    public function user($assignRoles = null, $assignPermissions = null): User
    {
        User::truncate();

        $user = new User();

        $user->name = 'User';
        $user->email = 'user@email.com';
        $user->password = Hash::make('password');
        $user->save();

        if ($assignRoles) {
            $user->giveRoles($assignRoles);
        }

        if ($assignPermissions) {
            $user->givePermissionTo($assignPermissions);
        }

        return $user;
    }

    public function freshUser(): User
    {
        $user = new User();

        $user->name = 'User';
        $user->email = 'user@email.com';
        $user->password = Hash::make('password');
        $user->save();

        return $user;
    }
}