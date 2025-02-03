<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

/**
 * Handles the incoming request for users.
 */
class UserRequest extends FormRequest
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
     * Define the validation rules for the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'profiles' => 'required|array|min:1',
            'profiles.*' => 'exists:profiles,id',
        ];

        if ($this->isMethod('post')) {
            // Validate password only for store requests
            $rules['password'] = [
                'required',
                PasswordRules::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Password is optional for update requests
            $rules['password'] = 'nullable|min:8';
        }

        return $rules;
    }
}
