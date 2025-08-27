<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = config('app.url');
        $articles = Article::query()
            ->published()
            ->latest('updated_at')
            ->select(['slug','updated_at'])
            ->get();

        $xml = view('seo.sitemap', [
            'base' => rtrim($base, '/'),
            'articles' => $articles,
        ])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
