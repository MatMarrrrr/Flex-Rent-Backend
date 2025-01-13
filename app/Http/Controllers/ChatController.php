<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ChatServiceInterface;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    private ChatServiceInterface $chatService;

    public function __construct(ChatServiceInterface $chatService)
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
