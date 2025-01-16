<?php

namespace App\Http\Traits;

/**
 * Trait for authorizing actions.
 */
trait AuthorizesActions
{
    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    public function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
