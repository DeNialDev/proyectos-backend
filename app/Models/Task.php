<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id',
        'assigned_to'
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}