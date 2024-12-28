<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface ListingServiceInterface
{
    public function createListing(array $data): JsonResponse;
    public function updateListing(int $listingId, array $data, int $userId): JsonResponse;
    public function updateListingImage(int $listingId, array $data, int $userId): JsonResponse;
    public function searchListings(array $filters): JsonResponse;
    public function getListingById(int $id): JsonResponse;
    public function getListingByIdAndOwner(int $listingId, int $userId): JsonResponse;
    public function getListingsByOwner(int $ownerId): JsonResponse;
    public function deleteListing(int $id, int $userId): JsonResponse;
}
