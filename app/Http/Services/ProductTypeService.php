<?php

namespace App\Http\Services;

use App\Models\ProductType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductTypeService
{
    /**
     * First function retrieves all product types that the current user has rights to.
     * (Function is from ProductController.php)
     *
     * The other functions handles the CRUD operations for product types.
     *
     * @return Collection
     */
    public function retrieveProductTypes(): Collection
    {
        return ProductType::where('profile_id', Auth::user()->profiles->first()->id)->get();
    }

    /**
     * Create a new product type.
     *
     * @param array $data
     *
     * @return void
     */
    public function createProductType(array $data): void
    {
        $data['profile_id'] = Auth::user()->profiles->first()->id;
        ProductType::create($data);
    }

    /**
     * Update a product type.
     *
     * @param ProductType $productType
     * @param array $data
     *
     * @return void
     */
    public function updateProductType(ProductType $productType, array $data): void
    {
        $productType->update($data);
    }

    /**
     * Delete a product type.
     *
     * @param ProductType $productType
     *
     * @return bool
     */
    public function deleteProductType(ProductType $productType): bool
    {
        if ($productType->attributes()->exists()) {
            return false;
        }

        $productType->delete();
        return true;
    }
}
