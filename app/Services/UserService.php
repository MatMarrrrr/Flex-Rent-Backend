<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\ImgurServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\UploadedFile;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;
    private ImgurServiceInterface $imgurService;

    public function __construct(UserRepositoryInterface $userRepository, ImgurServiceInterface $imgurService)
    {
        $this->userRepository = $userRepository;
        $this->imgurService = $imgurService;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        return auth()->user();
    }

    public function checkIfEmailExists(string $email): JsonResponse
    {
        $exists = $this->userRepository->emailExists($email);
        if ($exists) {
            return response()->json(null, Response::HTTP_OK);
        }
        return response()->json(null, Response::HTTP_NOT_FOUND);
    }

    public function updateUserData(array $validatedData): JsonResponse
    {
        $user = $this->getCurrentUser();
        $updatedUser = $this->userRepository->updateUser($user->id, $validatedData);

        if ($updatedUser) {
            return response()->json([
                'message' => 'User data updated successfully',
                'updated_data' => $validatedData
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Failed to update user in the database',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateUserProfileImage(UploadedFile $validatedFile): JsonResponse
    {
        $uploadResponse = $this->imgurService->uploadImage($validatedFile);

        if (!$uploadResponse['success']) {
            return response()->json([
                'message' => $uploadResponse['error'] ?? 'Image upload failed',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getCurrentUser();
        $updatedUser = $this->userRepository->updateUser($user->id, [
            'profile_image' => $uploadResponse['link']
        ]);

        if ($updatedUser) {
            return response()->json([
                'message' => 'Profile image updated successfully',
                'image_url' => $updatedUser->profile_image
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Failed to update profile image in the database',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateUserPassword(string $password): JsonResponse
    {
        $user = $this->getCurrentUser();
        $updatedPassword = $this->userRepository->updatePassword($user->id, $password);

        if ($updatedPassword) {
            return response()->json([
                'message' => 'Password updated successfully',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Failed to update password in the database',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
