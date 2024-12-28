<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'localization' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa jest wymagana.',
            'name.string' => 'Nazwa musi być ciągiem znaków.',
            'name.max' => 'Nazwa nie może mieć więcej niż 255 znaków.',
            'category_id.required' => 'Kategoria jest wymagana.',
            'category_id.integer' => 'Kategoria musi być liczbą całkowitą.',
            'category_id.exists' => 'Podana kategoria nie istnieje.',
            'price.required' => 'Cena jest wymagana.',
            'price.numeric' => 'Cena musi być liczbą.',
            'price.min' => 'Cena musi być większa lub równa 0.',
            'currency.required' => 'Waluta jest wymagana.',
            'currency.string' => 'Waluta musi być ciągiem znaków.',
            'currency.size' => 'Waluta musi mieć dokładnie 3 znaki.',
            'localization.required' => 'Lokalizacja jest wymagana.',
            'localization.string' => 'Lokalizacja musi być ciągiem znaków.',
            'localization.max' => 'Lokalizacja nie może mieć więcej niż 255 znaków.',
            'description.required' => 'Opis jest wymagany.',
            'description.string' => 'Opis musi być ciągiem znaków.',
        ];
    }
}
