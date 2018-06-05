<?php

namespace OsarisUk\Access;

use Gate;
use OsarisUk\Access\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/access.php' => config_path('access.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            return false;
        }

        Blade::directive('role', function ($role) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$role})): ?>";
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/access.php', 'access'
        );

        $this->app['router']->aliasMiddleware('access', \OsarisUk\Access\Middleware\AccessMiddleware::class);
    }
}
