<?php

namespace App\Http\Controllers;

use App\Models\UC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UCController extends Controller
{
    public function index()
    {
        $ucs = UC::where('user_id', Auth::id())->get();
        return view('uc', compact('ucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        UC::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('ucs.index')->with('success', 'UC created!');
    }

    public function show($id)
    {
        $uc = UC::findOrFail($id);
        return view('uc_show', compact('uc'));
    }
    public function user()
    {
        return $this->belongsTo(UC::class);
    }
}
