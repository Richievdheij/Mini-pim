<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Service for handling product-related actions, such as retrieving, creating, updating, and deleting products.
 */
class ProductService
{
    /**
     * Retrieve all products the user has access to.
     *
     * @return Collection
     */
    public function retrieveProducts(): Collection
    {
        $profileId = Auth::user()->profiles->first()->id;

        return Product::with('type')
            ->when($profileId !== 1, fn($query) => $query->where('profile_id', $profileId))
            ->get();
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return void
     */
    public function createProduct(array $data): void
    {
        $profileId = Auth::user()->profiles->first()->id;

        $data = array_merge([
            'weight' => 0,
            'height' => 0,
            'width' => 0,
            'depth' => 0,
            'price' => 0,
            'stock_quantity' => 0,
            'profile_id' => $profileId,
        ], $data);

        $product = Product::create($data);

        // Sync the product's profiles (current user's profile and admin profile)
        $product->profiles()->sync([$profileId, 1]);
    }

    /**
     * Retrieve data for editing a product.
     *
     * @param int $id
     * @return array
     */
    public function getProductEditData(int $id): array
    {
        $product = Product::with(['type', 'attributes'])->findOrFail($id);

        return [
            'product' => $product,
            'attributes' => Attribute::where('type_id', $product->type_id)->get(),
            'attributeValues' => $product->attributes->pluck('pivot.value', 'id')->toArray(),
        ];
    }

    /**
     * Update a product.
     *
     * @param int $id
     * @param array $data
     * @return void
     */
    public function updateProduct(int $id, array $data): void
    {
        $product = Product::findOrFail($id);

        $product->update($data);

        if (!empty($data['attributes'])) {
            $attributes = collect($data['attributes'])->mapWithKeys(function ($attribute) {
                return [$attribute['id'] => ['value' => $attribute['value']]];
            });

            // Sync product attributes with their values
            $product->attributes()->sync($attributes);
        }
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return void
     */
    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);

        // Detach related attributes before deletion
        $product->attributes()->detach();

        // Delete the product
        $product->delete();
    }
}
