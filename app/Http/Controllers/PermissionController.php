<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Permission;
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
        $this->authorizeAction('view_permissions');

        // Fetch all profiles with their associated permissions
        $profiles = Profile::with('permissions')->get();

        // Fetch all permissions and group them by category, including the 'title'
        $permissions = Permission::all()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'title' => $permission->title ?? $permission->name, // Use 'title' if available, fallback to 'name'
                        'description' => $permission->description,
                        'category' => $permission->category,
                    ];
                });
            });

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
        $this->authorizeAction('manage_permissions');

        // Validate the incoming request
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        // Find the profile and permission by their IDs
        $profile = Profile::findOrFail($request->profile_id);
        $permission = Permission::findOrFail($request->permission_id);

        // Toggle permission assignment
        if ($profile->permissions()->where('id', $permission->id)->exists()) {
            $profile->permissions()->detach($permission->id); // Remove permission
        } else {
            $profile->permissions()->attach($permission->id); // Add permission
        }

        // Redirect back with a success message
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
     * Store a new profile
     *
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

    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        // Check if the user is authenticated and has the required permission
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
