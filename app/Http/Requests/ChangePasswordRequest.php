<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail('Podane stare hasło jest nieprawidłowe');
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'different:old_password',
            ],
            'repeat_password' => [
                'required',
                'string',
                'same:new_password',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Pole stare hasło jest wymagane',
            'old_password.min' => 'Stare hasło musi mieć co najmniej 6 znaków',
            'old_password.regex' => 'Stare hasło musi zawierać co najmniej jedną wielką literę, cyfrę i znak specjalny',

            'new_password.required' => 'Pole nowe hasło jest wymagane',
            'new_password.min' => 'Nowe hasło musi mieć co najmniej 6 znaków',
            'new_password.regex' => 'Nowe hasło musi zawierać co najmniej jedną wielką literę, cyfrę i znak specjalny',
            'new_password.different' => 'Nowe hasło musi różnić się od starego hasła',

            'repeat_password.required' => 'Pole powtórz nowe hasło jest wymagane',
            'repeat_password.same' => 'Powtórzone hasło musi być identyczne z nowym hasłem',
        ];
    }
}
