<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image|max:2048',
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
            'image.required' => 'Obraz jest wymagany.',
            'image.image' => 'Przesłany plik musi być obrazem.',
            'image.max' => 'Obraz nie może przekraczać 2MB.',
            'name.required' => 'Nazwa jest wymagana.',
            'name.max' => 'Nazwa nie może mieć więcej niż 255 znaków.',
            'category_id.required' => 'Kategoria jest wymagana.',
            'category_id.integer' => 'Kategoria musi być liczbą całkowitą.',
            'category_id.exists' => 'Podana kategoria nie istnieje.',
            'price.required' => 'Cena jest wymagana.',
            'price.numeric' => 'Cena musi być liczbą.',
            'price.min' => 'Cena musi być większa lub równa 0.',
            'currency.required' => 'Waluta jest wymagana.',
            'currency.size' => 'Waluta musi mieć dokładnie 3 znaki.',
            'localization.required' => 'Lokalizacja jest wymagana.',
            'localization.max' => 'Lokalizacja nie może mieć więcej niż 255 znaków.',
            'description.required' => 'Opis jest wymagany.',
        ];
    }
}
