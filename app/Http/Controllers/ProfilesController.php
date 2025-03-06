<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Services\ProfileService;
use App\Models\Profile;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller handles all profile related actions, such as displaying, creating, editing, and deleting profiles.
 *
 */
class ProfilesController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the profiles.
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->authorizeAction('view_profiles');

        return Inertia::render('Profiles/Index', [
            'profiles' => $this->profileService->getAllProfiles(),
            'canEditProfile' => Auth::user()->hasPermission('edit_profiles'),
            'canDeleteProfile' => Auth::user()->hasPermission('delete_profiles'),
            'canCreateProfile' => Auth::user()->hasPermission('create_profiles'),
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

        return Inertia::render('Profiles/CreateProfile', [
            'permissions' => $this->profileService->getAllPermissions(),
        ]);
    }

    /**
     * Store a newly created profile in the database.
     *
     * @param ProfileRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProfileRequest $request): RedirectResponse
    {
        $this->authorizeAction('create_profiles');

        // Create a new profile with the validated data
        $this->profileService->createProfile($request->validated());

        return redirect()->route('profiles.index');
    }

    /**
     * Show the form for editing the specified profile.
     *
     * @param Profile $profile
     *
     * @return Response
     */
    public function edit(Profile $profile): Response
    {
        $this->authorizeAction('edit_profiles');

        return Inertia::render('Profiles/EditProfile', [
            'profile' => $profile,
            'permissions' => $this->profileService->getAllPermissions(),
            'assignedPermissions' => $this->profileService->getAssignedPermissions($profile),
        ]);
    }

    /**
     * Update the specified profile in the database.
     *
     * @param ProfileRequest $request
     * @param Profile $profile
     *
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request, Profile $profile): RedirectResponse
    {
        $this->authorizeAction('edit_profiles');

        // Update the profile with the validated data
        $this->profileService->updateProfile($profile, $request->validated());

        return redirect()->route('profiles.index');
    }

    /**
     * Remove the specified profile from the database.
     *
     * @param Profile $profile
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        $this->authorizeAction('delete_profiles');

        // Delete the profile
        $this->profileService->deleteProfile($profile);

        return back();
    }
}
