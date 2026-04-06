<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $tasks = Task::whereHas('uc', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereNotNull('due_date')->get();

        $events = $tasks->map(function ($t) {
            return [
                'title' => $t->name,
                'start' => $t->due_date,
                'color' => '#764ba2',
                'id' => $t->id
            ];
        });

        return view('calendar', compact('events'));
    }
}
