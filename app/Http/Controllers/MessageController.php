<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use App\Events\MessageSent;

class MessageController extends Controller
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function create(CreateMessageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->messageService->createMessage($validatedData);
    }

    public function getByChatId(int $chatId): JsonResponse
    {
        return $this->messageService->getMessagesByChatId($chatId);
    }
}
