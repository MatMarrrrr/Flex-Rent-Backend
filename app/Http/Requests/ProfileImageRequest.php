<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.required' => 'Zdjęcie profilowe jest wymagane.',
            'profile_image.file' => 'Zdjęcie profilowe musi być plikiem.',
            'profile_image.mimes' => 'Zdjęcie profilowe musi mieć rozszerzenie: jpg, jpeg, png.',
            'profile_image.max' => 'Zdjęcie profilowe nie może być większe niż 2MB.',
        ];
    }
}
