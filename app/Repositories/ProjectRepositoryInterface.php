<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Project;
    public function create(array $data): Project;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function assignUsers(int $projectId, array $userIds): void;  
    public function getDashboardSummary(int $userId): array;
}
