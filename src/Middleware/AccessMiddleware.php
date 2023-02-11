<?php

namespace OsarisUk\Access\Middleware;

use Closure;

/**
 * Class AccessMiddleware
 * @package OsarisUk\Access\Middleware
 */
class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $roles
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, string $roles, $permission = null)
    {
        if (!$request->user() || (!empty($permission) && !$request->user()->can($permission))) {
            abort(404);
        }

        if (!empty($roles) && !$request->user()->hasRole(... explode('|', $roles))) {
            abort(404);
        }

        return $next($request);
    }
}
