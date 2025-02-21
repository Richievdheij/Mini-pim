<?php

namespace App\Http\Services;

use App\Models\ProductAttributeValue;
use App\Models\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

/**
 * Handle product attribute value-related logic.
 */
class ProductAttributeValueService
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

        $profileId = $user->profiles->first()->id;

        // Insert or update the product attribute values
        ProductAttributeValue::upsert(
            collect($values)->map(function ($valueData) use ($productId, $profileId) {
                return [
                    'product_id' => $productId,
                    'attribute_id' => $valueData['attribute_id'],
                    'profile_id' => $profileId,
                    'value' => $valueData['value'],
                ];
            })->toArray(),
            ['product_id', 'attribute_id'],
            ['value']
        );
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
     *
     * @return Collection
     */
    public function getAttributesWithValues(int $typeId): Collection
    {
        $user = Auth::user();

        // Retrieve attributes with their values for the specified product type
        return Attribute::where('type_id', $typeId)
            ->with(['attributeValues' => function ($query) use ($user) {
                $query->where('profile_id', $user->profiles->first()->id);
            }])
            ->get();
    }
}
