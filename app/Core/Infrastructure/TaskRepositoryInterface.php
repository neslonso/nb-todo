<?php

namespace App\Core\Infrastructure;

use App\Core\Domain\Task\Task;

interface TaskRepositoryInterface
{
    public function getAllTasks(?int $user_id): ?array;

    public function getTaskById(int $id): ?Task;

    public function saveTask(Task $task): bool;

    public function deleteTask(int $id): bool;

    public function toggleCompleted(int $id): bool;
}
