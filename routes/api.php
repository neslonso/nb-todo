<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas para autenticación
// Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Rutas protegidas por Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas para tareas
    Route::get('tasks', [TaskController::class, 'getAll']);
    Route::get('tasks/{taskId}', [TaskController::class, 'getById']);
    Route::post('tasks/{taskId}', [TaskController::class, 'save']);
    Route::delete('tasks/{taskId}', [TaskController::class, 'deleteById']);
    Route::put('tasks/{taskId}/complete', [TaskController::class, 'toggleCompleted']);

    Route::get('categories', [CategoryController::class, 'getAll']);
});
