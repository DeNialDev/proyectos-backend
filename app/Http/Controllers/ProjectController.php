<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(): JsonResponse
    {
        $projects = $this->projectRepository->all();
        return response()->json(['data' => $projects], Response::HTTP_OK);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectRepository->create($request->validated());
        
        return response()->json([
            'message' => 'Proyecto creado exitosamente.',
            'data' => $project
        ], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $project = $this->projectRepository->find($id);
        return response()->json(['data' => $project], Response::HTTP_OK);
    }

    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        $this->projectRepository->update($id, $request->validated());
        
        return response()->json([
            'message' => 'Proyecto actualizado exitosamente.'
        ], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->projectRepository->delete($id);
        
        return response()->json([
            'message' => 'Proyecto eliminado exitosamente (Soft Delete).'
        ], Response::HTTP_OK);
    }
}