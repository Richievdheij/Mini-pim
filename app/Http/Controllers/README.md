# Controllers Directory

This directory contains the application's controllers, which handle HTTP requests, interact with models, and render responses. Controllers are structured to separate concerns and facilitate maintainability.

## Controller Overview

### `AccountController.php`
Handles account-related operations for authenticated users.

- **Methods**:
    - `edit(Request $request)`: Displays the form for editing account details.
    - `update(ProfileUpdateRequest $request)`: Updates the account information.
    - `destroy(Request $request)`: Deletes the user's account.

---

### `AttributeController.php`
Manages product attributes, including creation, editing, and deletion.

- **Methods**:
    - `index()`: Lists all attributes for the user's profile.
    - `create()`: Displays the form for adding a new attribute.
    - `store(Request $request)`: Saves a new attribute.
    - `edit(Attribute $attribute)`: Displays the form for editing an attribute.
    - `update(Request $request, Attribute $attribute)`: Updates an existing attribute.
    - `destroy(Attribute $attribute)`: Deletes an attribute, if no associated products exist.

---

### `AttributeValueController.php`
Handles management of attribute values for products.

- **Methods**:
    - `index()`: Lists all attribute values for the user's profile.
    - `store(Request $request)`: Saves a new attribute value.
    - `destroy(ProductAttributeValue $productAttributeValue)`: Deletes an attribute value.
    - `getAttributesWithValues($typeId)`: Retrieves all attributes and their values for a specific product type.

---

### `PermissionController.php`
Manages permissions and profiles, including assignment and toggling of permissions.

- **Methods**:
    - `index()`: Lists all profiles with their permissions.
    - `togglePermission(Request $request)`: Toggles a specific permission for a profile.
    - `createProfile()`: Displays the form for creating a new profile.
    - `storeProfile(Request $request)`: Saves a new profile in the database.

---

### `PimController.php`
Facilitates core PIM functionalities, such as authentication, user management, and dashboard access.

- **Methods**:
    - `login(Request $request)`: Authenticates a user.
    - `index()`: Displays the dashboard.
    - `showUsers()`: Lists all users and their profiles.
    - `createUser()`: Displays the form for adding a new user.
    - `storeUser(Request $request)`: Stores a newly created user.
    - `editUser(User $user)`: Displays the form for editing a user.
    - `updateUser(Request $request, User $user)`: Updates user details.
    - `destroyUser(User $user)`: Deletes a user.

---

### `ProductController.php`
Manages products, including creation, editing, and deletion.

- **Methods**:
    - `dashboard()`: Displays the dashboard.
    - `index()`: Lists all products for the user's profile.
    - `create()`: Displays the form for adding a new product.
    - `store(Request $request)`: Saves a new product.
    - `edit($id)`: Displays the form for editing a product.
    - `update(Request $request, Product $product)`: Updates an existing product.
    - `destroy(Product $product)`: Deletes a product.
- **Shared Method**:
    - `authorizeOwnership(Product $product)`: Checks if the authenticated user owns the product. Aborts with a 403 error if unauthorized.

---

### `ProductTypeController.php`
Handles management of product types for the PIM system.

- **Methods**:
    - `index()`: Displays all product types for the user's profile.
    - `create()`: Displays the form for adding a new product type.
    - `store(Request $request)`: Saves a new product type.
    - `edit(ProductType $productType)`: Displays the form for editing a product type.
    - `update(Request $request, ProductType $productType)`: Updates an existing product type.
    - `destroy(ProductType $productType)`: Deletes a product type, if no associated attributes exist.

---

### `ProfilesController.php`
Manages user profiles and their assigned permissions.

- **Methods**:
    - `index()`: Lists all profiles with their permissions.
    - `create()`: Displays the form for creating a new profile.
    - `store(Request $request)`: Saves a new profile and its permissions.
    - `edit(Profile $profile)`: Displays the form for editing a profile and its permissions.
    - `update(Request $request, Profile $profile)`: Updates a profile and syncs its permissions.
    - `destroy(Profile $profile)`: Deletes a profile, if it is not assigned to any users.

---

### `Controller.php`
A base controller class extended by all other controllers. It provides shared logic and utility methods.

- **Shared Method**:
    - `authorizeAction(string $permission)`: Checks if the authenticated user has a specific permission. Aborts with a 403 error if unauthorized.

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
