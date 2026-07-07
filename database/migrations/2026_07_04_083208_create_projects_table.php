<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('description')->nullable();
            
            $table->enum('status', ['planning', 'active', 'paused', 'completed', 'cancelled'])
                  ->default('planning');
                  
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])
                  ->default('medium');

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            
            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('restrict'); 

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};