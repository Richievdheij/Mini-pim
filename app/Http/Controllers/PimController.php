<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class PimController extends Controller
{
    /**
     * Handle user login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the login data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in with the provided credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // If authentication is successful, redirect to the dashboard
            return redirect()->intended('dashboard');
        }

        // If login fails, redirect back to the login page with an error message
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    /**
     * Display the general dashboard for authenticated users.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $user = auth()->user();  // Get the authenticated user
        $roles = $user->roles;   // Get the user's roles

        // Pass the user and roles to the Vue dashboard component via Inertia
        return Inertia::render('Dashboard', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Display a listing of users (for admin users only).
     *
     * @return \Inertia\Response
     */
    public function showUsers()
    {
        $users = User::with('roles')->get(); // Eager-load the roles
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Inertia\Response
     */
    public function createUser(): Response
    {
        $roles = Role::all(); // Fetch all roles
        return Inertia::render('Users/Create', ['roles' => $roles]); // Pass the roles to the view
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUser(Request $request)
    {
        // Validate the incoming user data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'roles' => 'array', // Ensure roles is an array
        ]);

        // Create the new user with the provided data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password before storing
        ]);

        // Assign roles to the user
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        // Redirect back to the users list after successful creation
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing an existing user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function editUser(User $user): Response
    {
        // Load all roles to pass to the form and the user's current roles
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray(); // Get the role IDs the user currently has
        return Inertia::render('Users/Edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        // Validate the updated user data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8', // Password is optional on update
            'roles' => 'array', // Ensure roles is an array
        ]);

        // Update the user's data (only hash the password if it has been provided)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Update the user's roles
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        // Redirect back to the users list after successful update
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser(User $user)
    {
        // Delete the selected user
        $user->delete();

        // Redirect back to the users list after successful deletion
        return redirect()->route('users.index');
    }

    /**
     * Display the admin dashboard (for admin users only).
     *
     * @return \Inertia\Response
     */
    public function adminDashboard(): Response
    {
        // Check if the authenticated user has the 'admin' role
        if (auth()->user() && auth()->user()->roles->contains('name', 'admin')) {
            // The user has the 'admin' role, proceed to show the Vue admin dashboard
            return Inertia::render('Admin/Dashboard');  // Admin Dashboard Vue component
        } else {
            // If the user does not have the 'admin' role, deny access
            abort(403, 'Unauthorized.');
        }
    }

    /**
     * Manage users (for admin users only).
     *
     * @return \Inertia\Response
     */
    public function manageUsers(): Response
    {
        // Check if the authenticated user has the 'admin' role
        if (auth()->user() && auth()->user()->roles->contains('name', 'admin')) {
            // The user has the 'admin' role, proceed to manage users via Vue
            $users = User::all();
            return Inertia::render('Admin/ManageUsers', compact('users'));
        } else {
            // If the user does not have the 'admin' role, deny access
            abort(403, 'Unauthorized.');
        }
    }
}
