<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Support\Collection;

class MessageService
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage(array $data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function getMessagesByChatId(int $chatId): Collection
    {
        return $this->messageRepository->getByChatId($chatId);
    }
} 