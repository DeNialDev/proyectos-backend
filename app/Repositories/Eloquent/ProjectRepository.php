<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\Task;
class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::with('owner')->latest()->get();
    }

    public function find(int $id): ?Project
    {
        return Project::with('users')->find($id);
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

    public function assignUsers(int $projectId, array $userIds): void
    {
        $project = Project::findOrFail($projectId);
        $project->users()->sync($userIds);
    }

   public function getDashboardSummary(int $userId): array
{
    $hoy = \Carbon\Carbon::today()->toDateString();
    $user = \App\Models\User::find($userId);

    if (!$user) {
        return [];
    }

    // --- BLOQUE 1: PROYECTOS ---
    $expiredProjects = $user->projects()
        ->where('due_date', '<', $hoy)
        ->where('status', '!=', 'done')
        ->orderBy('due_date', 'asc')
        ->get();

    $upcomingProjects = $user->projects()
        ->where('due_date', '>=', $hoy)
        ->where('status', '!=', 'done')
        ->orderBy('due_date', 'asc')
        ->take(5)
        ->get();

    // --- BLOQUE 2: TAREAS ---
    // Traemos la relación 'project' para que el Front sepa a qué proyecto pertenece cada tarea
    $expiredTasks = \App\Models\Task::with('project')
        ->where('assigned_to', $userId)
        ->where('due_date', '<', $hoy)
        ->where('status', '!=', 'done')
        ->orderBy('due_date', 'asc')
        ->get();

    $upcomingTasks = \App\Models\Task::with('project')
        ->where('assigned_to', $userId)
        ->where('due_date', '>=', $hoy)
        ->where('status', '!=', 'done')
        ->orderBy('due_date', 'asc')
        ->take(5)
        ->get();

    // Retornamos todo agrupado
    return [
        'projects' => [
            'expired_count' => $expiredProjects->count(),
            'expired' => $expiredProjects->take(5), // Mandamos solo 5 a la vista
            'upcoming' => $upcomingProjects,
        ],
        'tasks' => [
            'expired_count' => $expiredTasks->count(),
            'expired' => $expiredTasks->take(5),
            'upcoming' => $upcomingTasks,
        ]
    ];
}
}