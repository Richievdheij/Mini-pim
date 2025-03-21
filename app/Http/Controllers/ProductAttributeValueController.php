<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Services\ProductAttributeValueService;
use App\Models\ProductAttributeValue;
use Exception;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;

/**
 * Handles requests related to product attribute values.
 *
 */
class ProductAttributeValueController extends Controller
{
    protected ProductAttributeValueService $productAttributeValueService;

    public function __construct(ProductAttributeValueService $productAttributeValueService)
    {
        $this->productAttributeValueService = $productAttributeValueService;
    }

    /**
     * Display a listing of the product attribute values.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Retrieve product attribute values for the authenticated user's profile
        $values = $this->productAttributeValueService->getProductAttributeValuesForUser();

        // Render the Inertia page with the product attribute values
        return Inertia::render('Attributes/Index', compact('values'));
    }

    /**
     * Store new or update existing product attribute values.
     *
     * @param StoreAttributeValueRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreAttributeValueRequest $request): JsonResponse
    {
        // Validate the request
        $validated = $request->validated();

        // Store or update the product attribute values
        $this->productAttributeValueService->storeOrUpdateProductAttributeValues($validated['values'], $validated['product_id']);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Attribute values saved successfully!'
        ]);
    }

    /**
     * Delete a specific product attribute value.
     *
     * @param ProductAttributeValue $productAttributeValue
     *
     * @return Response
     */
    public function destroy(ProductAttributeValue $productAttributeValue): Response
    {
        // Check if the authenticated user owns the product attribute value
        if (!$this->authorizeOwnership($productAttributeValue)) {
            // If the user is not authorized, return Inertia with an error message
            return Inertia::render('Attributes/Index', [
                'values' => $this->productAttributeValueService->getProductAttributeValuesForUser()
            ]);
        }

        // Delete the product attribute value
        $this->productAttributeValueService->deleteProductAttributeValue($productAttributeValue);

        // Return Inertia with a success message
        return Inertia::render('Attributes/Index', [
            'values' => $this->productAttributeValueService->getProductAttributeValuesForUser()
        ]);
    }

    /**
     * Fetch attributes and their values for a specific product type.
     *
     * @param int $typeId
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function getAttributesWithValues(int $typeId): JsonResponse
    {
        // Retrieve attributes with their values for the specified product type
        $attributes = $this->productAttributeValueService->getAttributesWithValues($typeId);

        // Return the attributes with their values
        return response()->json([
            'attributes' => $attributes
        ]);
    }
}
