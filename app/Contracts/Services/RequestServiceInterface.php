<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

interface RequestServiceInterface
{
    public function createRequest(array $data): JsonResponse;
    public function getIncomingRequests(int $userId): JsonResponse;
    public function getOutgoingRequests(int $userId): JsonResponse;
    public function acceptRequest(int $requestId, int $userId): JsonResponse;
    public function declineRequest(int $requestId, int $userId): JsonResponse;
    public function confirmRequest(int $requestId, int $userId): JsonResponse;
    public function cancelRequest(int $requestId, int $userId): JsonResponse;
    public function updateRequestPeriod(int $requestId, int $userId, array $period): JsonResponse;
    public function checkRequestExists(array $data): JsonResponse;
}
