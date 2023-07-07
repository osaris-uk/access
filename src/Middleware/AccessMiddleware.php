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
     * @param string|null $roles
     * @param string|null $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $roles = null, string $permission = null)
    {
        abort_if(!$request->user() || (empty($roles) && empty($permission)), 404);

        if (!empty($permission)) {
            if ($request->user()->can($permission)) {
                return $next($request);
            }

            abort(404);
        }

        if (!empty($roles)) {
            if ($request->user()->hasRole(... explode('|', $roles))) {
                return $next($request);
            }

            abort(404);
        }
    }
}
//