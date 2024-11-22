# Models in `app/Models`

This directory contains the Eloquent models that represent the main entities in the application. Each model is responsible for interacting with the corresponding database table and provides an object-oriented way to manage data.

---

## **Model Files**

### **1. `Account.php`**
Responsible for representing the `accounts` model.
- **Relationships:**
    - **Permissions:** An account has many permissions through the `profile_permission` pivot table.
    - **Users:** An account has many users through the `user_profile` pivot table.
- **Attribute:** `name`

```php
public function permissions(): BelongsToMany
{
    return $this->belongsToMany(Permission::class, 'profile_permission');
}

public function users(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'user_profile');
}
