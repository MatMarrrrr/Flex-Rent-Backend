<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface CategoryServiceInterface
{
    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection;
}
