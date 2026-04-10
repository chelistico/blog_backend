<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SeoController extends Controller
{
    public function article(string $id): JsonResponse
    {
        $article = Article::with(['author', 'tags'])
            ->where('slug', $id)
            ->orWhere('id', $id)
            ->published()
            ->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Artículo no encontrado'],
            ], 404);
        }

        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $article->summary,
            'image' => $article->main_image,
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $article->author->name,
                'url' => url("/author/{$article->author->slug}"),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => SiteSetting::getValue('site_name', 'TechDaily'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url(SiteSetting::getValue('logo')),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url("/article/{$article->slug}"),
            ],
        ];

        return response()->json($structuredData);
    }

    public function website(): JsonResponse
    {
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => SiteSetting::getValue('site_name', 'TechDaily'),
            'url' => config('app.url'),
            'description' => SiteSetting::getValue('seo_description'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search?q={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];

        return response()->json($structuredData);
    }
}
