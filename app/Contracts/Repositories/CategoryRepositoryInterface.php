<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories with specific fields.
     *
     * @return Collection
     */
    public function getAll(): Collection;
}
