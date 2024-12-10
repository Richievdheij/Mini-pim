<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('view_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch attributes and types for the current user's profile
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->with('type')->get();
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        // Pass attributes and types to the Inertia view
        return inertia('Attributes/Index', [
            'attributes' => $attributes,
            'types' => $types,
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Attributes/Create', compact('types'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $attribute = Attribute::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully!')->with('newAttribute', $attribute);
    }

    public function edit(Attribute $attribute)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Attributes/Edit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $attribute->update($validated);

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully!');
    }

    public function destroy(Attribute $attribute)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('delete_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
