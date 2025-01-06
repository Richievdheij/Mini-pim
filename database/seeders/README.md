# Seeders Directory

This directory contains the database seeders used to populate the database with initial data. Seeders are used to set up default values, test data, and other necessary information for the application.

## Seeder Overview

### `AssignPermissionCategoriesSeeder.php`
Assigns categories to existing permissions.

### `AttributeSeeder.php`
Seeds product attributes.

### `AttributeValueSeeder.php`
Seeds values for product attributes.

### `DatabaseSeeder.php`
Main seeder that runs all other seeders.

### `PermissionSeeder.php`
Seeds permissions with titles and descriptions.

### `ProductSeeder.php`
Seeds products using factories.

### `ProductTypeSeeder.php`
Seeds product types.

### `ProfilePermissionSeeder.php`
Assigns all permissions to the Admin profile.

### `ProfileSeeder.php`
Seeds user profiles and assigns permissions.

### `RolesTableSeeder.php`
Seeds user roles.

### `UserProfileSeeder.php`
Assigns the Default profile to all users.

### `UserRoleSeeder.php`
Assigns the admin role to the first user.

## Notes
- Seeders are used to populate the database with initial data.
- Run the `DatabaseSeeder` to execute all seeders.

## Best Practices
- Keep seeders idempotent to avoid duplicate data.
- Use factories for generating test data.
- Document the purpose of each seeder.
