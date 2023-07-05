<?php

namespace App\Core\Infrastructure\Eloquent;

use App\Core\Domain\AbstractEntity;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentRepository
{
    protected Model $model;
    protected string $entityClass;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): array
    {
        $cModel = $this->model->all();

        return $this->entityClass::fromArrayOfArrays($cModel->toArray());
    }

    public function getById(int $id): ?AbstractEntity
    {
        $model = $this->model->find($id);

        if ($model) {
            return $this->entityClass::fromArray($model->toArray());
        }

        return null;
    }

    public function save(AbstractEntity $entity): bool
    {
        $model = $this->model->newInstance($entity->toArray(), false);

        $model->save();

        return true;
    }

    public function delete(int $id): bool
    {
        $this->model->destroy($id);

        return true;
    }
}
