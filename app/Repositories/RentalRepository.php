<?php

namespace App\Repositories;

use App\Models\Rental;
use App\Contracts\Repositories\RentalRepositoryInterface;
use Illuminate\Support\Collection;
class RentalRepository implements RentalRepositoryInterface
{
    public function create(array $data): Rental
    {
        return Rental::create($data);
    }

    public function getUserRentals(int $userId): Collection
    {
        return Rental::where('borrower_id', $userId)
            ->with(['listing', 'owner', 'request'])
            ->get();
    }
} 