# Controllers Directory

This directory contains the application's controllers, responsible for handling HTTP requests, interacting with models, and rendering responses. The controllers are organized based on their specific functionalities.

## Controller Overview

### `AccountController.php`
Handles account management for authenticated users, such as editing account details, updating profile information, and deleting accounts.

- **Methods**:
    - `edit(Request $request)`: Displays the account edit form.
    - `update(ProfileUpdateRequest $request)`: Updates the account details.
    - `destroy(Request $request)`: Deletes the user's account.

---

### `PermissionController.php`
Manages permissions and user rights, including profiles and permission assignments.

- **Methods**:
    - `index()`: Displays all profiles and their permissions.
    - `togglePermission(Request $request)`: Toggles a permission for a specific profile.
    - `createProfile()`: Shows the form for creating a new profile.
    - `storeProfile(Request $request)`: Stores a new profile in the database.

---

### `PimController.php`
Handles core PIM-related actions, including authentication, user management, and displaying the dashboard.

- **Methods**:
    - `login(Request $request)`: Authenticates a user.
    - `index()`: Displays the dashboard for users with appropriate permissions.
    - `showUsers()`: Lists all users and associated profiles.
    - `createUser()`: Displays the form for creating a new user.
    - `storeUser(Request $request)`: Stores a newly created user.
    - `editUser(User $user)`: Displays the form for editing an existing user.
    - `updateUser(Request $request, User $user)`: Updates user details.
    - `destroyUser(User $user)`: Deletes a user.

---

### `ProfilesController.php`
Manages user profiles and their associated permissions.

- **Methods**:
    - `index()`: Displays a list of all profiles and their permissions.
    - `create()`: Shows the form for creating a new profile.
    - `store(Request $request)`: Stores a newly created profile.
    - `edit(Profile $profile)`: Displays the form for editing a profile.
    - `update(Request $request, Profile $profile)`: Updates an existing profile.
    - `destroy(Profile $profile)`: Deletes a profile.

---

### `Controller.php`
An abstract base controller that other controllers extend. Currently, it serves as a placeholder for shared controller logic.

---

## Notes
- All controllers use **Inertia.js** for rendering responses in a Vue.js frontend.
- Authorization checks are implemented to restrict actions based on user permissions.
- Validation is handled through Laravel's built-in validation features.

## Best Practices
- Keep controller methods focused and delegate complex logic to service classes or traits.
- Use dependency injection wherever possible for cleaner, testable code.
- Maintain clear documentation of all routes and their corresponding controller actions.
