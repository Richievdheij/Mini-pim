<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relationship to Users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_profile');
    }

    /**
     * Relationship to Permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'profile_permission');
    }

    /**
     * Relationship to ProductTypes
     */
    public function productTypes()
    {
        return $this->hasMany(ProductType::class);
    }

    /**
     * Relationship to Attributes
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Relationship to AttributeValues
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
