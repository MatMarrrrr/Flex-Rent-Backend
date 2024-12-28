<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface ListingRepositoryInterface
{
    public function create(array $data): object;
    public function update(int $id, array $data): bool;
    public function search(array $filters): Collection;
    public function findById(int $id): ?object;
    public function getByOwner(int $ownerId): Collection;
    public function findByIdAndOwner(int $id, int $ownerId): ?object;
    public function markAsDeleted(int $id): bool;
}
