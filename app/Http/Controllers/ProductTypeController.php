<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Attribute; // Add this line
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('view_types')) {
            abort(403, 'Unauthorized action.');
        }

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Types/Index', [
            'types' => $types,
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_types')) {
            abort(403, 'Unauthorized action.');
        }

        return inertia('ProductTypes/Create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_types')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name',
        ]);

        ProductType::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        return redirect()->route('types.index')->with('success', 'Product type created successfully!');
    }



    public function edit(ProductType $productType)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_types')) {
            abort(403, 'Unauthorized action.');
        }

        return inertia('ProductTypes/Edit', compact('productType'));
    }

    public function update(Request $request, ProductType $productType)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_types')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name,' . $productType->id,
        ]);

        $productType->update($validated);

        return redirect()->route('types.index')->with('success', 'Product type updated successfully!');
    }

    public function destroy(ProductType $productType)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('delete_types')) {
            abort(403, 'Unauthorized action.');
        }

        $productType->delete();

        return redirect()->route('types.index')->with('success', 'Product type deleted successfully!');
    }

    public function attributes($typeId)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('view_types')) {
            abort(403, 'Unauthorized action.');
        }

        $attributes = Attribute::where('type_id', $typeId)->get();

        return response()->json([
            'attributes' => $attributes
        ]);
    }
}
