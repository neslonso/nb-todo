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

    public function saveTask(Task $task): bool|Task
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

        // $mTask->categories()->sync($aSync); // sync falla si ya existe el registro, integrity constraint violation ¿ porqué intenta volver a meter registros que ya existen ?
        $mTask->categories()->detach();
        $mTask->categories()->attach($aSync);

        $task = Task::fromArray($mTask->toArray());

        return $task;
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
