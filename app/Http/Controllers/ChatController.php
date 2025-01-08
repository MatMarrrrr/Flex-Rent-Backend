<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private ChatRepository $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getChats(): JsonResponse
    {
        $userId = auth()->user()->id;
        $chats = $this->chatRepository->getChats($userId);
        return response()->json($chats);
    }
}
