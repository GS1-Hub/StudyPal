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
        'completed',
        'notes'
    ];

    public function uc()
    {
        return $this->belongsTo(UC::class);
    }
}
