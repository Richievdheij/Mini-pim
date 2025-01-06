# Auth Controllers Directory

This directory contains the application's authentication controllers, which handle user authentication, session management, and password resets. Controllers are structured to separate concerns and facilitate maintainability.

## Controller Overview

### `AuthenticatedSessionController.php`
Manages user sessions, including login and logout operations.

- **Methods**:
    - `create()`: Displays the login view.
    - `store(LoginRequest $request)`: Handles an incoming authentication request.
    - `destroy(Request $request)`: Destroys an authenticated session.

---

### `ConfirmPasswordController.php`
Handles password confirmation for sensitive actions.

- **Methods**:
    - `show()`: Displays the password confirmation view.
    - `store(Request $request)`: Confirms the user's password.

---

### `EmailVerificationNotificationController.php`
Manages email verification notifications.

- **Methods**:
    - `store(Request $request)`: Sends a new email verification notification.

---

### `EmailVerificationPromptController.php`
Prompts users to verify their email addresses.

- **Methods**:
    - `__invoke(Request $request)`: Displays the email verification prompt.

---

### `NewPasswordController.php`
Handles the creation of new passwords.

- **Methods**:
    - `create(Request $request)`: Displays the password reset view.
    - `store(Request $request)`: Resets the user's password.

---

### `PasswordResetLinkController.php`
Manages password reset link requests.

- **Methods**:
    - `create()`: Displays the password reset link request view.
    - `store(Request $request)`: Sends a password reset link.

---

### `RegisteredUserController.php`
Handles user registration.

- **Methods**:
    - `create()`: Displays the registration view.
    - `store(Request $request)`: Registers a new user.

---

### `VerifyEmailController.php`
Handles email verification.

- **Methods**:
    - `__invoke(EmailVerificationRequest $request)`: Verifies the user's email address.

---

## Notes
- All controllers utilize **Inertia.js** for rendering Vue.js views.
- Comprehensive authorization checks ensure that actions are restricted based on user permissions.
- Laravel's validation features are used to enforce data integrity.

## Best Practices
- Focus each controller method on a single responsibility.
- Delegate complex business logic to service classes or traits.
- Use dependency injection to improve code testability and readability.
- Keep route-controller mappings documented and well-organized.
