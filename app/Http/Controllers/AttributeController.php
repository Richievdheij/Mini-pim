<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttributeController extends Controller
{
    /**
     * Display a listing of the attributes.
     */
    public function index()
    {
        // Check if the current user has permission to view attributes
        $this->authorizeAction('view_attributes');

        $user = auth()->user(); // Get the authenticated user
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->with('type')->get(); // Get all attributes for the user's profile
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get(); // Get all product types for the user's profile

        return Inertia::render('Attributes/Index', [
            'attributes' => $attributes, // Pass attributes to the view
            'types' => $types, // Pass product types to the view
            'canCreateAttribute' => $user->hasPermission('create_attributes'), // Check if the user can create attributes
            'canEditAttribute' => $user->hasPermission('edit_attributes'), // Check if the user can edit attributes
            'canDeleteAttribute' => $user->hasPermission('delete_attributes'), // Check if the user can delete attributes
        ]);
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create()
    {
        $this->authorizeAction('create_attributes'); // Check if the current user has permission to create attributes

        $user = auth()->user(); // Get the authenticated user
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get(); // Get all product types for the user's profile

        return Inertia::render('Attributes/Create', compact('types')); // Render the create attribute form
    }

    /**
     * Store a newly created attribute in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAction('create_attributes'); // Check if the current user has permission to create attributes

        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $user = auth()->user();
        $attribute = Attribute::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        return redirect()->route('pim.attributes.index')->with('success', 'Attribute created successfully!')->with('newAttribute', $attribute);
    }

    /**
     * Show the form for editing the specified attribute.
     */
    public function edit(Attribute $attribute)
    {
        $this->authorizeAction('edit_attributes');

        $user = auth()->user();
        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        return Inertia::render('Attributes/Edit', compact('attribute', 'types'));
    }

    /**
     * Update the specified attribute in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $this->authorizeAction('edit_attributes');

        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
        ]);

        $attribute->update($validated);

        return redirect()->route('pim.attributes.index')->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified attribute from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $this->authorizeAction('delete_attributes');

        $attribute->delete();

        return redirect()->route('pim.attributes.index')->with('success', 'Attribute deleted successfully!');
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

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
