<?php

namespace App\Http\Controllers;

use App\Core\Application\Interfaces\ApiResponseInterface;
use App\Core\Domain\Category\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAll(ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $apiResponse::create(false, '', (object) ['categories' => $this->categoryService->getAllCategories()])
        );
    }
}
