<?php

namespace App\Repositories\Eloquent;

use App\Repositories\NotificationRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function getUnreadForUser(int $userId): Collection
    {
        $user = User::findOrFail($userId);
        // Trae las notificaciones que tienen read_at en NULL
        return $user->unreadNotifications;
    }

    public function markAsRead(int $userId, string $notificationId): bool
    {
        $user = User::findOrFail($userId);
        $notification = $user->unreadNotifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        
        return false;
    }

    public function markAllAsRead(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->unreadNotifications->markAsRead();
    }
}