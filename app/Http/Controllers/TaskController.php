<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'uc_id' => 'required|exists:ucs,id',
        ]);

        Task::create([
            'name' => $request->name,
            'uc_id' => $request->uc_id,
        ]);

        return redirect()->route('ucs.show', $request->uc_id)->with('success', 'Task criada!');
    }

    public function show($id)
    {
        $uc = UC::findOrFail($id);
        $tasks = $uc->tasks;
        return view('uc_show', compact('uc', 'tasks'));
    }

    public function updateDate(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function unscheduled()
    {
        $tasks = Task::whereHas('uc', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereNull('due_date')->with('uc')->get();

        return response()->json($tasks);
    }

    public function updateNotes(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->notes = $request->notes;
        $task->save();

        return response()->json(['success' => true]);
    }
    public function updateState(Request $request, Task $task)
    {
        if ($request->state === 'doing') {
            $task->update(['started_at' => now(), 'completed_at' => null]);
        } elseif ($request->state === 'done') {
            $task->update(['completed_at' => now()]);
        }

        return response()->json(['ok' => true]);
    }
}
