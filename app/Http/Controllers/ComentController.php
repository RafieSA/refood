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
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'coments' => 'required|string',
            'restaurant_id' => 'required|uuid|exists:restaurants,id',
        ]);

        \App\Models\Coment::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'coments' => $request->coments,
            'restaurant_id' => $request->restaurant_id,
        ]);
        
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}