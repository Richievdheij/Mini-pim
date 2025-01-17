<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Services\AttributeValueService;
use App\Http\Traits\AuthorizesActions;
use App\Http\Traits\AuthorizesOwnership;
use App\Models\ProductAttributeValue;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
        return inertia('Attributes/AttributesValuesIndex', compact('values'));
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
        return response()->json(['success' => true, 'message' => 'Attribute values saved successfully!']);
    }

    /**
     * Delete a specific product attribute value.
     *
     * @param ProductAttributeValue $productAttributeValue
     * @return RedirectResponse
     */
    public function destroy(ProductAttributeValue $productAttributeValue): RedirectResponse
    {
        // Check if the authenticated user owns the product attribute value
        if (!$this->authorizeOwnership($productAttributeValue)) {
            // If the user is not authorized, redirect back with an error message
            return redirect()->route('pim.attribute-values.index')->with('error', 'You are not authorized to delete this attribute value!');
        }

        // Delete the product attribute value
        $this->attributeValueService->deleteProductAttributeValue($productAttributeValue);

        // Redirect back with a success message
        return redirect()->route('pim.attribute-values.index')->with('success', 'Attribute value deleted successfully!');
    }

    /**
     * Fetch attributes and their values for a specific product type.
     *
     * @param int $typeId
     * @throws Exception
     * @return JsonResponse
     */
    public function getAttributesWithValues($typeId): JsonResponse
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
