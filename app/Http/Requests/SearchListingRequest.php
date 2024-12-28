<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'localization' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'query.string' => 'Wyszukiwanie musi być ciągiem znaków.',
            'query.max' => 'Wyszukiwanie nie może mieć więcej niż 255 znaków.',
            'category_id.integer' => 'ID kategorii musi być liczbą całkowitą.',
            'category_id.exists' => 'Podana kategoria nie istnieje.',
            'localization.string' => 'Lokalizacja musi być ciągiem znaków.',
            'localization.max' => 'Lokalizacja nie może mieć więcej niż 255 znaków.',
        ];
    }
}
