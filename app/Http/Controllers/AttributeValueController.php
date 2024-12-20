<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = ProductAttributeValue::where('profile_id', auth()->user()->profiles->first()->id)
            ->with('attribute')
            ->get();

        return inertia('Attributes/AttributesValuesIndex', compact('values'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'values' => 'required|array',
            'values.*.attribute_id' => 'required|exists:attributes,id',
            'values.*.value' => 'required|string',
        ]);

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

        return response()->json(['success' => true, 'message' => 'Attribute values saved successfully!']);
    }

    public function destroy(ProductAttributeValue $productAttributeValue)
    {
        $this->authorizeOwnership($productAttributeValue);

        $productAttributeValue->delete();

        return redirect()->route('pim.attribute-values.index')->with('success', 'Attribute value deleted successfully!');
    }

    public function getAttributesWithValues($typeId)
    {
        try {
            $attributes = Attribute::where('type_id', $typeId)
                ->with(['attributeValues' => function ($query) {
                    $query->where('profile_id', auth()->user()->profiles->first()->id);
                }])
                ->get();

            return response()->json(['attributes' => $attributes]);
        } catch (\Exception $e) {
            \Log::error('Error fetching attributes with values: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    private function authorizeOwnership(ProductAttributeValue $productAttributeValue)
    {
        if ($productAttributeValue->profile_id !== auth()->user()->profiles->first()->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
