<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::where('profile_id', auth()->user()->profiles->first()->id)->with('attribute')->get();
        return inertia('Attributes/AttributesValuesIndex', compact('values'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string',
        ]);

        AttributeValue::create(array_merge($validated, ['profile_id' => auth()->user()->profiles->first()->id]));

        return redirect()->route('attribute-values.index')->with('success', 'Attribute value created successfully!');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $this->authorizeOwnership($attributeValue);

        $attributeValue->delete();

        return redirect()->route('attribute-values.index')->with('success', 'Attribute value deleted successfully!');
    }

    private function authorizeOwnership(AttributeValue $attributeValue)
    {
        if ($attributeValue->profile_id !== auth()->user()->profiles->first()->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
