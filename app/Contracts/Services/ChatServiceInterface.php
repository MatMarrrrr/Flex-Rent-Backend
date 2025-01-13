<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface ChatServiceInterface
{
    public function getAllChats(): JsonResponse;
    public function getChatByRequestID($request_id): JsonResponse;
    public function getChatByRentalID($rental_id): JsonResponse;
}
