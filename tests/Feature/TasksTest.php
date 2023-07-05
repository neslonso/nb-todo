<?php

namespace Tests\Feature;

use App\Core\Domain\Task\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    /*
    public function testTaskEntityBasicTest(): void
    {
        $result = true;
        $reflector = new \ReflectionClass(Task::class);
        $oTask = new Task();

        $properties = [];

        // Llamamos a todos los setters y nos guardamos el valor pasado
        foreach ($reflector->getMethods() as $metodo) {
            $nombreMetodo = $metodo->getName();
            if (strpos($nombreMetodo, 'set') === 0) {
                // Llamar al método set con un valor de ejemplo
                $params = $metodo->getParameters();
                $tipo = ltrim((string) $params[0]->getType(), '?');

                $valor = match ($tipo) {
                    'int' => 123,
                    'float' => 1.23,
                    'string' => 'ejemplo',
                    'bool' => true,
                    'array' => ['a', 'b', 'c'],
                    'DateTime' => new \DateTime(),
                    default => null,
                };
                $metodo->invoke($oTask, $valor);

                // Almacenar el valor asignado
                $properties[substr($nombreMetodo, 3)] = $valor;
            }
        }

        // Llamamos a todos los getters y comprobamos si devuelven el valor que habíamos asignado
        foreach ($reflector->getMethods() as $metodo) {
            $nombreMetodo = $metodo->getName();
            if ($nombreMetodo === 'getId') {
                continue;
            }
            if (strpos($nombreMetodo, 'get') === 0) {
                // Llamar al método get
                $valor = $metodo->invoke($oTask);

                // Comprobar si el valor devuelto es igual al valor asignado
                $key = substr($nombreMetodo, 3);
                $this->assertArrayHasKey($key, $properties);
                $this->assertSame($properties[$key], $valor);
            }
        }
    }
    */

    public function testEloquentTaskRepositoryGetAllTasks(): void
    {
        $taskRepository = app(\App\Core\Infrastructure\TaskRepositoryInterface::class);
        $tasks = $taskRepository->getAllTasks(null);

        $this->assertNotEmpty($tasks);
        $this->assertIsIterable($tasks);
        $this->assertContainsOnlyInstancesOf(Task::class, $tasks);
        $this->assertCount(13, $tasks);
    }

    public function testEloquentTaskRepositoryGetTaskById(): void
    {
        $taskRepository = app(\App\Core\Infrastructure\TaskRepositoryInterface::class);

        $task = $taskRepository->getTaskById(0);
        $this->assertNull($task);

        $task = $taskRepository->getTaskById(1);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertSame(1, $task->getId());
    }

    public function testEloquentTaskRepositoryCreate(): void
    {
        $user_id = 1;
        $title = 'Título';
        $description = 'Descripción';
        $is_completed = true;
        $completed_at = date('Y-m-d H:i:s');

        $oTask = new Task();
        $oTask->setUser_id($user_id);
        $oTask->setTitle($title);
        $oTask->setDescription($description);
        $oTask->setIs_completed($is_completed);
        $oTask->setCompleted_at($completed_at);

        $taskRepository = app(\App\Core\Infrastructure\TaskRepositoryInterface::class);
        $taskRepository->saveTask($oTask);

        $this->assertDatabaseHas('tasks', [
            'id' => 14,
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'is_completed' => $is_completed,
            // 'completed_at' => $completed_at,
        ]);
    }

    public function testEloquentTaskRepositoryUpdate(): void
    {
        $id = 1;
        $user_id = 1;
        $title = 'Título Modificado';
        $description = 'Descripción Modificada';
        $is_completed = false;
        $completed_at = null;

        $oTask = new Task($id, $user_id, $title, $description, $is_completed, $completed_at, []);

        $taskRepository = app(\App\Core\Infrastructure\TaskRepositoryInterface::class);
        $taskRepository->saveTask($oTask);

        $this->assertDatabaseHas('tasks', [
            'id' => $id,
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'is_completed' => $is_completed,
            // 'completed_at' => $completed_at,
        ]);
    }

    public function testEloquentTaskRepositoryDelete(): void
    {
        $taskRepository = app(\App\Core\Infrastructure\TaskRepositoryInterface::class);
        $taskRepository->deleteTask(1);

        $this->assertDatabaseMissing('tasks', [
            'id' => 1,
        ]);
    }
}
