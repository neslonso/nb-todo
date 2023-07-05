<?php

namespace App\Core\Domain\Category;

use App\Core\Infrastructure\CategoryRepositoryInterface;

class CategoryService
{
    private CategoryRepositoryInterface $CategoryRepository;

    public function __construct(CategoryRepositoryInterface $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function getAllCategories(): ?array
    {
        return $this->CategoryRepository->getAllCategories();
    }
}
