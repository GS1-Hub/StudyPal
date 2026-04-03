<?php

namespace App\Http\Controllers;

use App\Models\UC;
use Illuminate\Http\Request;

class UCController extends Controller
{
    public function index()
    {
        $ucs = UC::all();
        return view('uc', compact('ucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        UC::create([
            'name' => $request->name,
        ]);

        return redirect()->route('ucs.index')->with('success', 'UC criada com sucesso!');
    }
    
    public function show($id)
    {
        $uc = UC::findOrFail($id);
        return view('uc_show', compact('uc'));
    }
}
