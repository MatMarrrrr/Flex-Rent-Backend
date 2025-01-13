<?php

namespace App\Contracts\Repositories;

use App\Models\Message;
use Illuminate\Support\Collection;

interface MessageRepositoryInterface
{
    public function create(array $data): Message;
    public function getByChatId(int $chatId): Collection;
}
