<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatRepositoryInterface;
use App\Models\Chat;
use App\Models\Rental;
use Illuminate\Support\Collection;

class ChatRepository implements ChatRepositoryInterface
{
    public function create(array $data): Chat
    {
        return Chat::create($data);
    }

    public function getChats($userId): Collection
    {
        return Chat::whereHas('request', function ($query) {
            $query->whereIn('status', ['accepted', 'confirmed']);
        })
            ->where(function ($query) use ($userId) {
                $query->where('owner_id', $userId)
                    ->orWhere('borrower_id', $userId);
            })
            ->with([
                'owner',
                'borrower',
                'request' => function ($query) {
                    $query->select(['id', 'listing_id'])
                        ->with(['listing' => function ($query) {
                            $query->select(['id', 'name']);
                        }]);
                },
                'messages' => function ($query) {
                    $query->with('sender');
                },
            ])
            ->get()
            ->map(function ($chat) use ($userId) {
                $chat->recipient = $chat->owner_id == $userId
                    ? $chat->borrower
                    : $chat->owner;

                unset(
                    $chat->owner,
                    $chat->borrower,
                    $chat->owner_id,
                    $chat->borrower_id,
                    $chat->request_id
                );

                return $chat;
            });
    }

    public function getByRequestId($request_id): ?Chat
    {
        return Chat::where('request_id', $request_id)->first();
    }

    public function getByRentalId($rental_id): ?Chat
    {
        $rental = Rental::where('id', $rental_id)->first();
        return Chat::where('request_id', $rental->request_id)->first();
    }
}
