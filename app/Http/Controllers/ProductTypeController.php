<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeRequest;
use App\Http\Services\ProductTypeService;
use App\Models\ProductType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller handles all logic related to the product types,
 * such as creating, updating, and deleting them
 *
 */
class ProductTypeController extends Controller
{
    protected ProductTypeService $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;
    }

    /**
     * Display a listing of the product types.
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->authorizeAction('view_types');

        return Inertia::render('Types/Index', [
            'types' => $this->productTypeService->retrieveProductTypes(),
            'canCreateType' => Auth::user()->hasPermission('create_types'),
            'canEditType' => Auth::user()->hasPermission('edit_types'),
            'canDeleteType' => Auth::user()->hasPermission('delete_types'),
        ]);
    }

    /**
     * Show the form for creating a new product type.
     *
     * @return Response
     */
    public function create(): Response
    {
        $this->authorizeAction('create_types');

        return Inertia::render('ProductTypes/Create');
    }

    /**
     * Store a newly created product type in storage.
     *
     * @param ProductTypeRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProductTypeRequest $request): RedirectResponse
    {
        $this->authorizeAction('create_types');

        // Create the product type
        $this->productTypeService->createProductType($request->validated());

        return redirect()->route('pim.types.index');
    }

    /**
     * Update the specified product type in storage.
     *
     * @param ProductTypeRequest $request
     * @param ProductType $productType
     *
     * @return RedirectResponse
     */
    public function update(ProductTypeRequest $request, ProductType $productType): RedirectResponse
    {
        $this->authorizeAction('edit_types');

        // Update the product type
        $this->productTypeService->updateProductType($productType, $request->validated());

        return redirect()->route('pim.types.index');
    }

    /**
     * Remove the specified product type from storage.
     *
     * @param ProductType $productType
     *
     * @return RedirectResponse
     */
    public function destroy(ProductType $productType): RedirectResponse
    {
        $this->authorizeAction('delete_types');

        // If the product type is successfully deleted, redirect with a success message
        if ($this->productTypeService->deleteProductType($productType)) {
            return redirect()->route('pim.types.index');
        }

        // If the product type has associated attributes, return an error message
        return back();
    }
}

