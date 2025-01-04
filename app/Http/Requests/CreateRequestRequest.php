<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipient_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::notIn([auth()->id()]),
            ],
            'listing_id' => 'required|integer|exists:listings,id',
            'start_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after:start_date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_id.required' => 'Pole recipient_id jest wymagane.',
            'recipient_id.integer' => 'Pole recipient_id musi być liczbą całkowitą.',
            'recipient_id.exists' => 'Wybrany recipient_id nie istnieje w systemie.',
            'recipient_id.not_in' => 'Nie możesz wysłać requestu do samego siebie.',
            'listing_id.required' => 'Pole listing_id jest wymagane.',
            'listing_id.integer' => 'Pole listing_id musi być liczbą całkowitą.',
            'listing_id.exists' => 'Wybrane ogłoszenie nie istnieje w systemie.',
            'start_date.required' => 'Pole Data rozpoczęcia jest wymagane.',
            'start_date.date' => 'Pole Data rozpoczęcia musi być prawidłową datą.',
            'start_date.date_format' => 'Pole Data rozpoczęcia musi być w formacie YYYY-MM-DD.',
            'start_date.after_or_equal' => 'Data rozpoczęcia musi być dzisiejsza lub późniejsza.',
            'end_date.required' => 'Pole Data zakończenia jest wymagane.',
            'end_date.date' => 'Pole Data zakończenia musi być prawidłową datą.',
            'end_date.date_format' => 'Pole Data zakończenia musi być w formacie YYYY-MM-DD.',
            'end_date.after' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.',
        ];
    }
}
