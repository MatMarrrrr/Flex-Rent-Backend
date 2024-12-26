<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
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
            'name.required' => 'Pole imie jest wymagane.',
            'surname.required' => 'Pole nazwisko jest wymagane.',
            'city.required' => 'Pole miasto jest wymagane.',
        ];
    }
}
