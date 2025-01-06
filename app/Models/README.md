# Models Directory

This directory contains the application's models, which represent the data and business logic of the application. Models are structured to separate concerns and facilitate maintainability.

## Model Overview

### `Account.php`
Handles account-related data and relationships.

- **Attributes**:
    - `name`: The name of the account.
- **Relationships**:
    - `permissions()`: Belongs to many `Permission`.
    - `users()`: Belongs to many `User`.

---

### `Attribute.php`
Manages product attributes.

- **Attributes**:
    - `name`: The name of the attribute.
    - `type_id`: Foreign key to `ProductType`.
    - `profile_id`: Foreign key to `Profile`.
- **Relationships**:
    - `profile()`: Belongs to `Profile`.
    - `type()`: Belongs to `ProductType`.
    - `values()`: Has many `AttributeValue`.
    - `attributeValues()`: Has many `ProductAttributeValue`.

---

### `AttributeValue.php`
Handles attribute values for products.

- **Attributes**:
    - `attribute_id`: Foreign key to `Attribute`.
    - `value`: The actual value (e.g., "Red", "Large").
    - `profile_id`: Foreign key to `Profile`.
- **Relationships**:
    - `profile()`: Belongs to `Profile`.
    - `attribute()`: Belongs to `Attribute`.

---

### `Permission.php`
Manages permissions.

- **Attributes**:
    - `name`: The name of the permission.
    - `description`: The description of the permission.
- **Relationships**:
    - `profiles()`: Belongs to many `Profile`.

---

### `PimModel.php`
A base model class for PIM-related models.

---

### `Product.php`
Handles product data and relationships.

- **Attributes**:
    - `product_id`: SKU.
    - `name`: The name of the product.
    - `type_id`: Foreign key to `ProductType`.
    - `profile_id`: Foreign key to `Profile`.
    - `weight`: The weight of the product.
    - `description`: The description of the product.
    - `price`: The price of the product.
    - `stock_quantity`: The stock quantity of the product.
- **Relationships**:
    - `profiles()`: Belongs to many `Profile`.
    - `type()`: Belongs to `ProductType`.
    - `attributes()`: Belongs to many `Attribute`.
    - `images()`: Has many `ProductImage`.

---

### `ProductAttributeValue.php`
Handles the relationship between products and attribute values.

- **Attributes**:
    - `product_id`: Foreign key to `Product`.
    - `attribute_id`: Foreign key to `Attribute`.
    - `value`: Foreign key to `AttributeValue`.
    - `profile_id`: Foreign key to `Profile`.
- **Relationships**:
    - `product()`: Belongs to `Product`.
    - `attribute()`: Belongs to `Attribute`.
    - `value()`: Belongs to `AttributeValue`.
    - `profile()`: Belongs to `Profile`.

---

### `ProductImage.php`
Manages product images.

- **Attributes**:
    - `product_id`: Foreign key to `Product`.
    - `path`: Path to the image file.
- **Relationships**:
    - `product()`: Belongs to `Product`.

---

### `ProductType.php`
Handles product types.

- **Attributes**:
    - `name`: The name of the product type.
    - `profile_id`: Foreign key to `Profile`.
- **Relationships**:
    - `profile()`: Belongs to `Profile`.
    - `products()`: Has many `Product`.
    - `attributes()`: Has many `Attribute`.

---

### `Profile.php`
Manages user profiles and their relationships.

- **Attributes**:
    - `name`: The name of the profile.
- **Relationships**:
    - `users()`: Belongs to many `User`.
    - `permissions()`: Belongs to many `Permission`.
    - `productTypes()`: Has many `ProductType`.
    - `attributes()`: Has many `Attribute`.
    - `attributeValues()`: Has many `AttributeValue`.

---

### `Role.php`
Handles user roles.

- **Attributes**:
    - `name`: The name of the role.
- **Relationships**:
    - `users()`: Belongs to many `User`.

---

### `User.php`
Manages user data and relationships.

- **Attributes**:
    - `name`: The name of the user.
    - `email`: The email of the user.
    - `password`: The password of the user.
- **Relationships**:
    - `profiles()`: Belongs to many `Profile`.
- **Methods**:
    - `hasPermission($permissionName)`: Checks if the user has a specific permission.
    - `sendPasswordResetNotification($token)`: Sends the password reset notification.

---

## Notes
- Models represent the data and business logic of the application.
- Relationships between models are defined using Eloquent ORM.
- Laravel's validation features are used to enforce data integrity.

## Best Practices
- Focus each model on a single responsibility.
- Use relationships to define how models interact with each other.
- Keep model logic simple and delegate complex tasks to service classes or traits.
- Document model attributes and relationships for better maintainability.
