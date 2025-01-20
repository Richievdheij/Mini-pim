<?php
namespace App\Http\Services;

use App\Models\ProductType;
use App\Models\Attribute;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Handle attribute-related logic.
 */
class AttributeService
{
    /**
     * Get the authenticated user.
     * @return Authenticatable
     */
    public function getAuthenticatedUser(): Authenticatable
    {
        return Auth::user();
    }

    /**
     * Get all attributes for the current user's profile.
     *
     * @return Collection
     */
    public function getAttributesForUser(): Collection
    {
        $user = Auth::user();
        return Attribute::where('profile_id', $user->profiles->first()->id)
            ->with('type')
            ->get();
    }

    /**
     * Get all product types for the current user's profile.
     *
     * @return Collection
     */
    public function getProductTypesForUser(): Collection
    {
        $user = Auth::user();
        return ProductType::where('profile_id', $user->profiles->first()->id)
            ->get();
    }

    /**
     * Create a new attribute for the current user's profile.
     *
     * @param array $data
     * @return Attribute
     */
    public function createAttribute(array $data): Attribute
    {
        $user = Auth::user();
        return Attribute::create(array_merge($data, ['profile_id' => $user->profiles->first()->id]));
    }

    /**
     * Update the specified attribute.
     *
     * @param Attribute $attribute
     * @param array $data
     * @return void
     */
    public function updateAttribute(Attribute $attribute, array $data): void
    {
        $attribute->update($data);
    }

    /**
     * Delete the specified attribute.
     *
     * @param Attribute $attribute
     * @return void
     */
    public function deleteAttribute(Attribute $attribute): void
    {
        $attribute->delete();
    }
}
