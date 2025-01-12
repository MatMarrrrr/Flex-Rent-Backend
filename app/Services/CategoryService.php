<?php

namespace App\Services;

use App\Contracts\Services\CategoryServiceInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): JsonResponse
    {
        $categories = $this->categoryRepository->getAll();
        return response()->json($categories, Response::HTTP_OK);
    }
}
