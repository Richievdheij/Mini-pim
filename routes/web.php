<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PimController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoadUserProfiles;

// Root Route
Route::get('/', static function () {
    return redirect()->route('login');  // Redirects '/' to the login page
});

// Authenticated user routes (requires user to be logged in)
Route::middleware(['auth', LoadUserProfiles::class])->group(function () {

    // General Dashboard for Authenticated Users
    Route::get('/dashboard', [PimController::class, 'index'])->name('dashboard');

    // User Account Settings (for the logged-in user's settings)
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'edit'])->name('edit');
        Route::patch('/', [AccountController::class, 'update'])->name('update');
        Route::delete('/', [AccountController::class, 'destroy'])->name('destroy');
    });

    // Add Pim Account Settings route
    Route::prefix('pim/account')->name('pim.account.')->group(function () {
        Route::get('/', [AccountController::class, 'editPim'])->name('edit');
        Route::patch('/', [AccountController::class, 'update'])->name('update');
        Route::delete('/', [AccountController::class, 'destroy'])->name('destroy');
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

    // Profiles Management
    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get('/', [ProfilesController::class, 'index'])->name('index'); // Lists profiles
        Route::get('/create', [ProfilesController::class, 'create'])->name('create'); // Form to create a profile
        Route::post('/', [ProfilesController::class, 'store'])->name('store'); // Stores new profile
        Route::get('/{profile}/edit', [ProfilesController::class, 'edit'])->name('edit'); // Edit a profile
        Route::put('/{profile}', [ProfilesController::class, 'update'])->name('update'); // Update profile
        Route::delete('/{profile}', [ProfilesController::class, 'destroy'])->name('destroy'); // Delete profile
    });

    // User-rights/Permission Management within profiles
    Route::prefix('user-rights')->name('user-rights.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index'); // Page to manage permissions for profiles
        Route::post('/', [PermissionController::class, 'togglePermission'])->name('update'); // Action to toggle a permission
    });

    // PIM Routes - Root route is /pim
    Route::prefix('pim')->name('pim.')->group(function () {
        Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard'); // PIM Dashboard

        Route::resource('products', ProductController::class) // Product Management
            ->except(['show']) // No show page for products
            ->names([
                'index' => 'products.index',
                'create' => 'products.create',
                'store' => 'products.store',
                'edit' => 'products.edit',
                'update' => 'products.update',
                'destroy' => 'products.destroy',
            ]);

        // Product Types Management
        Route::resource('product-types', ProductTypeController::class)
            ->except(['show']) // No show page for product types
            ->names([
                'index' => 'types.index',
                'create' => 'types.create',
                'store' => 'types.store',
                'edit' => 'types.edit',
                'update' => 'types.update',
                'destroy' => 'types.destroy',
            ]);

        // Attributes Management
        Route::resource('attributes', AttributeController::class)
            ->except(['show']) // No show page for attributes
            ->names([
                'index' => 'attributes.index',
                'create' => 'attributes.create',
                'store' => 'attributes.store',
                'edit' => 'attributes.edit',
                'update' => 'attributes.update',
                'destroy' => 'attributes.destroy',
            ]);

        // Attribute Values Management
        Route::resource('attribute-values', AttributeValueController::class)
            ->except(['show']) // No show page for attribute values
            ->names([
                'index' => 'attribute-values.index',
                'create' => 'attribute-values.create',
                'store' => 'attribute-values.store',
                'edit' => 'attribute-values.edit',
                'update' => 'attribute-values.update',
                'destroy' => 'attribute-values.destroy',
            ]);

        // Product Type-specific Attributes
        Route::get('/types/{typeId}/attributes', [AttributeValueController::class, 'getAttributesWithValues'])->name('types.attributes');

    });
});

// Auth routes (for user authentication) - Place all password reset and guest routes in `auth.php`
require __DIR__ . '/auth.php';
