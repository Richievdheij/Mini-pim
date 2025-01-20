<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Services\AttributeValueService;
use App\Http\Traits\AuthorizesActions;
use App\Http\Traits\AuthorizesOwnership;
use App\Models\ProductAttributeValue;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;

/**
 * Handles requests related to product attribute values.
 */
class AttributeValueController extends Controller
{
    use AuthorizesActions;
    use AuthorizesOwnership;

    protected AttributeValueService $attributeValueService;

    public function __construct(AttributeValueService $attributeValueService)
    {
        $this->attributeValueService = $attributeValueService;
    }

    /**
     * Display a listing of the product attribute values.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Retrieve product attribute values for the authenticated user's profile
        $values = $this->attributeValueService->getProductAttributeValuesForUser();

        // Render the inertia page with the product attribute values
        return inertia::render('Attributes/Index', compact('values')); // Corrected component name
    }

    /**
     * Store new or update existing product attribute values.
     *
     * @param StoreAttributeValueRequest $request
     * @return JsonResponse
     */
    public function store(StoreAttributeValueRequest $request): JsonResponse
    {
        // Validate the request
        $validated = $request->validated();

        // Store or update the product attribute values
        $this->attributeValueService->storeOrUpdateProductAttributeValues($validated['values'], $validated['product_id']);

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
     * @return Response
     */
    public function destroy(ProductAttributeValue $productAttributeValue): Response
    {
        // Check if the authenticated user owns the product attribute value
        if (!$this->authorizeOwnership($productAttributeValue)) {
            // If the user is not authorized, return inertia with an error message
            return inertia::render('Attributes/Index', [
                'error' => 'You are not authorized to delete this attribute value!',
                'values' => $this->attributeValueService->getProductAttributeValuesForUser()
            ]);
        }

        // Delete the product attribute value
        $this->attributeValueService->deleteProductAttributeValue($productAttributeValue);

        // Return inertia with a success message
        return inertia::render('Attributes/Index', [
            'success' => 'Attribute value deleted successfully!',
            'values' => $this->attributeValueService->getProductAttributeValuesForUser()
        ]);
    }

    /**
     * Fetch attributes and their values for a specific product type.
     *
     * @param int $typeId
     * @return JsonResponse
     * @throws Exception
     */
    public function getAttributesWithValues(int $typeId): JsonResponse
    {
        try {
            // Fetch attributes with their values for the authenticated user's profile
            $attributes = $this->attributeValueService->getAttributesWithValues($typeId);

            // Return the attributes with their values
            return response()->json(['attributes' => $attributes]);
        } catch (Exception $e) {
            Log::error('Error fetching attributes with values: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
