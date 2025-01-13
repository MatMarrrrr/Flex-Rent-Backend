<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MessageServiceInterface;
use App\Http\Requests\CreateMessageRequest;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    private MessageServiceInterface $messageService;

    public function __construct(MessageServiceInterface $messageService)
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
