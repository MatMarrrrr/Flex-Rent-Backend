<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Pole e-mail jest wymagane.',
            'email.email' => 'Podaj poprawny adres e-mail.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 6 znaków.',
            'password.regex' => 'Hasło musi zawierać co najmniej jedną dużą literę, cyfrę i znak specjalny.',
        ];
    }
}
