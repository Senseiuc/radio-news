<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlePageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::query()
            ->published()
            ->latest('published_at')
            ->with(['author','categories'])
            ->select(['id','title','slug','excerpt','image_url','published_at','author_id']);

        $categorySlug = $request->query('category');
        $currentCategory = null;
        if ($categorySlug) {
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
            $currentCategory = Category::where('slug', $categorySlug)->first();
        }

        $articles = $query->paginate(12)->withQueryString();

        // Recent posts for sidebar (titles only)
        $recentPosts = Article::query()
            ->published()
            ->latest('published_at')
            ->select(['id','title','slug','published_at'])
            ->take(8)
            ->get();

        return view('articles.index', [
            'articles' => $articles,
            'currentCategory' => $currentCategory,
            'recentPosts' => $recentPosts,
        ]);
    }

    public function show(string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->published()
            ->with(['author','categories', 'comments.user'])
            ->firstOrFail();

        // Approved comments
        $approvedComments = $article->comments()
            ->where('is_approved', true)
            ->latest()
            ->with('user')
            ->get();

        // Related articles: share at least one category, exclude current
        $categoryIds = $article->categories->pluck('id');
        $related = Article::query()
            ->published()
            ->where('id', '!=', $article->id)
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->with(['author'])
            ->latest('published_at')
            ->take(6)
            ->get();

        // Recent posts for sidebar (titles only)
        $recentPosts = Article::query()
            ->published()
            ->latest('published_at')
            ->select(['id','title','slug','published_at'])
            ->take(8)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'approvedComments' => $approvedComments,
            'related' => $related,
            'recentPosts' => $recentPosts,
        ]);
    }

    public function storeComment(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'body' => ['required','string','min:3'],
        ]);

        if (!auth()->check()) {
            return back()->withErrors(['auth' => 'Please log in to add a comment.'])->withInput();
        }

        $article->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
            'is_approved' => false,
        ]);

        return back()->with('status', 'Comment submitted and awaiting approval.');
    }
}
