<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskDueSoonNotification extends Notification
{
    use Queueable;

    protected Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // Le decimos a Laravel que use la tabla de la base de datos
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Estructura del JSON que se guardará en la columna 'data'
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'project_id' => $this->task->project_id,
            'title' => 'Tarea próxima a vencer',
            'message' => "La tarea '{$this->task->title}' vence el {$this->task->due_date}.",
        ];
    }
}