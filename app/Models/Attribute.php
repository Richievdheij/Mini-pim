<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Attribute name (e.g., Brand, Size)
        'type_id', // Foreign key to ProductType
    ];

// In App\Models\Attribute.php
    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }


    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
