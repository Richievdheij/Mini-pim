# Middleware in `app/Http/Middleware`

This directory contains the middleware for the application. Middleware is responsible for processing HTTP requests before they reach the application and can be used for various purposes, such as authentication, authorization, and sharing data with the frontend.

---

## **Middleware Files**

### **1. `CheckPermission.php`**
Responsible for checking the permissions of the authenticated user.
- **Purpose:** Prevents access to certain routes if the user does not have the required permissions.
- **Usage:** Used in routes where access should be restricted based on user roles or specific permissions.
- **Function:** If the user is not logged in or does not have the required permission, a `403 Unauthorized action` error is returned.

```php
public function handle($request, Closure $next, $permission)
{
    if (!Auth::user() || !Auth::user()->hasPermission($permission)) {
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
