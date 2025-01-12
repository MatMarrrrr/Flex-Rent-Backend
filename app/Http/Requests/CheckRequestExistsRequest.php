<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequestExistsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_id' => 'required|integer|exists:users,id',
            'recipient_id' => 'required|integer|exists:users,id',
            'listing_id' => 'required|integer|exists:listings,id',
        ];
    }

    public function messages(): array
    {
        return [
            'sender_id.required' => 'Pole sender_id jest wymagane.',
            'sender_id.integer' => 'Pole sender_id musi być liczbą.',
            'sender_id.exists' => 'Wybrany sender_id nie istnieje w bazie danych użytkowników.',
            'recipient_id.required' => 'Pole recipient_id jest wymagane.',
            'recipient_id.integer' => 'Pole recipient_id musi być liczbą.',
            'recipient_id.exists' => 'Wybrany recipient_id nie istnieje w bazie danych użytkowników.',
            'listing_id.required' => 'Pole listing_id jest wymagane.',
            'listing_id.integer' => 'Pole listing_id musi być liczbą.',
            'listing_id.exists' => 'Wybrany listing_id nie istnieje w bazie danych ofert.',
        ];
    }
}
