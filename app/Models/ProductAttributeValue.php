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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'value_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
