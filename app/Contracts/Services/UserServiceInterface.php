<?php

namespace App\Contracts\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

interface UserServiceInterface
{
    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function getCurrentUser(): ?Authenticatable;

    /**
     * Check if an email already exists in the database.
     *
     * @param string $email
     * @return bool
     */
    public function checkIfEmailExists(string $email): bool;

    /**
     * Update user data with validated input.
     *
     * @param array $validatedData
     * @return JsonResponse
     */
    public function updateUserData(array $validatedData): JsonResponse;

    /**
     * Update the user's profile image.
     *
     * @param UploadedFile $validatedFile
     * @return JsonResponse
     */
    public function updateUserProfileImage(UploadedFile $validatedFile): JsonResponse;
}
