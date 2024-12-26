<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    /**
     * Register a new user.
     *
     * @param array $validatedData
     * @return JsonResponse
     */
    public function registerUser(array $validatedData): JsonResponse;

    /**
     * Log in a user with given credentials.
     *
     * @param array $credentials
     * @return JsonResponse
     */
    public function loginUser(array $credentials): JsonResponse;

    /**
     * Log out the currently authenticated user.
     *
     * @return JsonResponse
     */
    public function logoutUser(): JsonResponse;
}
