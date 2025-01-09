<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Support\Collection;

class MessageRepository
{
    public function create(array $data): Message
    {
        return Message::create([
            'content' => $data['content'],
            'chat_id' => $data['chat_id'],
            'sender_id' => auth()->id()
        ]);
    }

    public function getByChatId(int $chatId): Collection
    {
        return Message::where('chat_id', $chatId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
