<?php

namespace App\Services;

use App\Contracts\Repositories\ListingRepositoryInterface;
use App\Contracts\Services\ImgurServiceInterface;
use App\Contracts\Services\ListingServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['image'] = $uploadResponse['link'];

        $listing = $this->listingRepository->create($data);

        if ($listing) {
            return response()->json([
                'message' => 'Listing created successfully',
                'listing' => $listing,
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'message' => 'Failed to create listing',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateListing(int $listingId, array $data, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], Response::HTTP_FORBIDDEN);
        }

        $updatedListing = $this->listingRepository->update($listingId, $data);

        if ($updatedListing) {
            return response()->json([
                'message' => 'Listing updated successfully',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Failed to update listing',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateListingImage(int $listingId, array $data, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], Response::HTTP_FORBIDDEN);
        }

        $uploadResponse = $this->imgurService->uploadImage($data['image']);

        if (!$uploadResponse['success']) {
            return response()->json([
                'message' => $uploadResponse['error'] ?? 'Image upload failed',
            ], Response::HTTP_BAD_REQUEST);
        }

        $updatedListing = $this->listingRepository->update($listingId, ['image' => $uploadResponse['link']]);

        if ($updatedListing) {
            return response()->json([
                'message' => 'Listing image updated successfully',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Failed to update listing image',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function searchListings(array $filters): JsonResponse
    {
        $results = $this->listingRepository->search($filters);
        $results = $this->listingRepository->appendReservedPeriods($results);

        return response()->json(['results' => $results], Response::HTTP_OK);
    }

    public function getListingById(int $listingId): JsonResponse
    {
        $listing = $this->listingRepository->findById($listingId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found'], Response::HTTP_NOT_FOUND);
        }
        $listing = $this->listingRepository->appendReservedPeriods($listing);

        return response()->json($listing, Response::HTTP_OK);
    }

    public function getListingByIdAndOwner(int $listingId, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($listing, Response::HTTP_OK);
    }

    public function getListingsByOwner(int $ownerId): JsonResponse
    {
        $listings = $this->listingRepository->getByOwner($ownerId);
        $listings = $this->listingRepository->appendReservedPeriods($listings);
        return response()->json($listings, Response::HTTP_OK);
    }

    public function deleteListing(int $listingId, int $userId): JsonResponse
    {
        $listing = $this->listingRepository->findByIdAndOwner($listingId, $userId);

        if (!$listing) {
            return response()->json(['message' => 'Listing not found or you are not the owner'], Response::HTTP_FORBIDDEN);
        }

        $markedAsDeleted = $this->listingRepository->markAsDeleted($listingId);

        if ($markedAsDeleted) {
            return response()->json(['message' => 'Listing marked as deleted successfully'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Failed to mark listing as deleted'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
