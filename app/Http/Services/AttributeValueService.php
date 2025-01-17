<?php

namespace App\Http\Services;

use App\Models\ProductAttributeValue;
use App\Models\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

/**
 * Handle product attribute value-related logic.
 */
class AttributeValueService
{
    /**
     * Get all product attribute values for the authenticated user.
     *
     * @return Collection
     */
    public function getProductAttributeValuesForUser(): Collection
    {
        $user = Auth::user();
        return ProductAttributeValue::where('profile_id', $user->profiles->first()->id)
            ->with('attribute')
            ->get();
    }

    /**
     * Store or update product attribute values.
     *
     * @param array $values
     * @param int $productId
     * @return void
     */
    public function storeOrUpdateProductAttributeValues(array $values, int $productId): void
    {
        $user = Auth::user();
        foreach ($values as $valueData) {
            ProductAttributeValue::updateOrCreate(
                [
                    'product_id' => $productId,
                    'attribute_id' => $valueData['attribute_id'],
                ],
                [
                    'value' => $valueData['value'],
                    'profile_id' => $user->profiles->first()->id,
                ]
            );
        }
    }

    /**
     * Delete the specified product attribute value.
     *
     * @param ProductAttributeValue $productAttributeValue
     * @return void
     */
    public function deleteProductAttributeValue(ProductAttributeValue $productAttributeValue): void
    {
        $productAttributeValue->delete();
    }

    /**
     * Get attributes with their values for a specific product type.
     *
     * @param int $typeId
     * @return Collection
     */
    public function getAttributesWithValues(int $typeId): Collection
    {
        $user = Auth::user();
        return Attribute::where('type_id', $typeId)
            ->with(['attributeValues' => function ($query) use ($user) {
                $query->where('profile_id', $user->profiles->first()->id);
            }])
            ->get();
    }
}
