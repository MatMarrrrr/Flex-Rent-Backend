<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $validatedData): JsonResponse
    {
        $user = $this->userRepository->createUser([
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
            'profile_image' => null,
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => $validatedData['password'],
        ];

        return $this->loginUser($credentials);
    }

    public function loginUser(array $credentials): JsonResponse
    {
        if (auth()->attempt($credentials)) {

            /** @var User $user */
            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Nieprawidłowe dane logowania',
        ], 401);
    }

    public function logoutUser(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Wylogowano pomyślnie',
        ], 200);
    }
}
