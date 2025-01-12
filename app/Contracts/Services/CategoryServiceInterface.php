<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface CategoryServiceInterface
{
    /**
     * Get all categories.
     *
     * @return JsonResponse
     */
    public function getAllCategories(): JsonResponse;
}
