<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Services\PermissionService;
use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct()
    {
        $this->permissionService = new PermissionService();
    }

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

        // Fetch all permissions and group them by category
        $permissions = Permission::all()->groupBy('category');

        // Return the view with profiles and permissions data
        return Inertia::render('User-rights/Index', [
            'profiles' => $profiles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Toggle permission for a profile
     *
     * @param PermissionRequest $request
     *
     * @return RedirectResponse
     */
    public function togglePermission(PermissionRequest $request): RedirectResponse
    {
        $this->authorizeAction('manage_permissions');

        // Use the PermissionService to toggle the permission
        $this->permissionService->togglePermission($request->profile_id, $request->permission_id);

        // Redirect back with a success message
        return back();
    }
}
