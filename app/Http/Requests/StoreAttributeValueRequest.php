<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate incoming request to store a new product attribute value.
 *
 */
class StoreAttributeValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'values' => 'required|array',
            'values.*.attribute_id' => 'required|exists:attributes,id',
            'values.*.value' => 'required|string',
        ];
    }
}
