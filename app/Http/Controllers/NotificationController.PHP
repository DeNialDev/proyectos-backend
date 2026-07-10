<?php

namespace App\Http\Controllers;

use App\Repositories\NotificationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    protected NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Listar notificaciones sin leer del usuario autenticado.
     */
    public function index(): JsonResponse
    {
        $notifications = $this->notificationRepository->getUnreadForUser(auth()->id());
        
        return response()->json([
            'data' => $notifications
        ], Response::HTTP_OK);
    }

    /**
     * Marcar una notificación específica como leída.
     */
    public function read(string $id): JsonResponse
    {
        $updated = $this->notificationRepository->markAsRead(auth()->id(), $id);

        if (!$updated) {
            return response()->json(['message' => 'Notificación no encontrada.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Notificación marcada como leída.'], Response::HTTP_OK);
    }

    /**
     * Marcar todas las notificaciones del usuario como leídas de golpe.
     */
    public function readAll(): JsonResponse
    {
        $this->notificationRepository->markAllAsRead(auth()->id());
        
        return response()->json(['message' => 'Todas las notificaciones marcadas como leídas.'], Response::HTTP_OK);
    }
}