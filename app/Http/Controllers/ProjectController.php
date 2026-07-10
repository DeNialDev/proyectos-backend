<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\AssignProjectUsersRequest; 
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


    public function assignUsers(AssignProjectUsersRequest $request, int $id): JsonResponse
    {
        // Validamos primero que el proyecto exista y pertenezca al usuario autenticado
        $project = $this->projectRepository->find($id);
        
        if (!$project) {
            return response()->json(['message' => 'Proyecto no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        if ($project->owner_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado para asignar usuarios a este proyecto.'], Response::HTTP_FORBIDDEN);
        }

        // Al usar $request->validated(), Laravel ya se encargó de verificar que los IDs existan
        $this->projectRepository->assignUsers($id, $request->validated()['user_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Usuarios asignados al proyecto exitosamente.'
        ], Response::HTTP_OK);
    }

  public function getDashboardSummary(): JsonResponse
    {
        $summary = $this->projectRepository->getDashboardSummary(auth()->id());

        return response()->json($summary, Response::HTTP_OK);
    }
}