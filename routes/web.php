<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PimController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authenticated user routes (requires user to be logged in)
Route::middleware('auth')->group(function () {

    // General Dashboard for Authenticated Users
    Route::get('/dashboard', [PimController::class, 'index'])->name('dashboard');

    // User Profile Settings (for the logged-in user's settings)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // User Management (CRUD) - For managing users within the system
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [PimController::class, 'showUsers'])->name('index');
        Route::get('/create', [PimController::class, 'createUser'])->name('create');
        Route::post('/', [PimController::class, 'storeUser'])->name('store');
        Route::get('/{user}/edit', [PimController::class, 'editUser'])->name('edit');
        Route::put('/{user}', [PimController::class, 'updateUser'])->name('update');
        Route::delete('/{user}', [PimController::class, 'destroyUser'])->name('destroy');
    });

    // Profile Management
    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index'); // Lists profiles
        Route::get('/create', [ProfileController::class, 'create'])->name('create'); // Form to create a profile
        Route::post('/', [ProfileController::class, 'store'])->name('store'); // Stores new profile
        Route::get('/{profile}/edit', [ProfileController::class, 'edit'])->name('edit'); // Edit a profile
        Route::put('/{profile}', [ProfileController::class, 'update'])->name('update'); // Update profile
        Route::delete('/{profile}', [ProfileController::class, 'destroy'])->name('destroy'); // Delete profile
    });

    // Permission Management within profiles
    Route::prefix('/user-rights')->group(function () {
        Route::get('/', [PimController::class, 'managePermissions'])->name('profiles.manage-permissions'); // Page to manage permissions for profiles
        Route::post('/', [PimController::class, 'togglePermission'])->name('profiles.toggle-permission'); // Action to toggle a permission
    });
});

// Auth routes (for user authentication)
require __DIR__.'/auth.php';
