<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Handles product types (e.g., Electronics, Clothing).
 */
class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Product type (e.g., Electronics, Clothing)
        'profile_id', // Foreign key to Profile
    ];

    /**
     * Relationship to Profile
     *
     * @return BelongsTo
     */
    public function profile(): belongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Relationship to Products
     *
     * @return hasMany
     */
    public function products(): hasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relationship to Attributes
     *
     * @return hasMany
     */
    public function attributes(): hasMany
    {
        return $this->hasMany(Attribute::class, 'type_id');
    }
}
