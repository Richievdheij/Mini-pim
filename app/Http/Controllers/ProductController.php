<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('type')->get();
        return inertia('Data/ProductsIndex', compact('products'));
    }

    public function create()
    {
        $types = ProductType::all();
        return inertia('Data/ProductCreate', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return inertia('Data/ProductShow', [
            'product' => $product->load('type', 'attributes.values', 'images'),
        ]);
    }

    public function edit(Product $product)
    {
        $types = ProductType::all();
        return inertia('Data/ProductEdit', compact('product', 'types'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
