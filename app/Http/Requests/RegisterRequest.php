<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
            'repeatPassword' => 'required|string|same:password',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Pole e-mail jest wymagane.',
            'email.email' => 'Podaj poprawny adres e-mail.',
            'email.unique' => 'Podany adres e-mail jest już zajęty.',
            'password.required' => 'Pole hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 6 znaków.',
            'password.regex' => 'Hasło musi zawierać co najmniej jedną dużą literę, cyfrę i znak specjalny.',
            'repeatPassword.required' => 'Pole potwierdzenia hasła jest wymagane.',
            'repeatPassword.same' => 'Hasła muszą być identyczne.',
            'name.required' => 'Pole imie jest wymagane.',
            'surname.required' => 'Pole nazwisko jest wymagane.',
            'city.required' => 'Pole miasto jest wymagane.',
            'province.required' => 'Pole województwo jest wymagane.',
        ];
    }
}
