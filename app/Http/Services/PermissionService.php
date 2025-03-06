<?php

namespace App\Http\Services;

use App\Models\Profile;

/**
 * Service for handling permission-related actions.
 *
 */
class PermissionService
{
    /**
     * Toggle the permission for a given profile.
     *
     * @param int $profileId
     * @param int $permissionId
     * @return void
     */
    public function togglePermission(int $profileId, int $permissionId): void
    {
        $profile = Profile::findOrFail($profileId);

        // Toggling permission using the toggle method
        $profile->permissions()->toggle($permissionId);
    }
}
