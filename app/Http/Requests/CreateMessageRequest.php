<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'chat_id' => 'required|exists:chats,id',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Treść wiadomości jest wymagana',
            'content.string' => 'Treść wiadomości musi być tekstem',
            'chat_id.required' => 'ID czatu jest wymagane',
            'chat_id.exists' => 'Podany czat nie istnieje',
        ];
    }
} 