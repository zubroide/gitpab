<?php

namespace App\Http\Middleware;

use Closure;

class RoutePermissionMiddleware
{

    protected $exclude = [
        'theme.switch'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permission = $request->route()->getName();

        if (!in_array($permission, $this->exclude) && !$request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
