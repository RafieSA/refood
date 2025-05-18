<?php

namespace App\Http\Controllers;

use App\Models\Coment;
use Illuminate\Http\Request;

class ComentController extends Controller
{
    public function index()
    {
        $coments = Coment::orderBy('id', 'desc')->get();
        return view('coments.index', compact('coments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'coments' => 'required',
        ]);

        \App\Models\Coment::create($request->all());
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}