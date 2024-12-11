<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the attributes.
     */
    public function index()
    {
        $user = auth()->user();

        // Check if the user has permission to view attributes
        if (!$user || !$user->hasPermission('view_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch attributes and types for the current user's profile
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->with('type')->get();
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        // Pass attributes, types, and permissions to the Inertia view
        return inertia('Attributes/Index', [
            'attributes' => $attributes,
            'types' => $types,
            'canCreateAttribute' => $user->hasPermission('create_attributes'),
            'canEditAttribute' => $user->hasPermission('edit_attributes'),
            'canDeleteAttribute' => $user->hasPermission('delete_attributes'),
        ]);
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create()
    {
        $user = auth()->user();

        // Check if the user has permission to create attributes
        if (!$user || !$user->hasPermission('create_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch product types for the current user's profile
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        // Pass types to the Inertia view
        return inertia('Attributes/Create', compact('types'));
    }

    /**
     * Store a newly created attribute in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Check if the user has permission to create attributes
        if (!$user || !$user->hasPermission('create_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        // Create a new attribute
        $attribute = Attribute::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        // Redirect to the attributes index with a success message
        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully!')->with('newAttribute', $attribute);
    }

    /**
     * Show the form for editing the specified attribute.
     */
    public function edit(Attribute $attribute)
    {
        $user = auth()->user();

        // Check if the user has permission to edit attributes
        if (!$user || !$user->hasPermission('edit_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch product types for the current user's profile
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        // Pass attribute and types to the Inertia view
        return inertia('Attributes/Edit', compact('attribute', 'types'));
    }

    /**
     * Update the specified attribute in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $user = auth()->user();

        // Check if the user has permission to edit attributes
        if (!$user || !$user->hasPermission('edit_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        // Update the attribute
        $attribute->update($validated);

        // Redirect to the attributes index with a success message
        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified attribute from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $user = auth()->user();

        // Check if the user has permission to delete attributes
        if (!$user || !$user->hasPermission('delete_attributes')) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the attribute
        $attribute->delete();

        // Redirect to the attributes index with a success message
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
