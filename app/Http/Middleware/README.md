# Middleware Directory

This directory contains the application's middleware, which handle HTTP requests before they reach the application and can be used for various purposes, such as authentication, authorization, and sharing data with the frontend.

## Middleware Overview

### `CheckPermission.php`
Responsible for checking the permissions of the authenticated user.

- **Purpose:** Prevents access to certain routes if the user does not have the required permissions.
- **Usage:** Used in routes where access should be restricted based on user roles or specific permissions.
- **Function:** If the user is not logged in or does not have the required permission, a `403 Unauthorized action` error is returned.

---

### `HandleInertiaRequests.php`
Handles Inertia.js requests and shares data with the frontend.

- **Purpose:** Manages the root template and shared data for Inertia.js requests.
- **Usage:** Used to define the root view and share common data like the authenticated user and flash messages.
- **Function:** Shares the authenticated user and flash messages with the frontend.

---

### `LoadUserProfiles.php`
Loads the profiles of the authenticated user.

- **Purpose:** Ensures that the user's profiles are loaded and available for use in the application.
- **Usage:** Used in routes where user profiles are needed.
- **Function:** Loads the user's profiles if the user is authenticated.

---

### `PermissionMiddleware.php`
Checks if the authenticated user has the required permission.

- **Purpose:** Prevents access to certain routes if the user does not have the required permission.
- **Usage:** Used in routes where access should be restricted based on specific permissions.
- **Function:** If the user is unauthorized, returns a `403 Unauthorized access` error.

---

## Notes
- Middleware is used to process HTTP requests before they reach the application.
- Comprehensive authorization checks ensure that actions are restricted based on user permissions.
- Middleware can share data with the frontend, enforce authentication, and manage user profiles.

## Best Practices
- Focus each middleware on a single responsibility.
- Use middleware to enforce security and data integrity.
- Keep middleware logic simple and delegate complex tasks to service classes or traits.
- Document middleware usage and keep it well-organized.
