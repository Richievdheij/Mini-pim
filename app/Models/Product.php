<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Handles product-related logic.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'product_id', // SKU
        'name',
        'type_id',
        'profile_id',
        'weight',
        'description',
        'price',
        'stock_quantity',
        'height',
        'width',
        'depth',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'width' => 'decimal:2',
        'depth' => 'decimal:2',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Relationship to ProductType
     * @return belongsToMany
     */
    public function profiles(): belongsToMany
    {
        return $this->belongsToMany(Profile::class, 'product_profile');
    }

    /**
     * Relationship to ProductType
     * @return belongsTo
     */
    public function type(): belongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Relationship to Attributes
     * @return belongsToMany
     */
    public function attributes(): belongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')
            ->withPivot('value_id')
            ->withTimestamps();
    }

    /**
     * Relationship to Images
     * @return hasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
