<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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

    // Módulo de Proyectos (CRUD Completo protegido)
    Route::apiResource('projects', ProjectController::class);

    // Módulo de Tareas (CRUD Completo protegido)
    Route::get('projects/{projectId}/tasks', [TaskController::class, 'indexByProject']);
    Route::apiResource('tasks', TaskController::class);
});