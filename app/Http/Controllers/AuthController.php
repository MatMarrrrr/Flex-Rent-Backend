<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->authService->registerUser($validatedData);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->authService->loginUser($validatedData);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logoutUser();
    }
}
