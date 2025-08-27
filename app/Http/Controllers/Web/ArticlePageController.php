<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlePageController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::query()
            ->published()
            ->latest('published_at')
            ->select(['id','title','slug','excerpt','image_url','published_at'])
            ->paginate(10);

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->published()
            ->with(['author','categories'])
            ->firstOrFail();

        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
