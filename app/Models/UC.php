<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UC extends Model
{
    protected $table = 'ucs';

    protected $fillable = [
        'name',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}