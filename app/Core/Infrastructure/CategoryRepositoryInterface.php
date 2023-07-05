<?php

namespace App\Core\Infrastructure;

use App\Core\Domain\Category\Category;

interface CategoryRepositoryInterface
{
    public function getAllCategories(): ?array;

    public function getCategoryById(int $id): ?Category;

    public function saveCategory(Category $task): bool|Category;

    public function deleteCategory(int $id): bool;
}
