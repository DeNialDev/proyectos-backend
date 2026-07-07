<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description')->nullable();
            
            // Estados y Prioridades de la tarea
            $table->enum('status', ['todo', 'in_progress', 'in_review', 'done'])
                  ->default('todo');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])
                  ->default('medium');

            $table->date('due_date')->nullable();

            // Relación con el Proyecto (Si se borra el proyecto, se borran sus tareas en cascada)
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');

            // Relación con el Usuario Asignado (nullable por si se crea la tarea sin asignar aún)
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes(); // Borrado lógico para auditoría
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};