<?php

namespace App\Services;

use App\Contracts\Services\RentalServiceInterface;
use App\Contracts\Repositories\RentalRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class RentalService implements RentalServiceInterface
{
    private RentalRepositoryInterface $rentalRepository;
    private UserServiceInterface $userService;

    public function __construct(RentalRepositoryInterface $rentalRepository, UserServiceInterface $userService)
    {
        $this->rentalRepository = $rentalRepository;
        $this->userService = $userService;
    }

    public function getUserRentals(): Collection
    {
        $user = $this->userService->getCurrentUser();
        return $this->rentalRepository->getUserRentals($user->id);
    }
}
