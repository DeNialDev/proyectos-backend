<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectDueSoonNotification extends Notification
{
    use Queueable;

    protected Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // Esta estructura es idéntica a la de tareas, así el Frontend la lee sin problemas
        return [
            'project_id' => $this->project->id,
            'title'      => '📁 Proyecto próximo a vencer',
            'message'    => "El proyecto '{$this->project->name}' se entrega el {$this->project->due_date}.",
        ];
    }
}