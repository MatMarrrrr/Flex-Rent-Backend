<?php

namespace App\Repositories;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequestRepository implements RequestRepositoryInterface
{
    public function create(array $data): Request
    {
        return Request::create($data);
    }

    public function getIncoming(int $recipientId): Collection
    {
        return Request::with('listing')
            ->where('recipient_id', $recipientId)
            ->orderByRaw("CASE status 
                WHEN 'waiting' THEN 1 
                WHEN 'accepted' THEN 2 
                WHEN 'confirmed' THEN 3 
                WHEN 'declined' THEN 4 
                WHEN 'canceled' THEN 5 
                END")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOutgoing(int $senderId): Collection
    {
        return Request::with('listing')
            ->where('sender_id', $senderId)
            ->where('status', '!=', 'confirmed')
            ->orderByRaw("CASE status 
                WHEN 'waiting' THEN 1 
                WHEN 'accepted' THEN 2 
                WHEN 'confirmed' THEN 3 
                WHEN 'declined' THEN 4 
                WHEN 'canceled' THEN 5 
                END")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findRequestById(int $requestId): ?Request
    {
        return Request::find($requestId);
    }

    public function updateRequestStatus(int $requestId, string $status): bool
    {
        $request = $this->findRequestById($requestId);

        if (!$request) {
            return false;
        }

        $request->status = $status;
        return $request->save();
    }

    public function updateRequestPeriod(int $requestId, string $startDate, string $endDate): bool
    {
        $request = $this->findRequestById($requestId);

        if (!$request) {
            return false;
        }

        $request->start_date = $startDate;
        $request->end_date = $endDate;

        return $request->save();
    }
}
