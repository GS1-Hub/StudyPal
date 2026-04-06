<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UC;
use Illuminate\Http\Request;

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
}
