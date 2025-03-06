<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Handles attributes for products.
 *
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
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class , 'profile_id');
    }

    /**
     * Relationship to ProductType
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }

    /**
     * Relationship to AttributeValues
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Relationship to ProductAttributeValues
     * @return HasMany
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }
}
