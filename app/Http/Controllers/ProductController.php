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
        $this->authorizeAction('view_products');

        // Get the user's profile ID
        $profileId = $user->profiles->first()->id;

        // Admin profile_id = 1 can see all products
        if ($profileId === 1) {
            $products = Product::with('type')->get(); // Admin sees all products
        } else {
            // Non-admin users only see products assigned to their profile
            $products = Product::whereHas('profiles', function ($query) use ($profileId) {
                $query->where('profile_id', $profileId);
            })->with('type')->get();
        }

        // Fetch product types
        $types = ProductType::where('profile_id', $profileId)->get();

        return inertia('Data/ProductsIndex', [
            'products' => $products,
            'types' => $types,
            'canCreateProduct' => $user->hasPermission('create_products'),
            'canEditProduct' => $user->hasPermission('edit_products'),
            'canDeleteProduct' => $user->hasPermission('delete_products'),
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $this->authorizeAction('create_products');

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Data/ProductCreate', compact('types', 'attributes'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $this->authorizeAction('create_products');

        // Validate incoming data
        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|string',
            'type_id' => 'required|exists:product_types,id',
            'description' => 'nullable|string',
            'height' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'depth' => 'nullable|numeric',
            // Custom validation rule for dimensions
            'dimensions' => function ($attribute, $value, $fail) use ($request) {
                if (
                    ($request->has('height') && !$request->has('width')) ||
                    ($request->has('height') && !$request->has('depth')) ||
                    ($request->has('width') && !$request->has('height')) ||
                    ($request->has('width') && !$request->has('depth')) ||
                    ($request->has('depth') && !$request->has('height')) ||
                    ($request->has('depth') && !$request->has('width'))
                ) {
                    $fail('All dimensions (height, width, depth) must be filled when one dimension is provided.');
                }
            },
        ]);

        // Create the product
        $product = Product::create(array_merge($validated, [
            'weight' => 0,
            'stock_quantity' => 0,
            'price' => 0,
            'profile_id' => $user->profiles->first()->id,
        ]));

        // Attach profiles: the user's current profile and the admin profile (id=1)
        $profileIds = [$user->profiles->first()->id, 1]; // User's profile + admin profile
        $product->profiles()->attach($profileIds);

        return redirect()->route('pim.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $this->authorizeAction('edit_products');

        // Retrieve the product with the associated type and attributes
        $product = Product::with(['type', 'attributes'])->findOrFail($id);

        // Ensure ownership or admin access
        $this->authorizeOwnership($product);

        // Fetch the product's existing attribute values
        $attributeValues = $product->attributes->mapWithKeys(function ($attribute) {
            return [$attribute->id => $attribute->pivot->value];
        });

        // Fetch attributes based on the product's type
        $attributes = Attribute::where('type_id', $product->type_id)->get();

        return inertia('Data/ProductEdit', [
            'product' => $product,
            'attributes' => $attributes,
            'attributeValues' => $attributeValues, // Pass existing values
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeAction('edit_products');
        // Ensure ownership or admin access
        $this->authorizeOwnership($product);

        // Validate incoming data
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
            // Add validation for dimensions
            'height' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'depth' => 'nullable|numeric',
            'dimensions' => function ($attribute, $value, $fail) use ($request) {
                if (
                    ($request->has('height') && !$request->has('width')) ||
                    ($request->has('height') && !$request->has('depth')) ||
                    ($request->has('width') && !$request->has('height')) ||
                    ($request->has('width') && !$request->has('depth')) ||
                    ($request->has('depth') && !$request->has('height')) ||
                    ($request->has('depth') && !$request->has('width'))
                ) {
                    $fail('All dimensions (height, width, depth) must be filled when one dimension is provided.');
                }
            },
        ]);

        // Update the product with validated data
        $product->update($validated);

        // Update attributes if they are provided
        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attribute) {
                \DB::table('product_attribute_values')->updateOrInsert(
                    [
                        'product_id' => $product->id,
                        'attribute_id' => $attribute['id'],
                    ],
                    [
                        'value' => $attribute['value'],
                    ]
                );
            }
        }

        return redirect()->route('pim.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->authorizeAction('delete_products');
        // Ensure ownership or admin access
        $this->authorizeOwnership($product);

        // Detach the product from attributes
        $product->attributes()->detach();  // Assuming a many-to-many relationship

        // Optionally: Detach the product from other related models (e.g., product_type)
        // $product->type()->dissociate();

        // Now delete the product
        $product->delete();

        return redirect()->route('pim.products.index')->with('success', 'Product deleted successfully!');
    }


    private function authorizeOwnership(Product $product)
    {
        $user = auth()->user();

        // Allow access if the user has the admin profile (profile_id = 1)
        if ($user->profiles->first()->id === 1) {
            return;
        }

        // Check if the product belongs to the user's profile
        if ($product->profile_id !== $user->profiles->first()->id) {
            abort(403, 'Unauthorized action.');
        }
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
