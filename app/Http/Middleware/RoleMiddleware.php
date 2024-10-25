<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || !Auth::user()->roles->contains('name', $role)) {
            // If the user is not authenticated or doesn't have the role, abort
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
