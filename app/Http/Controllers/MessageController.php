<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function create(CreateMessageRequest $request): JsonResponse
    {
        $message = $this->messageService->createMessage(
            $request->validated()
        );

        return response()->json([
            'message' => $message
        ], 201);
    }

    public function getByChatId(int $chatId): JsonResponse
    {
        $messages = $this->messageService->getMessagesByChatId($chatId);

        return response()->json([
            'messages' => $messages
        ]);
    }
}
