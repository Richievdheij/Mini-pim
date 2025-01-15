<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class NewPasswordRequest extends FormRequest
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
     * Rules for validating the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $this->input('email'))->first();
                    if ($user && Hash::check($value, $user->password)) {
                        $fail(__('The new password cannot be the same as your current password.'));
                    }
                },
            ],
            'token' => 'required',
        ];
    }

    /**
     * Reset the user's password.
     *
     * @throws ValidationException
     * @return void
     */
    public function resetPassword(): void
    {
        $user = User::where('email', $this->input('email'))->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('No user found with the provided email address.'),
            ]);
        }

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __('Password reset failed. Please try again.'),
            ]);
        }
    }
}
