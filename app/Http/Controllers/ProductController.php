<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Services\ProductService;
use App\Http\Services\ProductTypeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller that handles all logic related to the products in the Mini-PIM
 */
class ProductController extends Controller
{
    protected ProductService $productService;
    protected ProductTypeService $productTypeService;

    public function __construct(ProductService $productService, ProductTypeService $productTypeService)
    {
        $this->productService = $productService;
        $this->productTypeService = $productTypeService;
    }

    /**
     * Display the PIM dashboard.
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        return Inertia::render('PIM/PIMDashboard');
    }

    /**
     * Display the products index page.
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->authorizeAction('view_products');

        return Inertia::render('Data/ProductsIndex', [
            'products' => $this->productService->retrieveProducts(),
            'types' => $this->productTypeService->retrieveProductTypes(),
            'canCreateProduct' => Auth::user()->hasPermission('create_products'),
            'canEditProduct' => Auth::user()->hasPermission('edit_products'),
            'canDeleteProduct' => Auth::user()->hasPermission('delete_products'),
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $this->authorizeAction('create_products');

        // Create the product
        $this->productService->createProduct($request->validated());

        return redirect()->route('pim.products.index');
    }

    /**
     * Display the specified product for editing.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        $this->authorizeAction('edit_products');

        return Inertia::render('Data/ProductEdit', $this->productService->getProductEditData($id));
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, int $id): RedirectResponse
    {
        $this->authorizeAction('edit_products');

        // Update the product
        $this->productService->updateProduct($id, $request->validated());

        return redirect()->route('pim.products.index');
    }

    /**
     * Delete the specified product.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorizeAction('delete_products');

        // Delete the product
        $this->productService->deleteProduct($id);

        return redirect()->route('pim.products.index');
    }
}
