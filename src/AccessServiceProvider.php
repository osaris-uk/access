<?php

namespace OsarisUk\Access;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use OsarisUk\Access\Middleware\AccessMiddleware;
use OsarisUk\Access\Models\Permission;
use Illuminate\Support\ServiceProvider;

/**
 * Class AccessServiceProvider
 * @package OsarisUk\Access
 */
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

        if(config('access.routes.use_provided')) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');

            $this->loadViewsFrom(__DIR__.'/views', 'access');

            $this->publishes([
                __DIR__.'/views' => resource_path('views/vendor/access'),
            ], 'views');
        }

        try {
            Permission::get()->map(function (Permission $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission->name);
                });
            });
        } catch (\Exception $e) {
            Log::error($e);
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

        app('router')->aliasMiddleware('access', AccessMiddleware::class);
    }
}
