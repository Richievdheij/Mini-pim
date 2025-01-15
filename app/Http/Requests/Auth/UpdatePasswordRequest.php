<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updatePassword(): void
    {
        // Update the user's password
        $this->user()->update([
            'password' => Hash::make($this->input('password')),
        ]);
    }
}
