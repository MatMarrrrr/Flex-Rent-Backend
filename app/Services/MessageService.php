<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Repositories\MessageRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageService
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage(array $data): JsonResponse
    {
        $message = $this->messageRepository->create($data);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message
        ], Response::HTTP_CREATED);
    }

    public function getMessagesByChatId(int $chatId): JsonResponse
    {
        $messages = $this->messageRepository->getByChatId($chatId);

        return response()->json([
            'messages' => $messages
        ], Response::HTTP_OK);
    }
}
