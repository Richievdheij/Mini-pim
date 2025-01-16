<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 * @method static create(array $array_merge)
 */
class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Attribute name (e.g., Brand, Size)
        'type_id', // Foreign key to ProductType
        'profile_id', // Foreign key to Profile
    ];

    /**
     * Relationship to Profile
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class , 'profile_id');
    }

    /**
     * Relationship to ProductType
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }

    /**
     * Relationship to AttributeValues
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Relationship to ProductAttributeValues
     */
    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }
}
