<?php

namespace App\Services;

use App\Contracts\Repositories\ChatRepositoryInterface;
use App\Contracts\Services\ChatServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ChatService implements ChatServiceInterface
{
    protected ChatRepositoryInterface $chatRepository;
    protected UserServiceInterface $userService;

    public function __construct(
        ChatRepositoryInterface $chatRepository,
        UserServiceInterface $userService
    ) {
        $this->chatRepository = $chatRepository;
        $this->userService = $userService;
    }

    public function getAllChats(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        $categories = $this->chatRepository->getChats($user->id);
        return response()->json($categories, Response::HTTP_OK);
    }

    public function getChatByRequestID($request_id): JsonResponse
    {
        $chat = $this->chatRepository->getByRequestId($request_id);
        return response()->json(["chat" => $chat], Response::HTTP_OK);
    }

    public function getChatByRentalID($rental_id): JsonResponse
    {
        $chat = $this->chatRepository->getByRentalId($rental_id);
        return response()->json(["chat" => $chat], Response::HTTP_OK);
    }
}
