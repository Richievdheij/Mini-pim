<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the profiles.
     *
     * @return Response
     */
    public function index(): Response
    {
        $user = auth()->user();

        // Check if the user has permission to view profiles
        $this->authorizeAction('view_profiles');

        // Get all profiles with their permissions
        $profiles = Profile::with('permissions')->get();

        return Inertia::render('Profiles/Index', [
            'profiles' => $profiles,
            'canEditProfile' => $user->hasPermission('edit_profiles'),
            'canDeleteProfile' => $user->hasPermission('delete_profiles'),
            'canCreateProfile' => $user->hasPermission('create_profiles'),
        ]);
    }

    /**
     * Show the form for creating a new profile.
     *
     * @return Response
     */
    public function create(): Response
    {
        $this->authorizeAction('create_profiles');

        // Retrieve all permissions to assign to the new profile
        $permissions = Permission::all();

        return Inertia::render('Profiles/CreateProfile', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created profile in the database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAction('create_profiles');

        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:profiles',
            'permissions' => 'array|exists:permissions,id',
        ]);

        // Create the new profile
        $profile = Profile::create([
            'name' => $request->name,
        ]);

        // Attach permissions if provided
        if ($request->has('permissions')) {
            $profile->permissions()->sync($request->permissions);
        }

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Show the form for editing the specified profile.
     *
     * @param Profile $profile
     * @return Response
     */
    public function edit(Profile $profile): Response
    {
        $this->authorizeAction('edit_profiles');

        // Retrieve all permissions and the permissions assigned to the profile
        $permissions = Permission::all();
        $assignedPermissions = $profile->permissions->pluck('id')->toArray();

        return Inertia::render('Profiles/EditProfile', [
            'profile' => $profile,
            'permissions' => $permissions,
            'assignedPermissions' => $assignedPermissions,
        ]);
    }

    /**
     * Update the specified profile in the database.
     *
     * @param Request $request
     * @param Profile $profile
     * @return RedirectResponse
     */
    public function update(Request $request, Profile $profile): RedirectResponse
    {
        $this->authorizeAction('edit_profiles');

        // Validate the request data
        $request->validate([
            'name' => 'required|string|unique:profiles,name,' . $profile->id,
            'permissions' => 'array|exists:permissions,id',
        ]);

        // Update the profile's name
        $profile->update([
            'name' => $request->name,
        ]);

        // Sync the permissions for the profile
        $profile->permissions()->sync($request->permissions);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified profile from the database.
     *
     * @param Profile $profile
     * @return RedirectResponse
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        $this->authorizeAction('delete_profiles');

        // Delete the profile
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }

    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        // Abort with a 403 error if the user is unauthorized
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
