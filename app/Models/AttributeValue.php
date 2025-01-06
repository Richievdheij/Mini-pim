<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id', // Foreign key to Attribute
        'value', // Actual value (e.g., "Red", "Large")
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
     * Relationship to Attribute
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
