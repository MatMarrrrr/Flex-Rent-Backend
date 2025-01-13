<?php

namespace App\Contracts\Repositories;

use App\Models\Chat;
use Illuminate\Support\Collection;

interface ChatRepositoryInterface
{
    public function create(array $data): Chat;
    public function getChats($userId): Collection;
    public function getByRequestId($request_id): ?Chat;
    public function getByRentalId($rental_id): ?Chat;
}
