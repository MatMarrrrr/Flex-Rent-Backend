<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;
    public function emailExists(string $email): bool;
    public function updateUser(int $userId, array $data): ?User;
}
