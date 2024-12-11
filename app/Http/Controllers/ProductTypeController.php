<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Attribute; // Add this line for attributes management
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the product types.
     */
    public function index()
    {
        $user = auth()->user();

        // Check if the user has permission to view product types
        if (!$user || !$user->hasPermission('view_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch product types for the current user's profile
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        // Pass types and permissions to the Inertia view
        return inertia('Types/Index', [
            'types' => $types,
            'canCreateType' => $user->hasPermission('create_types'),
            'canEditType' => $user->hasPermission('edit_types'),
            'canDeleteType' => $user->hasPermission('delete_types'),
        ]);
    }

    /**
     * Show the form for creating a new product type.
     */
    public function create()
    {
        $user = auth()->user();

        // Check if the user has permission to create product types
        if (!$user || !$user->hasPermission('create_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Pass to the Inertia view for creating a new product type
        return inertia('ProductTypes/Create');
    }

    /**
     * Store a newly created product type in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Check if the user has permission to create product types
        if (!$user || !$user->hasPermission('create_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name',
        ]);

        // Create a new product type
        ProductType::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        // Redirect to the product types index with a success message
        return redirect()->route('types.index')->with('success', 'Product type created successfully!');
    }

    /**
     * Show the form for editing the specified product type.
     */
    public function edit(ProductType $productType)
    {
        $user = auth()->user();

        // Check if the user has permission to edit product types
        if (!$user || !$user->hasPermission('edit_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Pass product type to the Inertia view for editing
        return inertia('ProductTypes/Edit', compact('productType'));
    }

    /**
     * Update the specified product type in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $user = auth()->user();

        // Check if the user has permission to edit product types
        if (!$user || !$user->hasPermission('edit_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name,' . $productType->id,
        ]);

        // Update the product type
        $productType->update($validated);

        // Redirect to the product types index with a success message
        return redirect()->route('types.index')->with('success', 'Product type updated successfully!');
    }

    /**
     * Remove the specified product type from storage.
     */
    public function destroy(ProductType $productType)
    {
        $user = auth()->user();

        // Check if the user has permission to delete product types
        if (!$user || !$user->hasPermission('delete_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the product type
        $productType->delete();

        // Redirect to the product types index with a success message
        return redirect()->route('types.index')->with('success', 'Product type deleted successfully!');
    }

    /**
     * Fetch the attributes associated with a given product type.
     */
    public function attributes($typeId)
    {
        $user = auth()->user();

        // Check if the user has permission to view attributes
        if (!$user || !$user->hasPermission('view_types')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch attributes for the given product type
        $attributes = Attribute::where('type_id', $typeId)->get();

        // Return the attributes as a JSON response
        return response()->json([
            'attributes' => $attributes
        ]);
    }
}
