<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CheckEmailRequest;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return response()->json($user, 200);
    }

    public function checkEmail(CheckEmailRequest $request): JsonResponse
    {
        $email = $request->input('email');
        $exists = $this->userService->checkIfEmailExists($email);

        return response()->json(['exists' => $exists], 200);
    }
}
