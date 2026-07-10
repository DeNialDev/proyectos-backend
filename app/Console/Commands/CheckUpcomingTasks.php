<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Project;
use App\Notifications\TaskDueSoonNotification;
use App\Notifications\ProjectDueSoonNotification;
use Carbon\Carbon;

class CheckUpcomingTasks extends Command
{
    // Le cambiamos un poco la descripción para que sea más clara
    protected $signature = 'alerts:check-due';
    protected $description = 'Escanea tareas y proyectos próximos a vencer y notifica a los usuarios';

    public function handle()
    {
        $mañana = Carbon::tomorrow()->toDateString();
        $notificacionesEnviadas = 0;

        // ==========================================
        // 1. ESCANEAR TAREAS
        // ==========================================
        $tasks = Task::with('user')
            ->where('due_date', $mañana)
            ->where('status', '!=', 'done')
            ->get();

        foreach ($tasks as $task) {
            if ($task->user) {
                $task->user->notify(new TaskDueSoonNotification($task));
                $notificacionesEnviadas++;
            }
        }

        // ==========================================
        // 2. ESCANEAR PROYECTOS
        // ==========================================
        // Traemos los proyectos que vencen mañana con sus usuarios asignados
        $projects = Project::with('users')
            ->where('due_date', $mañana)
            ->where('status', '!=', 'done')
            ->get();

        foreach ($projects as $project) {
            // Un proyecto puede tener varios usuarios, así que los recorremos
            foreach ($project->users as $user) {
                $user->notify(new ProjectDueSoonNotification($project));
                $notificacionesEnviadas++;
            }
        }

        $this->info("Proceso terminado. Se enviaron {$notificacionesEnviadas} notificaciones en total.");
    }
}