<?php

namespace OsarisUk\Access\Middleware;

use Closure;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(404);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
