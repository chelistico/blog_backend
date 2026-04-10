<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['author', 'tags'])
            ->published();

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('summary', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $limit = min($request->get('limit', 10), 50);
        $articles = $query->latest()->paginate($limit);

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

    public function show(string $id): JsonResponse
    {
        // Buscar por ID o por slug
        $article = is_numeric($id)
            ? Article::find($id)
            : Article::where('slug', $id)->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Artículo no encontrado'],
            ], 404);
        }

        // Verificar que esté publicado
        if (!$article->is_published || ($article->published_at && $article->published_at->gt(now()))) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Artículo no encontrado'],
            ], 404);
        }

        $article->load(['author', 'tags']);
        $article->incrementViews();

        return response()->json([
            'success' => true,
            'data' => new ArticleResource($article),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = Article::with(['author', 'tags'])
            ->published()
            ->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->q}%")
                    ->orWhere('summary', 'LIKE', "%{$request->q}%")
                    ->orWhere('content', 'LIKE', "%{$request->q}%");
            });

        $limit = min($request->get('limit', 10), 50);
        $articles = $query->latest()->paginate($limit);

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

    public function byTag(Request $request, string $tag): JsonResponse
    {
        $query = Article::with(['author', 'tags'])
            ->published()
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('slug', $tag);
            });

        $limit = min($request->get('limit', 10), 50);
        $articles = $query->latest()->paginate($limit);

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

    public function store(ArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

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

    public function update(ArticleRequest $request, Article $article): JsonResponse
    {
        $data = $request->validated();
        $tagIds = $data['tags'] ?? null;
        unset($data['tags']);

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

    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Artículo eliminado exitosamente',
        ]);
    }
}
