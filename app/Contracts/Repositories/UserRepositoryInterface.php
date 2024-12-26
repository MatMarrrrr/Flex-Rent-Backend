<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Check if an email already exists in the database.
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool;

    /**
     * Update a user's data by their ID.
     *
     * @param int $userId
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $userId, array $data): ?User;
}
