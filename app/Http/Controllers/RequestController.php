<?php

namespace App\Http\Controllers;

use App\Contracts\Services\RequestServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\CreateRequestRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateRequestPeriodRequest;
use Illuminate\Http\Response;

class RequestController extends Controller
{
    private RequestServiceInterface $requestService;
    private UserServiceInterface $userService;

    public function __construct(RequestServiceInterface $requestService, UserServiceInterface $userService)
    {
        $this->requestService = $requestService;
        $this->userService = $userService;
    }

    public function create(CreateRequestRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->getCurrentUser();
        $validatedData['sender_id'] = $user->id;
        return $this->requestService->createRequest($validatedData);
    }

    public function getIncoming(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->getIncomingRequests($user->id);
    }

    public function getOutgoing(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->getOutgoingRequests($user->id);
    }

    public function accept(int $requestId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->acceptRequest($requestId, $user->id);
    }

    public function decline(int $requestId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->declineRequest($requestId, $user->id);
    }

    public function confirm(int $requestId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->confirmRequest($requestId, $user->id);
    }

    public function cancel(int $requestId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->requestService->cancelRequest($requestId, $user->id);
    }

    public function updatePeriod(UpdateRequestPeriodRequest $request, int $requestId): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->getCurrentUser();
        return $this->requestService->updateRequestPeriod(
            $requestId,
            $user->id,
            $validatedData
        );
    }

    public function checkExists(): JsonResponse
    {
        $data = [
            'sender_id' => request()->query('sender_id'),
            'recipient_id' => request()->query('recipient_id'),
            'listing_id' => request()->query('listing_id'),
        ];
        
        return $this->requestService->checkRequestExists($data);
    }
}
