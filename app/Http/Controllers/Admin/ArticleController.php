<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $articles = Article::when($search, function ($query, $search) {
            $query->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
        })->orderBy('uploaded_at', 'desc')->get();

        return view('admin.articles.index', compact('articles', 'search'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $article = new Article();
        $article->id = (string) Str::uuid();
        $article->title = $validated['title'];
        $article->description = $validated['description'];
        $article->uploaded_at = now();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $article->image_url = '/storage/' . $path;
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $article->title = $validated['title'];
        $article->description = $validated['description'];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image_url && Storage::exists('public/' . str_replace('/storage/', '', $article->image_url))) {
                Storage::delete('public/' . str_replace('/storage/', '', $article->image_url));
            }
            $path = $request->file('image')->store('articles', 'public');
            $article->image_url = '/storage/' . $path;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diupdate.');
    }

    public function destroy(Article $article)
    {
        if ($article->image_url && Storage::exists('public/' . str_replace('/storage/', '', $article->image_url))) {
            Storage::delete('public/' . str_replace('/storage/', '', $article->image_url));
        }
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.showArticles', compact('article'));
    }
}