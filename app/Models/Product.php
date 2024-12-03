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

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')
            ->withPivot('value_id')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
