<?php

namespace App\Services;

use App\Contracts\Services\RentalServiceInterface;
use App\Contracts\Repositories\RentalRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RentalService implements RentalServiceInterface
{
    private RentalRepositoryInterface $rentalRepository;
    private UserServiceInterface $userService;

    public function __construct(RentalRepositoryInterface $rentalRepository, UserServiceInterface $userService)
    {
        $this->rentalRepository = $rentalRepository;
        $this->userService = $userService;
    }

    public function getUserRentals(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        $rentals = $this->rentalRepository->getUserRentals($user->id);

        return response()->json($rentals, Response::HTTP_OK);
    }
}
