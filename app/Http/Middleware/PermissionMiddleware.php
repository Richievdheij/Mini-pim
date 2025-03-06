<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware for checking if the user has a specific permission.
 *
 */
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $permission)
    {
        // Check if the user is authenticated and has the required permission
        if (!Auth::check() || !Auth::user()->hasPermission($permission)) {
            // If the user is unauthorized, return a 403 response
            abort(403, 'Unauthorized access.');
        }

        // Continue to the next request
        return $next($request);
    }
}
