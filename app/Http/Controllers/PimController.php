<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller responsible for handling user-related actions, such as viewing, creating, updating, and deleting users.
 * It ensures the correct permissions are in place for each action and delegates business logic to the UserService.
 */
class PimController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the PIM dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->authorizeAction('view_dashboard');

        return Inertia::render('Dashboard', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Display the users index page.
     *
     * @return Response
     */
    public function showUsers(): Response
    {
        $this->authorizeAction('view_users');

        // Get users based on the user's profile with the function in the UserService
        $users = $this->userService->getUsersForAuthUser(Auth::user());
        $profiles = $this->userService->getProfilesForAuthUser(Auth::user());

        return Inertia::render('Users/Index', [
            'users' => $users,
            'profiles' => $profiles,
            'canEditUser' => Auth::user()->hasPermission('edit_users'),
            'canDeleteUser' => Auth::user()->hasPermission('delete_users'),
            'canCreateUser' => Auth::user()->hasPermission('create_users'),
        ]);
    }

    /**
     * Display the create user page.
     *
     * @return Response
     */
    public function createUser(): Response
    {
        $this->authorizeAction('create_users');

        // Get profiles based on the user's profile with the function in the UserService
        $profiles = $this->userService->getProfilesForAuthUser(Auth::user());

        return Inertia::render('Users/Create', ['profiles' => $profiles]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     *
     * @return RedirectResponse
     */
    public function storeUser(UserRequest $request): RedirectResponse
    {
        $this->authorizeAction('create_users');

        // Store the user with the function in the UserService
        $this->userService->storeUser($request);

        return redirect()->route('users.index');
    }

    /**
     * Display the edit user page.
     *
     * @param User $user
     *
     * @return Response
     */
    public function editUser(User $user): Response
    {
        $this->authorizeAction('edit_users');

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'profiles' => Profile::all(),
            'userProfiles' => $user->profiles->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function updateUser(UserRequest $request, User $user): RedirectResponse
    {
        $this->authorizeAction('edit_users');

        // Update the user with the function in the UserService
        $this->userService->updateUser($request, $user);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroyUser(User $user): RedirectResponse
    {
        $this->authorizeAction('delete_users');

        // Delete the user with the function in the UserService
        $this->userService->deleteUser($user);

        return redirect()->route('users.index');
    }
}
