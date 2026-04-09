<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'title'           => 'required|string|max:255',
            'excerpt'         => 'nullable|string',
            'content'         => 'required|string',
            'publish_date'    => 'required|date', 
            'author'          => 'required|string|max:255', 
            'image'           => 'nullable|image|max:2048',
            'faqs'            => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:255', 
            'faqs.*.answer'   => 'nullable|string',
        ]);


        $imagePath = null;

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('article', 'public');
        } else {
            $imagePath = 'images/default-article.png';
        }

        $article = Article::create([
            'title'        => $validated['title'], 
            'excerpt'      => $validated['excerpt'] ?? '', 
            'content'      => $validated['content'], 
            'publish_date' => $validated['publish_date'], 
            'author'       => $validated['author'], 
            'image'        => $imagePath,

        ]);

        if(!empty($validated['faqs'])) {
            foreach($validated['faqs'] as $index => $value) {
                if(!empty($value['question']) && !empty($value['answer'])) {
                    $article->faqs()->create([
                        'question'   => $value['question'], 
                        'answer'     => $value['answer'], 
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde erfolgreich erstellt');

    }

    public function edit($id) {
        $article = Article::with('faqs') -> findOrFail($id);

        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, $id) {

        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'           => 'required|string|max:255', 
            'excerpt'         => 'nullable|string', 
            'content'         => 'required|string', 
            'publish_date'    => 'required|date',
            'author'          => 'required|string|max:255',
            'image'           => 'nullable|image|max:2048',
            'faqs'            => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:255', 
            'faqs.*.answer'   => 'nullable|string',
        ]);

        $imagePath = $article->image ?? 'images/default-article.png';

        if($request->hasFile('image')) {
            if($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $imagePath = $request->file('image')->store('article', 'public');
        }
        

        $article->update([
            'title'        => $validated['title'], 
            'excerpt'      => $validated['excerpt'] ?? '', 
            'content'      => $validated['content'], 
            'publish_date' => $validated['publish_date'], 
            'author'       => $validated['author'], 
            'image'        => $imagePath,
        ]);

        $article->faqs()->delete();

        if(!empty($validated['faqs'])) {
            foreach ($validated['faqs'] as $index => $value) {
                if(!empty($value['question']) && !empty($value['answer'])) {
                    $article->faqs()->create([
                        'question'   => $value['question'], 
                        'answer'     => $value['answer'],
                        'sort_order' => $index,
                    ]);
                }
            }   
        }

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde erfolgreich aktualisiert');

    }

    public function destroy(Request $request, $id) {
        $article = Article::findOrFail($id);
        $article->delete();

        if($article->image && str_starts_with($article->image, 'article/')) {
            Storage::disk('public')->delete($article->image);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Der Artikel wurde gelöscht');
    }
}
