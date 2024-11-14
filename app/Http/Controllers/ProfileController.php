<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display a list of profiles with permissions.
     */
    public function index(): Response
    {
        // Fetch all profiles with their permissions
        $profiles = Profile::with('permissions')->get();
        $permissions = Permission::all(); // Fetch all available permissions

        return Inertia::render('Admin/ManageProfiles', [
            'profiles' => $profiles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for creating a new profile.
     */
    public function create(): Response
    {
        $this->authorizeAction('create_profiles');

        $permissions = Permission::all();
        return Inertia::render('Admin/CreateProfile', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created profile in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAction('create_profiles');

        $request->validate([
            'name' => 'required|string|unique:profiles',
            'permissions' => 'array|exists:permissions,id',
        ]);

        $profile = Profile::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $profile->permissions()->sync($request->permissions);
        }

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Show the form for editing an existing profile.
     */
    public function edit(Profile $profile): Response
    {
        $this->authorizeAction('edit_profiles');

        $permissions = Permission::all();
        return Inertia::render('Profile/Edit', [
            'profile' => $profile,
            'permissions' => $permissions,
            'assignedPermissions' => $profile->permissions->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified profile in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $this->authorizeAction('edit_profiles');

        $request->validate([
            'name' => 'required|string|unique:profiles,name,' . $profile->id,
            'permissions' => 'array|exists:permissions,id',
        ]);

        $profile->update(['name' => $request->name]);
        $profile->permissions()->sync($request->permissions);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified profile from storage.
     */
    public function destroy(Profile $profile)
    {
        $this->authorizeAction('delete_profiles');

        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }

    /**
     * Helper function to authorize an action based on a given permission.
     *
     * @param string $permission
     * @return void
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
