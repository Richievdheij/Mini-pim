<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    // Show the page to manage permissions for profiles
    public function index(): Response
    {
        $profiles = Profile::with('permissions')->get();
        $permissions = Permission::all();

        return Inertia::render('Admin/ManagePermissions', [
            'profiles' => $profiles,
            'permissions' => $permissions,
        ]);
    }

    // Toggle permission for a profile
    public function togglePermission(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $profile = Profile::findOrFail($request->profile_id);
        $permission = Permission::findOrFail($request->permission_id);

        if ($profile->permissions()->where('id', $permission->id)->exists()) {
            $profile->permissions()->detach($permission->id);
        } else {
            $profile->permissions()->attach($permission->id);
        }

        return response()->json(['status' => 'success']);
    }

    // Show the form to create a new profile with permissions
    public function createProfile(): Response
    {
        return Inertia::render('Admin/CreateProfile');
    }

    // Store a new profile and assign permissions
    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:profiles,name',
            'permissions' => 'array',
        ]);

        $profile = Profile::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $profile->permissions()->sync($request->permissions);
        }

        return redirect()->route('permissions.index');
    }
}
