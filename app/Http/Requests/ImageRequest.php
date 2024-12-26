<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Zdjęcie jest wymagane.',
            'image.file' => 'Zdjęcie musi być plikiem.',
            'image.mimes' => 'Zdjęcie musi mieć rozszerzenie: jpg, jpeg, png.',
            'image.max' => 'Zdjęcie nie może być większe niż 2MB.',
        ];
    }
}
