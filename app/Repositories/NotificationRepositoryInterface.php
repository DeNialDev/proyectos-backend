<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface NotificationRepositoryInterface
{
    public function getUnreadForUser(int $userId): Collection;
    public function markAsRead(int $userId, string $notificationId): bool;
    public function markAllAsRead(int $userId): void;
}