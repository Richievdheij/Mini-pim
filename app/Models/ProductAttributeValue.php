<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', // Foreign key to Product
        'attribute_id', // Foreign key to Attribute
        'value', // Foreign key to AttributeValue
        'profile_id', // Foreign key to Profile
    ];

    // Product and ProductAttributeValue are related to each other
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Attribute and Value are related to each other
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // AttributeValue and Value are related to each other
    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'value_id');
    }

    // Profile and ProductAttributeValue are related to each other
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
