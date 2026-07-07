<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getByProject(int $projectId): Collection
    {
        return Task::where('project_id', $projectId)->with('assignee')->get();
    }

    public function find(int $id): ?Task
    {
        return Task::with(['project', 'assignee'])->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $task = Task::findOrFail($id);
        return $task->update($data);
    }

    public function delete(int $id): bool
    {
        $task = Task::findOrFail($id);
        return $task->delete();
    }
}