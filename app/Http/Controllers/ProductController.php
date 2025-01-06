<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display the PIM dashboard.
     *
     */
    public function dashboard()
    {
        // Check if the user has permission to view the dashboard
        return inertia('PIM/PIMDashboard');
    }

    /**
     * Display the products index page.
     *
     */
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

    /**
     * Display the product creation page.
     *
     */
    public function create()
    {
        $user = auth()->user();
        $this->authorizeAction('create_products');

        $types = ProductType::where('profile_id', $user->profiles->first()->id)->get();
        $attributes = Attribute::where('profile_id', $user->profiles->first()->id)->get();

        return inertia('Data/ProductCreate', compact('types', 'attributes'));
    }

    /**
     * Store a newly created product in storage.
     *
     */
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
        $product->profiles()->sync($profileIds);

        // Get the user's profile ID and product types
        $profileId = $user->profiles->first()->id;
        $products = Product::with('type')->get();
        $types = ProductType::where('profile_id', $profileId)->get();

        // Return an Inertia response with updated data
        return Inertia::render('Data/ProductsIndex', [
            'products' => $products,
            'types' => $types,
            'canCreateProduct' => $user->hasPermission('create_products'),
            'canEditProduct' => $user->hasPermission('edit_products'),
            'canDeleteProduct' => $user->hasPermission('delete_products'),
        ]);
    }

    /**
     * Display the specified product.
     *
     */
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

    /**
     * Update the specified product in storage.
     *
     */
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
                    // Check if one dimension is provided without the others
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

    /**
     * Delete the specified product
     *
     */
    public function destroy(Product $product)
    {
        $this->authorizeAction('delete_products');
        // Ensure ownership or admin access
        $this->authorizeOwnership($product);

        // Dissociate the product from its type
        $product->type_id = null;
        $product->save();

        // Dissociate the product from its attributes
        $product->attributes()->detach();

        // Now delete the product
        $product->delete();

        return redirect()->route('pim.products.index');
    }

    /**
     * Check if the current user owns the product or is an admin within profile
     *
     */
    private function authorizeOwnership(Product $product)
    {
        $user = auth()->user();

        // Check if the user is an admin (profile_id = 1)
        if ($user->profiles->first()->id === 1) {
            return;  // Admin has access to everything
        }

        // Get all profile_ids of the user
        $userProfileIds = $user->profiles->pluck('id')->toArray();

        // Check if the product's profile_id exists in the list of user's profiles
        if (!in_array($product->profile_id, $userProfileIds)) {
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
        // Get the authenticated user
        $user = auth()->user();

        // Check if the user has the required permission
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
