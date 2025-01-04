<?php

namespace App\Http\Controllers;

use App\Contracts\Services\RentalServiceInterface;
use Illuminate\Http\JsonResponse;

class RentalController extends Controller
{

    private RentalServiceInterface $rentalService;

    public function __construct(RentalServiceInterface $rentalServiceInterface)
    {
        $this->rentalService = $rentalServiceInterface;
    }

    public function getRentals(): JsonResponse
    {
        $rentals = $this->rentalService->getUserRentals();
        return response()->json($rentals);
    }
}
