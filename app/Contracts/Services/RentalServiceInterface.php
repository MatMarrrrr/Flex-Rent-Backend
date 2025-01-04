<?php

namespace App\Contracts\Services;
use Illuminate\Support\Collection;

interface RentalServiceInterface
{
    public function getUserRentals(): Collection;
} 