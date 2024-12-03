<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('type')->get();
        $types = ProductType::all(); // Fetch types
        return inertia('Attributes/Index', [
            'attributes' => $attributes,
            'types' => $types // Pass types to the view
        ]);
    }


    public function create()
    {
        $types = ProductType::all();
        return inertia('Attributes/Index', compact('types')); // Modals will be triggered from Index
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        Attribute::create($validated);

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully!');
    }

    public function edit(Attribute $attribute)
    {
        $types = ProductType::all();
        return inertia('Attributes/AttributeEdit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $attribute->update($validated);

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully!');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
