<?php

namespace App\Http\Services;

use App\Models\Profile;
use App\Models\Permission;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service class for handling profile related operations,
 * such as creating, updating, and deleting profiles.
 * This class is responsible for interacting with the Profile model.
 *
 */
class ProfileService
{
    /**
     * Get all profiles.
     *
     * @return Collection
     */
    public function getAllProfiles(): Collection
    {
        return Profile::with('permissions')->get();
    }

    /**
     * Get all permissions.
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Get assigned permissions for a profile.
     *
     * @param Profile $profile
     *
     * @return array
     */
    public function getAssignedPermissions(Profile $profile): array
    {
        // Return an array of permission IDs assigned to the profile
        return $profile->permissions->pluck('id')->toArray();
    }

    /**
     * Create a new profile.
     *
     * @param array $data
     *
     * @return void
     */
    public function createProfile(array $data): void
    {
        // Create a new profile with the given name
        $profile = Profile::create(['name' => $data['name']]);
        if (isset($data['permissions'])) {
            $profile->permissions()->sync($data['permissions']);
        }
    }

    /**
     * Update a profile.
     *
     * @param Profile $profile
     * @param array $data
     *
     * @return void
     */
    public function updateProfile(Profile $profile, array $data): void
    {
        // Update the profile name and permissions
        $profile->update(['name' => $data['name']]);
        $profile->permissions()->sync($data['permissions'] ?? []);
    }

    /**
     * Delete a profile.
     *
     * @param Profile $profile
     *
     * @return void
     *
     * @throws Exception
     */
    public function deleteProfile(Profile $profile): void
    {
        // Check if the profile is assigned to users
        if ($profile->users()->exists()) {
            throw new Exception('Profile is assigned to users and cannot be deleted.');
        }
        $profile->delete();
    }
}
