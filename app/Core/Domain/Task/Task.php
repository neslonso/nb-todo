<?php

namespace App\Core\Domain\Task;

use App\Core\Domain\AbstractEntity;
use App\Core\Domain\Category\Category;

class Task extends AbstractEntity
{
    protected ?int $id;
    protected ?int $user_id;
    protected ?string $title;
    protected ?string $description;
    protected ?bool $is_completed;
    protected ?string $completed_at;
    protected ?array $categories;

    public function __construct(?int $id = null, ?int $user_id = null, ?string $title = null, ?string $description = null, ?bool $is_completed = null, ?string $completed_at = null, array $categories = [])
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->is_completed = $is_completed;
        $this->completed_at = $completed_at;
        $this->categories = $categories;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIs_completed(): ?bool
    {
        return $this->is_completed;
    }

    public function getCompleted_at(): ?string
    {
        return $this->completed_at;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setUser_id(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setIs_completed(?bool $is_completed): void
    {
        $this->is_completed = $is_completed;
    }

    public function setCompleted_at(?string $completed_at): void
    {
        $this->completed_at = $completed_at;
    }

    public function setCategories(?array $categories): void
    {
        $this->categories = $categories;
    }

    public function assignCategory(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Category $category): void
    {
        $this->categories = array_filter($this->categories, function ($c) use ($category) {
            return $c->getId() !== $category->getId();
        });
    }
}
