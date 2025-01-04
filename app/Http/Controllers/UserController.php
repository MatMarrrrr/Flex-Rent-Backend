<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ProfileImageRequest;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return response()->json($user, 200);
    }

    public function checkEmail(string $email): JsonResponse
    {
        return $this->userService->checkIfEmailExists($email);
    }

    public function update(UserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->userService->updateUserData($validatedData);
    }

    public function updateProfileImage(ProfileImageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $profileImage = $validatedData['profile_image'];
        return $this->userService->updateUserProfileImage($profileImage);
    }
}
