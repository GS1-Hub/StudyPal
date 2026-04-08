<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'uc_id',
        'due_date',
        'notes',
        'started_at',
        'completed_at',
    ];
    protected $casts = [
        'due_date'     => 'datetime',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];
    public function getStateAttribute(): string
    {
        if ($this->completed_at) return 'done';
        if ($this->started_at)   return 'doing';
        return 'todo';
    }

    public function uc()
    {
        return $this->belongsTo(UC::class);
    }
}
