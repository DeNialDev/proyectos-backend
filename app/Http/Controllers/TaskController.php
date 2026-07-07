<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function indexByProject(int $projectId): JsonResponse
    {
        $tasks = $this->taskRepository->getByProject($projectId);
        return response()->json(['data' => $tasks], Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskRepository->create($request->validated());
        return response()->json([
            'message' => 'Tarea creada exitosamente.',
            'data' => $task
        ], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        return response()->json(['data' => $task], Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $this->taskRepository->update($id, $request->validated());
        return response()->json(['message' => 'Tarea actualizada exitosamente.'], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->taskRepository->delete($id);
        return response()->json(['message' => 'Tarea eliminada exitosamente (Soft Delete).'], Response::HTTP_OK);
    }
}