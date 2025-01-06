# Migrations Directory

This directory contains the database migrations used to create and modify database tables. Migrations provide a version control system for your database schema.

## Migration Overview

### `0001_01_01_000000_create_users_table.php`
Creates the `users`, `password_reset_tokens`, and `sessions` tables.

---

### `0001_01_01_000001_create_cache_table.php`
Creates the `cache` and `cache_locks` tables.

---

### `0001_01_01_000002_create_jobs_table.php`
Creates the `jobs`, `job_batches`, and `failed_jobs` tables.

---

### `2024_10_24_131014_create_roles_table.php`
Creates the `roles` table.

---

### `2024_10_24_131048_create_user_role_pivot_table.php`
Creates the `role_user` pivot table.

---

### `2024_11_06_140604_create_permissions_table.php`
Creates the `permissions` table.

---

### `2024_11_06_140824_create_profiles_table.php`
Creates the `profiles` table.

---

### `2024_11_06_141354_create_profile_permission_table.php`
Creates the `profile_permission` pivot table.

---

### `2024_11_06_141526_create_user_profile_table.php`
Creates the `user_profile` pivot table.

---

### `2024_11_27_133019_add_category_to_permissions_table.php`
Adds the `category` column to the `permissions` table.

---

### `2024_11_28_082520_add_title_to_permissions_table.php`
Adds the `title` column to the `permissions` table.

---

### `2024_11_28_125012_create_product_types_table.php`
Creates the `product_types` table.

---

### `2024_11_29_121425_create_products_table.php`
Creates the `products` table.

---

### `2024_11_29_125025_create_attributes_table.php`
Creates the `attributes` table.

---

### `2024_11_29_125038_create_attribute_values_table.php`
Creates the `attribute_values` table.

---

### `2024_11_29_125050_create_product_attribute_values_table.php`
Creates the `product_attribute_values` table.

---

### `2024_11_29_125058_create_product_images_table.php`
Creates the `product_images` table.

---

### `2024_12_05_071035_add_profile_id_to_tables.php`
Adds the `profile_id` column to multiple tables.

---

### `2024_12_17_095727_add_dimensions_to_products_table.php`
Adds `height`, `width`, and `depth` columns to the `products` table.

---

### `2024_12_19_143319_add_profile_id_to_product_attribute_values_table.php`
Adds the `profile_id` column to the `product_attribute_values` table.

---

### `2024_12_20_094636_create_product_profiles_table.php`
Creates the `product_profiles` table.

---

### `2024_12_30_151129_allow_null_type_id_on_products.php`
Makes the `type_id` column nullable in the `products` table.

---

## Notes
- Migrations are used to create and modify database tables.
- Run `php artisan migrate` to execute all migrations.

## Best Practices
- Keep migrations idempotent to avoid issues during rollbacks.
- Document the purpose of each migration.
