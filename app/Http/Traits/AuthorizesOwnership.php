<?php

namespace App\Http\Traits;

use App\Models\ProductAttributeValue;

/**
 * Trait for authorizing ownership, such as checking if the authenticated user owns a product attribute value.
 */
trait AuthorizesOwnership
{
    /**
     * Check if the authenticated user owns the given product attribute value.
     *
     * @param ProductAttributeValue $productAttributeValue
     * @return bool
     */
    public function authorizeOwnership(ProductAttributeValue $productAttributeValue): bool
    {
        $user = auth()->user();
        return $user && $productAttributeValue->profile_id === $user->profiles->first()->id;
    }
}
