<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (!Auth::check() || !Auth::user()->hasPermission($permission)) {
            // if the user isnt logged in or doesnt have the right permission
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
