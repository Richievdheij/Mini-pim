<?php

namespace App\Http\Traits;

use App\Models\ProductAttributeValue;

/**
 * Trait for authorizing ownership.
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
