<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Validation\Rules\Password as PasswordRules;

class PimController extends Controller
{
    /**
     * Display the dashboard for authenticated users with the appropriate permission.
     */
    public function index(): Response
    {
        // Ensure the user has permission to view the dashboard
        $this->authorizeAction('view_dashboard');

        $user = auth()->user();

        // Render the dashboard view and pass the authenticated user data
        return Inertia::render('Dashboard', ['user' => $user]);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validate login request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        $credentials = $request->only('email', 'password');

        // Redirect to the dashboard if the login is successful
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        // Redirect back with an error message if the login fails
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    /**
     * Display a listing of users (for users with manage_users permission only).
     */
    public function showUsers(): Response
    {
        // Ensure the user has permission to view users
        $this->authorizeAction('view_users');

        $user = auth()->user();

        // Admin users (profile_id === 1) can view all users
        if ($user->profiles->first()->id === 1) {
            // Admin can see all users
            $users = User::with('profiles')->get();
        } else {
            // Non-admin users can only see users with the same profile_id
            $users = User::with('profiles')
                ->whereHas('profiles', function ($query) use ($user) {
                    $query->where('id', $user->profiles->first()->id);
                })
                ->get();
        }

        // Render the users view and pass the users data
        return Inertia::render('Users/Index', [
            'users' => $users,
            'profiles' => Profile::all(), // Add this to pass all profiles
            'canEditUser' => $user->hasPermission('edit_users'),
            'canDeleteUser' => $user->hasPermission('delete_users'),
            'canCreateUser' => $user->hasPermission('create_users'),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function createUser(): Response
    {
        // Ensure the user has permission to create users
        $this->authorizeAction('create_users');

        $user = auth()->user();

        // Admin users can see all profiles, others can only see their own profile
        if ($user->profiles->first()->id === 1) {
            // Admin can see all profiles
            $profiles = Profile::all();
        } else {
            // Non-admin users can only see their own profile
            $profiles = $user->profiles;
        }

        // Render the create user view and pass the profiles data
        return Inertia::render('Users/Create', ['profiles' => $profiles]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $this->authorizeAction('create_users');

        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                PasswordRules::min(8)
                    ->mixedCase() // At least one uppercase and one lowercase character
                    ->letters() // At least one letter
                    ->numbers() // At least one number
                    ->symbols(), // At least one special character
                function ($attribute, $value, $fail) use ($request) {
                    // Custom validation to ensure the password is not the same as an existing user's password
                    $user = User::where('email', $request->email)->first();
                    if ($user && Hash::check($value, $user->password)) {
                        $fail(__('The new password cannot be the same as your current password.'));
                    }
                },
            ],
            'profiles' => 'required|array|min:1', // Ensure at least one profile is selected
            'profiles.*' => 'exists:profiles,id', // Validate profile IDs
        ]);

        $user = auth()->user();

        // Create the user
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_id' => $user->profile_id, // Set the profile_id of the logged-in user
        ]);

        // Assign profiles
        $newUser->profiles()->sync($request->profiles);

        // Redirect to the users index page with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing an existing user.
     */
    public function editUser(User $user): Response
    {
        $this->authorizeAction('edit_users');

        // Get all profiles and the profiles of the user
        $profiles = Profile::all();
        $userProfiles = $user->profiles->pluck('id')->toArray();

        // Render the edit user view and pass the user and profiles data
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'profiles' => $profiles,
            'userProfiles' => $userProfiles,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->authorizeAction('edit_users');

        // Validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'profiles' => 'array',
        ]);

        // Update the user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Update the user's profiles if provided
        if ($request->has('profiles')) {
            $user->profiles()->sync($request->profiles);
        }

        // Redirect to the users index page with a success message
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Ensure the user has permission to delete users
        $this->authorizeAction('delete_users');

        // Delete the user
        $user->delete();

        // Redirect to the users index page with a success message
        return redirect()->route('users.index');
    }

    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    private function authorizeAction(string $permission): void
    {
        // Get the authenticated user
        $user = auth()->user();

        // Check if the user has the required permission
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
