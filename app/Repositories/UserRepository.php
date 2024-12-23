<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
