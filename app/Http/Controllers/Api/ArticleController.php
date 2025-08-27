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
     * Public: List featured articles for the hero section.
     * Returns two buckets: featured (slider) and top (side list).
     */
    public function featured(Request $request)
    {
        $sliderCount = (int) $request->query('slider', 5);
        $sideCount   = (int) $request->query('side', 6);
        $sliderCount = max(1, min(10, $sliderCount));
        $sideCount   = max(0, min(12, $sideCount));

        $query = Article::query()
            ->published()
            ->where('is_featured', true)
            ->with(['author:id,name', 'categories:id,name'])
            ->latest('published_at')
            ->select(['id','title','slug','image_url','published_at','author_id']);

        $all = $query->take($sliderCount + $sideCount)->get();

        $mapItem = function (Article $a) {
            $img = $a->image_url;
            if ($img && !preg_match('/^https?:\/\//i', $img)) {
                $img = asset(ltrim($img, '/'));
            }
            return [
                'id' => $a->id,
                'title' => $a->title,
                'slug' => $a->slug,
                'image_url' => $img,
                'author' => optional($a->author)->name,
                'category' => optional($a->categories->first())->name,
                'published_at' => optional($a->published_at)->toDateTimeString(),
            ];
        };

        $featured = $all->take($sliderCount)->map($mapItem)->values();
        $top      = $all->slice($sliderCount)->take($sideCount)->map($mapItem)->values();

        return response()->json([
            'featured' => $featured,
            'top' => $top,
        ]);
    }

    /**
     * Public: List trending published articles (titles for marquee)
     */
    public function trending(Request $request)
    {
        $limit = (int) $request->query('limit', 10);
        $limit = max(1, min(50, $limit));

        $items = Article::query()
            ->published()
            ->where('is_trending', true)
            ->latest('published_at')
            ->select(['id','title','slug','published_at'])
            ->take($limit)
            ->get();

        return response()->json($items);
    }

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
