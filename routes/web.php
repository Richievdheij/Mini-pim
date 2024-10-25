<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PimController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Authenticated user routes (requires user to be logged in)
    Route::middleware('auth')->group(function () {
    // General dashboard for authenticated users
    Route::get('/dashboard', [PimController::class, 'index'])->name('dashboard');

    // Route for profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for managing users (CRUD)
    Route::get('/users', [PimController::class, 'showUsers'])->name('users.index'); // Show list of users
    Route::get('/users/create', [PimController::class, 'createUser'])->name('users.create'); // Show form to create user
    Route::post('/users', [PimController::class, 'storeUser'])->name('users.store'); // Store new user
    Route::get('/users/{user}/edit', [PimController::class, 'editUser'])->name('users.edit'); // Show form to edit user
    Route::put('/users/{user}', [PimController::class, 'updateUser'])->name('users.update'); // Update user
    Route::delete('/users/{user}', [PimController::class, 'destroyUser'])->name('users.destroy'); // Delete user
});

// Admin-only routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->roles->contains('name', 'admin')) {
            return Inertia::render('Admin/Dashboard');
        } else {
            abort(403, 'Unauthorized.');
        }
    })->name('admin.dashboard');

    Route::get('/admin/manage-users', function () {
        if (auth()->user()->roles->contains('name', 'admin')) {
            $users = \App\Models\User::all();
            return Inertia::render('Admin/ManageUsers', compact('users'));
        } else {
            abort(403, 'Unauthorized.');
        }
    })->name('admin.manageUsers');
});

// Auth routes
require __DIR__.'/auth.php';
