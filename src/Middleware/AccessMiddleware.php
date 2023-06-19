<?php

namespace OsarisUk\Access\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class AccessMiddleware
 * @package OsarisUk\Access\Middleware
 */
class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $roles
     * @param string|null $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles, string $permission = null)
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
