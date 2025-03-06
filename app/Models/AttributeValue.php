<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Handles attribute values.
 *
 */
class AttributeValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'attribute_id', // Foreign key to Attribute
        'value', // Actual value (e.g., "Red", "Large")
        'profile_id', // Foreign key to Profile
    ];

    /**
     * Relationship to Profile
     * @return BelongsTo
     */
    public function profile(): belongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Relationship to Attribute
     * @return BelongsTo
     */
    public function attribute(): belongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
