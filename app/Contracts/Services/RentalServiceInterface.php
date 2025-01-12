<?php

namespace App\Contracts\Services;
use Illuminate\Http\JsonResponse;

interface RentalServiceInterface
{
    public function getUserRentals(): JsonResponse;
} 