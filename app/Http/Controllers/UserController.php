<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse
    {
        $users = $this->userRepository->all();
        return response()->json(['data' => $users], Response::HTTP_OK);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->validated());
        
        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $updated = $this->userRepository->update($id, $request->validated());

        if (!$updated) {
            return response()->json(['message' => 'Usuario no encontrado o no actualizado.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Usuario actualizado exitosamente.'], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->userRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Usuario eliminado exitosamente.'], Response::HTTP_OK);
    }
}