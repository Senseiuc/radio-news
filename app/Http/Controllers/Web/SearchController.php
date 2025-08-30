<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $articles = collect();
        if ($q !== '') {
            $articles = Article::query()
                ->published()
                ->search($q)
                ->with(['author','categories'])
                ->select(['id','title','slug','excerpt','image_url','published_at','author_id'])
                ->paginate(12)
                ->withQueryString();
        } else {
            // Empty paginator for consistent view logic
            $articles = Article::query()->whereRaw('1=0')->paginate(12);
        }

        return view('search.index', [
            'q' => $q,
            'articles' => $articles,
        ]);
    }
}
