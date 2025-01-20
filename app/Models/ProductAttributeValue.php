<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Handle product attribute values.
 * @method static upsert(mixed[] $toArray, string[] $array, string[] $array1)
 */
class ProductAttributeValue extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
        'profile_id',
    ];

    /**
     * Get the product that owns the product attribute value.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attribute that owns the product attribute value.
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the value that owns the product attribute value.
     *
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'value_id');
    }

    /**
     * Get the profile that owns the product attribute value.
     *
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
