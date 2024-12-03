<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $types = ProductType::all();
        return inertia('ProductTypes/Index', compact('types'));
    }

    public function create()
    {
        return inertia('ProductTypes/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name',
        ]);

        ProductType::create($validated);

        return redirect()->route('product-types.index')->with('success', 'Product type created successfully!');
    }

    public function edit(ProductType $productType)
    {
        return inertia('ProductTypes/Edit', compact('productType'));
    }

    public function update(Request $request, ProductType $productType)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:product_types,name,' . $productType->id,
        ]);

        $productType->update($validated);

        return redirect()->route('product-types.index')->with('success', 'Product type updated successfully!');
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('product-types.index')->with('success', 'Product type deleted successfully!');
    }
}
