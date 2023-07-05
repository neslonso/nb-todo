<?php

namespace App\Core\Domain\Task;

use App\Core\Infrastructure\TaskRepositoryInterface;

class TaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks($user_id): ?array
    {
        return $this->taskRepository->getAllTasks($user_id);
    }

    public function getTaskById(int $id): ?Task
    {
        return $this->taskRepository->getTaskById($id);
    }

    public function saveTask(int $id = null, int $user_id, string $title, string $description, bool $is_completed, array $categories): bool|Task
    {
        $task = new Task($id, $user_id, $title, $description, $is_completed, null, $categories);

        return $this->taskRepository->saveTask($task);
    }

    public function deleteTask(int $id): bool
    {
        return $this->taskRepository->deleteTask($id);
    }

    public function toggleCompleted(int $id): bool
    {
        return $this->taskRepository->toggleCompleted($id);
    }
}
