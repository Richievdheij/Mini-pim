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
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    /**
     * Display the dashboard for authenticated users with the appropriate permission.
     */
    public function index(): Response
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('view_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Dashboard', ['user' => $user]);
    }

    /**
     * Display a listing of users (for users with manage_users permission only).
     */
    public function showUsers(): Response
    {
        $user = auth()->user();

        // Make sure permissions match what you have in the database
        return Inertia::render('Users/Index', [
            'users' => User::with('profiles')->get(),
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
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_users')) {
            abort(403, 'Unauthorized action.');
        }

        $profiles = Profile::all();
        return Inertia::render('Users/Create', ['profiles' => $profiles]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_users')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed', // Ensure password matches confirmation field
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

        // Create the user
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign profiles
        $newUser->profiles()->sync($request->profiles);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing an existing user.
     */
    public function editUser(User $user): Response
    {
        $currentUser = auth()->user();

        if (!$currentUser || !$currentUser->hasPermission('edit_users')) {
            abort(403, 'Unauthorized action.');
        }

        $profiles = Profile::all();
        $userProfiles = $user->profiles->pluck('id')->toArray();

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
        $currentUser = auth()->user();

        if (!$currentUser || !$currentUser->hasPermission('edit_users')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'profiles' => 'array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($request->has('profiles')) {
            $user->profiles()->sync($request->profiles);
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser || !$currentUser->hasPermission('delete_users')) {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('users.index');
    }
}
