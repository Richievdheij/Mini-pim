<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PimModel;
use App\Models\User;

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
     * Display the dashboard
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Render the dashboard without any additional data (you can add data later if needed)
        return Inertia::render('Dashboard');
    }

    /**
     * Display a listing of users.
     *
     * @return \Inertia\Response
     */
    public function showUsers()
    {
        $users = User::all(); // Retrieve all users
        return Inertia::render('Users/Index', ['users' => $users]); // Pass the users data to the Inertia component
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Inertia\Response
     */
    public function createUser()
    {
        return Inertia::render('Users/Create'); // Render the form for creating a new user
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
        ]);

        // Create the new user with the provided data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password before storing
        ]);

        // Redirect back to the users list after successful creation
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing an existing user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function editUser(User $user)
    {
        // Render the form for editing the selected user
        return Inertia::render('Users/Edit', ['user' => $user]);
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
        ]);

        // Update the user's data (only hash the password if it has been provided)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

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
}
