<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
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
