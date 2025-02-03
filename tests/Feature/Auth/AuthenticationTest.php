<?php

// Run these tests using the command: php artisan test --filter=AuthenticationTest

use App\Models\User;

// Test 1: Checks if the login page is rendered correctly.
test('login screen can be rendered', function () {
    $response = $this->get('/login');

    // Assert that the server returns a 200 status code (page successfully rendered).
    $response->assertStatus(200);
});

// Test 2: Verifies that users can log in with valid credentials.
test('users can authenticate using the login screen', function () {
    // Create a test user using a factory.
    $user = User::factory()->create();

    // Simulate a login attempt with the correct user credentials.
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Default password set in the factory.
    ]);

    // Check if the user is authenticated.
    $this->assertAuthenticated();
    // Verify that the user is redirected to the dashboard after login.
    $response->assertRedirect(route('dashboard', absolute: false));
});

// Test 3: Ensures that users cannot log in with an invalid password.
test('users can not authenticate with invalid password', function () {
    // Create a test user using a factory.
    $user = User::factory()->create();

    // Simulate a login attempt with an incorrect password.
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    // Ensure that the user is not authenticated and remains a guest.
    $this->assertGuest();
});

// Test 4: Verifies that users can log out correctly.
test('users can logout', function () {
    // Create a test user using a factory.
    $user = User::factory()->create();

    // Simulate a logout action for an authenticated user.
    $response = $this->actingAs($user)->post('/logout');

    // Ensure that the user is logged out and is now a guest.
    $this->assertGuest();
    // Verify that the user is redirected to the homepage after logging out.
    $response->assertRedirect('/');
});
