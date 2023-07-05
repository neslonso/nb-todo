<?php

namespace App\Http\Controllers;

use App\Core\Application\Interfaces\ApiResponseInterface;
use App\Core\Domain\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getAll(ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $apiResponse::create(false, '', (object) ['tasks' => $this->taskService->getAllTasks(Auth::user()->id)])
        );
    }

    public function getById(int $id, ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        $task = $this->taskService->getTaskById($id);

        if (!$task) {
            return response()->json(
                $apiResponse::create(true, 'Task not found', (object) []), 404);
        }

        return response()->json(
            $apiResponse::create(false, '', (object) $task->toArray())
        );
    }

    public function save(Request $request, ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'id' => 'integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'is_completed' => 'required|boolean',
            'categories' => 'array',
        ]);

        $user_id = Auth::user()->id;

        $task = $this->taskService->saveTask(
            $request->input('id', null),
            $user_id,
            $request->input('title'),
            $request->input('description'),
            $request->input('is_completed', false),
            $request->input('categories', [])
        );

        if (!$task) {
            return response()->json(
                $apiResponse::create(true, 'Task not saved', (object) []), 404);
        }

        return response()->json(
            $apiResponse::create(false, '', (object) ['task' => $task->toArray()]), 201);
    }

    public function deleteById(int $id, ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        $result = $this->taskService->deleteTask($id);

        if (!$result) {
            return response()->json(
                $apiResponse::create(true, 'Task not found', (object) []), 404);
        }

        return response()->json(
            $apiResponse::create(false, '', (object) ['result' => $result]), 201);
    }

    public function toggleCompleted(Request $request, int $id, ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        $result = $this->taskService->toggleCompleted($id);

        if (!$result) {
            return response()->json(
                $apiResponse::create(true, 'Task not found', (object) []), 404);
        }

        return response()->json(
            $apiResponse::create(false, '', (object) ['result' => $result]), 201);
    }
}
