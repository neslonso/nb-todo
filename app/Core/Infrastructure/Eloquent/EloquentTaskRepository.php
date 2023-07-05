<?php

namespace App\Core\Infrastructure\Eloquent;

use App\Core\Domain\Task\Task;
use App\Core\Infrastructure\TaskRepositoryInterface;

class EloquentTaskRepository extends AbstractEloquentRepository implements TaskRepositoryInterface
{
    protected string $entityClass = Task::class;

    /**
     * @return array<Task>
     */
    public function getAllTasks(?int $user_id): array
    {
        $qBuilder = $this->model::with(['categories' => function ($query) {
            $query->select('id', 'name');
        }]);

        if (!is_null($user_id)) {
            $qBuilder = $qBuilder->where('user_id', $user_id);
        }

        $cModel = $qBuilder->get();

        return $this->entityClass::fromArrayOfArrays($cModel->toArray());
    }

    public function getTaskById(int $id): ?Task
    {
        return parent::getById($id);
    }

    public function saveTask(Task $task): bool
    {
        $aSync = array_map(function ($elto) {
            return [
                'category_id' => $elto['id'],
                'created_At' => now(),
            ];
        }, $task->getCategories());

        $mTask = $this->model->findOrNew($task->getId());
        $mTask->fill($task->toArray());
        $mTask->save();
        $mTask->categories()->sync($aSync);

        /*
        //$update = is_numeric($task->getId()) && $task->getId() > 0;
        if ($update) {
            $mTask = $this->model->find($task->getId());
            $mTask->title = $task->getTitle();
            $mTask->description = $task->getDescription();
            $mTask->is_completed = $task->getIs_completed();
            $mTask->save();
        } else {
            $mTask = $this->model->newInstance($task->toArray(), false);
            $mTask->save();
        }
        $mTask->categories()->sync($task->getCategories());
        */

        return true;
    }

    public function deleteTask(int $id): bool
    {
        return parent::delete($id);
    }

    public function toggleCompleted(int $id): bool
    {
        $task = $this->model->find($id);

        $task->is_completed = !$task->is_completed;

        $task->save();

        return true;
    }
}
