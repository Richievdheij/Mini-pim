<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard()
    {
        return inertia('PIM/PIMDashboard');
    }

    public function index()
    {
        $user = auth()->user();

        return inertia('Data/ProductsIndex', [
            'products' => Product::where('profile_id', $user->profiles->first()->id)->with('type')->get(),
            'types' => ProductType::where('profile_id', $user->profiles->first()->id)->get(), // Add this line
            'canCreateProduct' => $user->hasPermission('create_products'),
            'canEditProduct' => $user->hasPermission('edit_products'),
            'canDeleteProduct' => $user->hasPermission('delete_products'),
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_products')) {
            abort(403, 'Unauthorized action.');
        }

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Data/ProductCreate', compact('types', 'attributes'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('create_products')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'string',
        ]);

        $product = Product::create(array_merge($validated, ['profile_id' => $user->profiles->first()->id]));

        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attribute) {
                $product->attributes()->attach($attribute['id'], [
                    'value' => $attribute['value'] ?? '',
                ]);
            }
        }

        return redirect()->route('pim.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_products')) {
            abort(403, 'Unauthorized action.');
        }

        $product = Product::with(['type', 'attributes'])->findOrFail($id);
        $attributes = Attribute::where('type_id', $product->type_id)->get();

        return inertia('Data/ProductEdit', [
            'product' => $product,
            'attributes' => $attributes,
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('edit_products')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:product_types,id',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'string|nullable',
        ]);

        $product->update($validated);

        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attribute) {
                \DB::table('product_attribute_values')->updateOrInsert(
                    [
                        'product_id' => $product->id,
                        'attribute_id' => $attribute['id'],
                    ],
                    [
                        'value' => $attribute['value'],
                        'updated_at' => now(),
                    ]
                );
            }
        }

        return redirect()->route('pim.products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy(Product $product)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission('delete_products')) {
            abort(403, 'Unauthorized action.');
        }

        $this->authorizeOwnership($product);

        $product->delete();

        return redirect()->route('pim.products.index')->with('success', 'Product deleted successfully!');
    }

    private function authorizeOwnership(Product $product)
    {
        if ($product->profile_id !== auth()->user()->profiles->first()->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
