<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::with('attribute')->get();
        return inertia('Attributes/AttributesValuesIndex', compact('values'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return inertia('Attributes/AttributeCreate', compact('attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string',
        ]);

        AttributeValue::create($validated);

        return redirect()->route('attribute-values.index')->with('success', 'Attribute value created successfully!');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return inertia('AttributeValues/Edit', compact('attributeValue', 'attributes'));
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string',
        ]);

        $attributeValue->update($validated);

        return redirect()->route('attribute-values.index')->with('success', 'Attribute value updated successfully!');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()->route('attribute-values.index')->with('success', 'Attribute value deleted successfully!');
    }
}
