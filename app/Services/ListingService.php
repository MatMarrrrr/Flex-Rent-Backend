<?php

namespace App\Services;

use App\Contracts\Repositories\ListingRepositoryInterface;
use App\Contracts\Services\ImgurServiceInterface;
use App\Contracts\Services\ListingServiceInterface;
use Illuminate\Http\JsonResponse;

class ListingService implements ListingServiceInterface
{
    private ListingRepositoryInterface $listingRepository;
    private ImgurServiceInterface $imgurService;

    public function __construct(
        ListingRepositoryInterface $listingRepository,
        ImgurServiceInterface $imgurService
    ) {
        $this->listingRepository = $listingRepository;
        $this->imgurService = $imgurService;
    }

    public function createListing(array $data): JsonResponse
    {
        $uploadResponse = $this->imgurService->uploadImage($data['image']);

        if (!$uploadResponse['success']) {
            return response()->json([
                'message' => $uploadResponse['error'] ?? 'Image upload failed',
            ], 400);
        }

        $data['image'] = $uploadResponse['link'];

        $listing = $this->listingRepository->create($data);

        if ($listing) {
            return response()->json([
                'message' => 'Listing created successfully',
                'listing' => $listing,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to create listing',
        ], 500);
    }

    public function updateListing(int $listingId, array $data, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], 403);
        }

        $updatedListing = $this->listingRepository->update($listingId, $data);

        if ($updatedListing) {
            return response()->json([
                'message' => 'Listing updated successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to update listing',
        ], 500);
    }

    public function updateListingImage(int $listingId, array $data, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], 403);
        }

        $uploadResponse = $this->imgurService->uploadImage($data['image']);

        if (!$uploadResponse['success']) {
            return response()->json([
                'message' => $uploadResponse['error'] ?? 'Image upload failed',
            ], 400);
        }

        $updatedListing = $this->listingRepository->update($listingId, ['image' => $uploadResponse['link']]);

        if ($updatedListing) {
            return response()->json([
                'message' => 'Listing image updated successfully',
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to update listing image',
        ], 500);
    }


    public function searchListings(array $filters): JsonResponse
    {
        $results = $this->listingRepository->search($filters);
        $results = $this->listingRepository->appendReservedPeriods($results);

        return response()->json(['results' => $results], 200);
    }

    public function getListingById(int $listingId): JsonResponse
    {
        $listing = $this->listingRepository->findById($listingId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], 404);
        }
        $listing = $this->listingRepository->appendReservedPeriods($listing);

        return response()->json($listing, 200);
    }

    public function getListingByIdAndOwner(int $listingId, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], 403);
        }

        return response()->json($listing, 200);
    }


    public function getListingsByOwner(int $ownerId): JsonResponse
    {
        $listings = $this->listingRepository->getByOwner($ownerId);

        return response()->json($listings, 200);
    }

    public function deleteListing(int $listingId, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], 403);
        }

        $markedAsDeleted = $this->listingRepository->markAsDeleted($listingId);

        if ($markedAsDeleted) {
            return response()->json(['message' => 'Listing marked as deleted successfully'], 200);
        }

        return response()->json(['message' => 'Failed to mark listing as deleted'], 500);
    }
}
