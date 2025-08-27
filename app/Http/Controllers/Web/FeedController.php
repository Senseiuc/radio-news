<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    public function index(): Response
    {
        $base = rtrim(config('app.url'), '/');
        $siteTitle = config('app.name', 'Homeland Radio');

        $items = Article::query()
            ->published()
            ->latest('published_at')
            ->select(['title','slug','excerpt','image_url','published_at'])
            ->take(50)
            ->get();

        $rss = view('seo.feed', [
            'base' => $base,
            'siteTitle' => $siteTitle,
            'items' => $items,
        ])->render();

        return response($rss, 200, [
            'Content-Type' => 'application/rss+xml; charset=UTF-8',
        ]);
    }
}
