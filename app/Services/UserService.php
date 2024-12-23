<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        return auth()->user();
    }

    public function checkIfEmailExists(string $email): bool
    {
        return $this->userRepository->emailExists($email);
    }
}
