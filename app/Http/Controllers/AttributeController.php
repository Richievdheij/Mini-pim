<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeRequest;
use App\Http\Services\AttributeService;
use App\Http\Traits\AuthorizesActions;
use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Handle the incoming request for attributes.
 */
class AttributeController extends Controller
{
    use AuthorizesActions;

    protected AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * Display a listing of the attributes.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Check if the current user has permission to view attributes
        $this->authorizeAction('view_attributes');

        // Retrieve the attributes for the authenticated user
        $attributes = $this->attributeService->getAttributesForUser();
        $types = $this->attributeService->getProductTypesForUser();
        $user = $this->attributeService->getAuthenticatedUser();

        return Inertia::render('Attributes/Index', [
            'attributes' => $attributes,
            'types' => $types,
            'canCreateAttribute' => $user->hasPermission('create_attributes'),
            'canEditAttribute' => $user->hasPermission('edit_attributes'),
            'canDeleteAttribute' => $user->hasPermission('delete_attributes'),
        ]);
    }

    /**
     * Show the form for creating a new attribute.
     * @return Response
     */
    public function create(): Response
    {
        $this->authorizeAction('create_attributes');

        // Retrieve the attribute types
        $types = $this->attributeService->getProductTypesForUser();
        return Inertia::render('Attributes/Create', compact('types'));
    }

    /**
     * Store a newly created attribute in storage.
     * @param AttributeRequest $request
     * @return RedirectResponse
     */
    public function store(AttributeRequest $request): RedirectResponse
    {
        $this->authorizeAction('create_attributes');

        // Validate the request
        $validated = $request->validated();
        $attribute = $this->attributeService->createAttribute($validated);

        return redirect()->route('pim.attributes.index')
            ->with('success', 'Attribute created successfully!')
            ->with('newAttribute', $attribute);
    }

    /**
     * Display the specified attribute.
     * @param Attribute $attribute
     * @return Response
     */
    public function edit(Attribute $attribute): Response
    {
        $this->authorizeAction('edit_attributes');

        // Retrieve the attribute types
        $types = $this->attributeService->getProductTypesForUser();
        return Inertia::render('Attributes/Edit', compact('attribute', 'types'));
    }

    /**
     * Update the specified attribute.
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(AttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $this->authorizeAction('edit_attributes');

        // Validate the request
        $validated = $request->validated();
        $this->attributeService->updateAttribute($attribute, $validated);

        return redirect()->route('pim.attributes.index')->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified attribute from storage.
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        $this->authorizeAction('delete_attributes');

        // Delete the attribute
        $this->attributeService->deleteAttribute($attribute);

        return redirect()->route('pim.attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
