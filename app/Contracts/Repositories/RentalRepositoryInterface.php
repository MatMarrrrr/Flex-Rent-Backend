<?php

namespace App\Contracts\Repositories;

use App\Models\Rental;
use Illuminate\Support\Collection;

interface RentalRepositoryInterface
{
    public function create(array $data): Rental;
    public function getUserRentals(int $userId): Collection;
} 