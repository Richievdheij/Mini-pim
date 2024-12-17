<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', // SKU
        'name',
        'type_id',
        'weight',
        'description',
        'price',
        'stock_quantity',
    ];

    /**
     * Relationship to ProductType
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'product_profile');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Relationship to Attributes
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')
            ->withPivot('value_id')
            ->withTimestamps();
    }

    /**
     * Relationship to Images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
