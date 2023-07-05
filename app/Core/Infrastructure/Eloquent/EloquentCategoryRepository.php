<?php

namespace App\Core\Infrastructure\Eloquent;

use App\Core\Domain\Category\Category;
use App\Core\Infrastructure\CategoryRepositoryInterface;

class EloquentCategoryRepository extends AbstractEloquentRepository implements CategoryRepositoryInterface
{
    protected string $entityClass = Category::class;

    /**
     * @return array<Category>
     */
    public function getAllCategories(): array
    {
        return parent::getAll();
    }

    public function getCategoryById(int $id): ?Category
    {
        return parent::getById($id);
    }

    public function saveCategory(Category $category): bool
    {
        return parent::save($category);
    }

    public function deleteCategory(int $id): bool
    {
        return parent::delete($id);
    }
}
