<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Repositories\ChatRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ChatService
{
    protected ChatRepository $chatRepository;
    protected UserServiceInterface $userService;

    public function __construct(ChatRepository $chatRepository, UserServiceInterface $userService)
    {
        $this->chatRepository = $chatRepository;
        $this->userService = $userService;
    }

    public function getAllChats(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        $categories = $this->chatRepository->getChats($user->id);
        return response()->json($categories, Response::HTTP_OK);
    }
}
