<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Rutas Públicas (Sin Autenticación)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Token OAuth2 Passport Válido)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    
    // Ruta para cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    // Obtener los datos del usuario actualmente autenticado
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });
    Route::post('projects/{id}/assign', [ProjectController::class, 'assignUsers']);
    // Módulo de Proyectos (CRUD Completo protegido)
    Route::apiResource('projects', ProjectController::class);

    // Módulo de Tareas (CRUD Completo protegido)
    Route::get('projects/{projectId}/tasks', [TaskController::class, 'indexByProject']);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('users', UserController::class);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'read']);
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll']);
    Route::get('/dashboard/summary', [App\Http\Controllers\ProjectController::class, 'getDashboardSummary']);
    
});