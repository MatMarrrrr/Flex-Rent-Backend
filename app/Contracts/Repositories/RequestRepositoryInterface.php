<?php

namespace App\Contracts\Repositories;

use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface RequestRepositoryInterface
{
    public function create(array $data): object;
    public function getIncoming(int $recipientId): Collection;
    public function getOutgoing(int $senderId): Collection;
    public function findRequestById(int $requestId): ?Request;
    public function updateRequestStatus(int $requestId, string $status): bool;
    public function updateRequestPeriod(int $requestId, string $startDate, string $endDate): bool;
}
