<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ListingServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\SearchListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Http\JsonResponse;

class ListingController extends Controller
{
    private ListingServiceInterface $listingService;
    private UserServiceInterface $userService;

    public function __construct(ListingServiceInterface $listingService, UserServiceInterface $userService)
    {
        $this->listingService = $listingService;
        $this->userService = $userService;
    }

    public function create(CreateListingRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->getCurrentUser();
        $validatedData['owner_id'] = $user->id;

        return $this->listingService->createListing($validatedData);
    }

    public function update(UpdateListingRequest $request, int $listingId): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->getCurrentUser();
        return $this->listingService->updateListing($listingId, $validatedData, $user->id);
    }

    public function updateImage(ImageRequest $request, int $listingId): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->getCurrentUser();
        return $this->listingService->updateListingImage($listingId, $validatedData, $user->id);
    }

    public function search(SearchListingRequest $request): JsonResponse
    {
        $filters = $request->validated();
        return $this->listingService->searchListings($filters);
    }

    public function findById(int $listingId): JsonResponse
    {
        return $this->listingService->getListingById($listingId);
    }

    public function findByIdAndOwner(int $listingId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->listingService->getListingByIdAndOwner($listingId, $user->id);
    }

    public function getByOwner(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->listingService->getListingsByOwner($user->id);
    }

    public function delete(int $listingId): JsonResponse
    {
        $user = $this->userService->getCurrentUser();
        return $this->listingService->deleteListing($listingId, $user->id);
    }
}
