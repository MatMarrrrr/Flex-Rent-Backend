<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function getChats(): JsonResponse
    {
        return $this->chatService->getAllChats();
    }

    public function getChatByRequestId($request_id): JsonResponse
    {
        return $this->chatService->getChatByRequestID($request_id);
    }

    public function getChatByRentalId($rental_id): JsonResponse
    {
        return $this->chatService->getChatByRequestID($rental_id);
    }
}
