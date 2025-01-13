<?php

namespace App\Services;

use App\Contracts\Repositories\MessageRepositoryInterface;
use App\Contracts\Services\MessageServiceInterface;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageService implements MessageServiceInterface
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
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
