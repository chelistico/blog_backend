<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Article;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        $latestArticles = Article::with(['author', 'tags'])
            ->published()
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $popularArticles = Article::with(['author', 'tags'])
            ->published()
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        $advertisements = Advertisement::active()
            ->whereIn('position', ['top', 'sidebar'])
            ->orderBy('order')
            ->get();

        $settings = SiteSetting::whereIn('key', [
            'site_name',
            'site_title',
            'seo_description',
            'logo',
        ])->get()->mapWithKeys(fn($s) => [$s->key => $s->value]);

        return response()->json([
            'success' => true,
            'data' => [
                'latest_articles' => $latestArticles,
                'popular_articles' => $popularArticles,
                'advertisements' => $advertisements,
                'settings' => $settings,
            ],
        ]);
    }
}
