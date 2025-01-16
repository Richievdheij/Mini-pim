<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
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
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Relationship to Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relationship to Attributes
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'type_id');
    }
}
