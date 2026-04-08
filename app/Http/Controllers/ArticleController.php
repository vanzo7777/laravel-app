<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function publicIndex() {
        $articles = Article::orderBy('publish_date', 'desc')->get();

        return view('articles.index', compact('articles'));
    }

    public function show($id) {
        $article = Article::with('faqs')->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    public function adminIndex() {
        $articles = Article::orderBy('id', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create() {
        return view('admin.articles.create');
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'publish_date' => 'required|date', 
            'author'       => 'required|string|max:255', 
        ]);

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde erfolgreich erstellt');

    }

    public function edit($id) {
        $article = Article::findOrFail($id);

        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, $id) {

        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255', 
            'excerpt'      => 'nullable|string', 
            'content'      => 'required|string', 
            'publish_date' => 'required|date',
            'author'       => 'required|string|max:255',
        ]);

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde erfolgreich aktualisiert');

    }

    public function destroy() {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde gelöscht');
    }
}
