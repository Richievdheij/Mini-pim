<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (!Auth::check() || !Auth::user()->hasPermission($permission)) {
            // Als de gebruiker niet is ingelogd of de vereiste permissie niet heeft
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
