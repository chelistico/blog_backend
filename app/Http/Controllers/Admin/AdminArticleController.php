<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['author', 'tags']);

        if ($request->has('status')) {
            match($request->status) {
                'published' => $query->where('is_published', true),
                'draft' => $query->where('is_published', false),
                'scheduled' => $query->where('published_at', '>', now()),
                default => null,
            };
        }

        $articles = $query->orderByDesc('created_at')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'data' => ArticleResource::collection($articles),
                'pagination' => [
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                    'per_page' => $articles->perPage(),
                    'total' => $articles->total(),
                ],
            ],
        ]);
    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        if (!isset($data['read_time'])) {
            $data['read_time'] = $this->calculateReadTime($data['content']);
        }

        $article = Article::create($data);

        if (!empty($tagIds)) {
            $article->tags()->attach($tagIds);
        }

        $article->load(['author', 'tags']);

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
            'message' => 'Artículo creado exitosamente',
        ], 201);
    }

    public function show(int $article): JsonResponse
    {
        $article = Article::with(['author', 'tags'])->findOrFail($article);

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
        ]);
    }

    public function update(UpdateArticleRequest $request, int $article): JsonResponse
    {
        $article = Article::findOrFail($article);
        $data = $request->validated();
        $tagIds = $data['tags'] ?? null;
        unset($data['tags']);

        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        if (isset($data['content']) && !isset($data['read_time'])) {
            $data['read_time'] = $this->calculateReadTime($data['content']);
        }

        $article->update($data);

        if ($tagIds !== null) {
            $article->tags()->sync($tagIds);
        }

        $article->load(['author', 'tags']);

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
            'message' => 'Artículo actualizado exitosamente',
        ]);
    }

    public function destroy(int $article): JsonResponse
    {
        $article = Article::findOrFail($article);
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artículo eliminado exitosamente',
        ]);
    }

    public function publish(int $article): JsonResponse
    {
        $article = Article::findOrFail($article);
        $article->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article->fresh(['author', 'tags'])),
            'message' => 'Artículo publicado exitosamente',
        ]);
    }

    public function unpublish(int $article): JsonResponse
    {
        $article = Article::findOrFail($article);
        $article->update([
            'is_published' => false,
        ]);

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article->fresh(['author', 'tags'])),
            'message' => 'Artículo despublicado exitosamente',
        ]);
    }

    private function calculateReadTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, (int) ceil($wordCount / 200));
    }
}
