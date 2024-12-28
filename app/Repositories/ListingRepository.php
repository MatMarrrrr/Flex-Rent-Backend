<?php

namespace App\Repositories;

use App\Contracts\Repositories\ListingRepositoryInterface;
use App\Models\Listing;
use Illuminate\Support\Collection;

class ListingRepository implements ListingRepositoryInterface
{
    public function create(array $data): Listing
    {
        return Listing::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $listing = Listing::find($id);
        return $listing ? $listing->update($data) : false;
    }

    public function search(array $filters): Collection
    {
        $query = Listing::query()->where('status', 'active');

        if (!empty($filters['query'])) {
            $query->where('name', 'LIKE', '%' . $filters['query'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['localization'])) {
            $query->where('localization', 'LIKE', '%' . $filters['localization'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): ?Listing
    {
        return Listing::find($id);
    }

    public function getByOwner(int $ownerId): Collection
    {
        return Listing::where('owner_id', $ownerId)->orderBy('created_at', 'desc')->get();
    }

    public function findByIdAndOwner(int $id, int $ownerId): ?Listing
    {
        return Listing::where('id', $id)->where('owner_id', $ownerId)->first();
    }

    public function markAsDeleted(int $id): bool
    {
        $listing = Listing::find($id);
        if ($listing) {
            $listing->status = 'deleted';
            return $listing->save();
        }
        return false;
    }
}
