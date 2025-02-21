<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles the incoming request for updating a product.
 */
class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('edit_products');
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|string',
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:product_types,id',
            'weight' => 'nullable|min:0|max:1000000.00',
            // If any of the dimensions are provided, all three must be provided
            'width' => 'required_with:height,depth|nullable|numeric|min:0|max:1000000.00',
            'height' => 'required_with:width,depth|nullable|numeric|min:0|max:1000000.00',
            'depth' => 'required_with:width,height|nullable|numeric|min:0|max:1000000.00',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0|max:1000000.00',
            'stock_quantity' => 'required|integer|min:0|max:1000000.00',
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => 'string|nullable',

        ];
    }
}
