<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the product attribute values.
     */
    public function index()
    {
        // Retrieve product attribute values for the authenticated user's profile and include their associated attributes
        $values = ProductAttributeValue::where('profile_id', auth()->user()->profiles->first()->id)
            ->with('attribute')
            ->get();

        // Render the inertia page with the product attribute values
        return inertia('Attributes/AttributesValuesIndex', compact('values'));
    }

    /**
     * Store new or update existing product attribute values.
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'values' => 'required|array',
            'values.*.attribute_id' => 'required|exists:attributes,id',
            'values.*.value' => 'required|string',
        ]);

        // Loop through the attribute values and update or create them
        foreach ($request->values as $valueData) {
            ProductAttributeValue::updateOrCreate(
                [
                    'product_id' => $request->product_id,
                    'attribute_id' => $valueData['attribute_id'],
                ],
                [
                    'value' => $valueData['value'],
                    'profile_id' => auth()->user()->profiles->first()->id,
                ]
            );
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Attribute values saved successfully!']);
    }

    /**
     * Delete a specific product attribute value.
     */
    public function destroy(ProductAttributeValue $productAttributeValue)
    {
        // Authorize the ownership of the product attribute value
        $this->authorizeOwnership($productAttributeValue);

        // Delete the product attribute value
        $productAttributeValue->delete();

        // Redirect back with a success message
        return redirect()->route('pim.attribute-values.index')->with('success', 'Attribute value deleted successfully!');
    }

    /**
     * Fetch attributes and their values for a specific product type.
     */
    public function getAttributesWithValues($typeId)
    {
        try {
            // Fetch attributes with their values for the authenticated user's profile
            $attributes = Attribute::where('type_id', $typeId)
                ->with(['attributeValues' => function ($query) {
                    $query->where('profile_id', auth()->user()->profiles->first()->id);
                }])
                ->get();

            // Return the attributes with their values
            return response()->json(['attributes' => $attributes]);
        } catch (\Exception $e) {
            \Log::error('Error fetching attributes with values: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Authorize the ownership of the product attribute value.
     */
    private function authorizeOwnership(ProductAttributeValue $productAttributeValue)
    {
        // Check if the authenticated user owns the product attribute value
        if ($productAttributeValue->profile_id !== auth()->user()->profiles->first()->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
