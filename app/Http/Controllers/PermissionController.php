<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    /**
     * Show the page to manage permissions/user rights for profiles
     *
     * @return Response
     */
    public function index(): Response
    {
        // Fetch all profiles with their associated permissions
        $profiles = Profile::with('permissions')->get();

        // Fetch all permissions
        $permissions = Permission::all();

        // Return the view with profiles and permissions data
        return Inertia::render('User-rights/Index', [
            'profiles' => $profiles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Toggle permission for a profile
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function togglePermission(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        // Find the profile and permission by their IDs
        $profile = Profile::findOrFail($request->profile_id);
        $permission = Permission::findOrFail($request->permission_id);

        // Check if the profile already has the permission attached
        if ($profile->permissions()->where('id', $permission->id)->exists()) {
            // Detach the permission if it already exists
            $profile->permissions()->detach($permission->id);
        } else {
            // Attach the permission if it does not exist
            $profile->permissions()->attach($permission->id);
        }

        // Redirect back without a JSON response
        return back()->with('success', 'Permission updated successfully.');
    }


    /**
     * Create profile method
     *
     * @return Response
     */
    public function createProfile(): Response
    {
        return Inertia::render('Profiles/Create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeProfile(Request $request): RedirectResponse
    {
        // Validate profile name
        $request->validate([
            'name' => 'required|string|unique:profiles,name',
        ]);

        // Create the new profile
        Profile::create([
            'name' => $request->name,
        ]);

        // Redirect to the profiles index
        return redirect()->route('profiles.index');
    }
}
