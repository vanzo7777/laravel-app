<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function publicIndex(Request $request) {
        $query = Article::query()->orderBy('sort_order');

        if($request->filled('search')) {
            $search = trim($request->search);
            $query->where(fn($q) =>
                $q  -> where('title', 'like', '%' . $search . '%')
                    -> orwhere('excerpt', 'like', '%' . $search . '%')
                    -> orWhere('content', 'like', '%' . $search . '%')
                    -> orWhere('author', 'like', '%' . $search . '%')
            ) 
            -> orderBy('sort_order');
        }

        $articles = $query->paginate(6)->withQueryString();

        return view('articles.index', compact('articles'));
    }

    public function show(string $slug) {
        $article = Article::with('faqs')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('articles.show', compact('article'));
    }

    public function ajaxSearch(Request $request) {
        $search = trim($request->get('search', ''));

        if($search === '' ) {
            return response()->json([]);
        }

        $articles = Article::query()
            -> select('id', 'title', 'slug', 'excerpt', 'image', 'publish_date', 'sort_order', 'author')
            -> where(fn($q) => 
            $q  -> where('title', 'like', '%' . $search . '%')
                -> orWhere('excerpt', 'like', '%' . $search . '%')
                -> orWhere('content', 'like', '%' . $search . '%')
                -> orWhere('author', 'like', '%' . $search . '%')
            )
            ->orderBy('sort_order')
            -> limit(10)
            ->get()
            ->map(fn($article) => [
                'title' => $article->title,
                'slug' => $article->slug,
                'excerpt' => $article->excerpt,
                'author' => $article->author,
                'publish_date' => $article->publish_date,
                'url' => route('articles.show', $article->slug),
                'image_url' => $article->image_url,
            ]);
        return response()->json($articles);
    }

    public function ajaxAdminSearch(Request $request) {
        $search = trim($request->get('search', ''));

        if($search === '') {
            return response()->json([]);
        }

        $like = "%{$search}%";

        $articles = Article::query()
            -> select('id', 'title', 'slug', 'excerpt', 'image', 'publish_date', 'sort_order', 'author')
            -> where(fn($q) => 
                $q  -> where('title', 'like', $like )
                    -> orWhere('excerpt', 'like', $like)
                    -> orWhere('content', 'like', $like)
                    -> orWhere('author', 'like', $like)
            )  
            ->orderBy('sort_order')
            ->limit(10)
            ->get()
            ->map(fn($article) => [
                'title' => $article->title,
                'slug' => $article->slug,
                'author' => $article->author,
                'publish_date' => $article->publish_date,
                'edit_url' => route('admin.articles.edit', $article->id),
            ]);
        return response()->json($articles);
    }

    public function adminIndex(Request $request) {

        $query = Article::query();

        if($request->filled('search')) {
            $search = trim($request->search);
            $query->where(fn($q) => 
                $q  -> where('title', 'like', '%' . $search . '%')
                    -> orWhere('content', 'like', '%' . $search . '%')
                    -> orWhere('content', 'like', '%' . $search . '%')
                    -> orWhere('author', 'like', '%' . $search . '%')
            ) 
            -> orderBy('sort_order');
        }

        $articles = $query->paginate(10)->withQueryString();
        return view('admin.articles.index', compact('articles'));
    }

    public function create() {
        return view('admin.articles.create');
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'sort_order'      => 'integer',
            'slug'            => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->withoutTrashed()],
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

        $slug = !empty($validated['slug']) ? $validated['slug'] : Article::generateUniqueSlug($validated['title']);

        $article = Article::create([
            'title'        => $validated['title'], 
            'sort_order'   => $validated['sort_order'],
            'slug'         => $slug, 
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
            'sort_order'      => 'integer',
            'slug'            => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article->id)->withoutTrashed()],
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


        $slug = !empty($validated['slug']) ? $validated['slug'] : Article::generateUniqueSlug($validated['title'], $article->id);
        

        $article->update([
            'title'        => $validated['title'], 
            'sort_order'   => $validated['sort_order'],
            'slug'         => $slug,
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
