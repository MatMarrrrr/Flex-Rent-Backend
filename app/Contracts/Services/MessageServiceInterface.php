<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface MessageServiceInterface
{
    public function createMessage(array $data): JsonResponse;
    public function getMessagesByChatId(int $chatId): JsonResponse;
}
