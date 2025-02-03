<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $profileId = $this->user()->profiles->first()->id;

        return [
            'name' => [
                'required',
                'string',
                // The unique rule is used to ensure that the name is unique for the profile.
                Rule::unique('product_types', 'name')
                    ->ignore($this->route('productType')?->id)
                    ->where('profile_id', $profileId),
            ],
        ];
    }
}
