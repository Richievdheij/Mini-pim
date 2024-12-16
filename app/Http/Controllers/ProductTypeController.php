<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the product types.
     */
    public function index()
    {
        $user = auth()->user();

        $this->authorizeAction('view_types');

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
        $this->authorizeAction('create_types');

        // Pass to the Inertia view for creating a new product type
        return inertia('ProductTypes/Create');
    }

    /**
     * Store a newly created product type in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $this->authorizeAction('create_types');

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name',
        ]);

        // Create a new product type
        ProductType::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        // Redirect to the product types index with a success message
        return redirect()->route('pim.types.index')->with('success', 'Product type created successfully!');
    }

    /**
     * Show the form for editing the specified product type.
     */
    public function edit(ProductType $productType)
    {
        $this->authorizeAction('edit_types');

        // Pass product type to the Inertia view for editing
        return inertia('ProductTypes/Edit', compact('productType'));
    }

    /**
     * Update the specified product type in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $this->authorizeAction('edit_types');

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name,' . $productType->id,
        ]);

        // Update the product type
        $productType->update($validated);

        // Redirect to the product types index with a success message
        return redirect()->route('pim.types.index')->with('success', 'Product type updated successfully!');
    }

    /**
     * Remove the specified product type from storage.
     */
    public function destroy(ProductType $productType)
    {
        $this->authorizeAction('delete_types');

        // Check if the product type has any associated attributes
        if ($productType->attributes()->exists()) {
            return back()->withErrors([
                'error' => 'This product type cannot be deleted because it has associated attributes.',
            ]);
        }

        // Delete the product type
        $productType->delete();

        // Redirect to the product types index with a success message
        return redirect()->route('pim.types.index')->with('success', 'Product type deleted successfully!');
    }

    /**
     * Fetch the attributes associated with a given product type.
     */
    public function attributes($typeId)
    {
        $user = auth()->user();

        $this->authorizeAction('view_types');

        // Fetch attributes for the provided type_id and user's profile
        $attributes = Attribute::where('type_id', $typeId)
            ->where('profile_id', $user->profiles->first()->id)
            ->get();

        // Return the attributes as a JSON response
        return response()->json([
            'attributes' => $attributes
        ]);
    }
    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        // Abort with a 403 error if the user is unauthorized
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
