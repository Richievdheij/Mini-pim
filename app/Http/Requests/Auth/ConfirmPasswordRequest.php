<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Allow only authenticated users to confirm their password
        return true;
    }

    /**
     * Validate the request data and confirm the password.
     *
     * @throws ValidationException
     */
    public function confirmPassword(): void
    {
        // Validate the password
        if (!Auth::guard('web')->validate([
            'email' => $this->user()->email,
            'password' => $this->input('password'),
        ])) {
            // Throw a validation exception if the password is incorrect
            throw ValidationException::withMessages(['password' => trans('auth.password')]);
        }
    }
}
