<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::with('owner')->latest()->get();
    }

    public function find(int $id): ?Project
    {
        return Project::with('owner')->findOrFail($id);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $project = Project::findOrFail($id);
        return $project->update($data);
    }

    public function delete(int $id): bool
    {
        $project = Project::findOrFail($id);
        return $project->delete();
    }
}