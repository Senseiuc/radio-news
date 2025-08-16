<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Public: List articles with optional category & search filters
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'category' => 'nullable|string|exists:categories,slug',
            'search' => 'nullable|string|max:255'
        ]);

        $articles = Article::query()
            ->with(['author', 'categories'])
            ->latest('published_at');

        if ($request->category) {
            $articles->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->search) {
            $articles->where('title', 'like', "%{$request->search}%");
        }

        return ArticleResource::collection($articles->paginate(10));
    }

    /**
     * Public: Search articles by keyword
     */
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|max:255']);

        return ArticleResource::collection(
            Article::search($request->query('q'))
                ->with(['author', 'categories'])
                ->paginate()
        );
    }

    /**
     * Public: Show single published article
     */
    public function show(Article $article)
    {
        if (!$article->published_at || $article->published_at->isFuture()) {
            abort(404, 'Article not found');
        }

        return new ArticleResource($article->load(['author', 'categories']));
    }

    /**
     * Admin: Manage articles (requires Filament auth)
     */
    public function manage()
    {
        // Optional: Permission check (Filament Shield)
        if (! auth()->user()->can('manage_articles')) {
            abort(403, 'Unauthorized');
        }

        return ArticleResource::collection(
            Article::with(['author', 'categories'])
                ->latest('published_at')
                ->paginate(20)
        );
    }
}
