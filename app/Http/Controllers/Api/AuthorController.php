<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::where('is_active', true)
            ->withCount('articles')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $authors,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $author = Author::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$author) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Autor no encontrado'],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $author,
        ]);
    }

    public function articles(string $slug, Request $request): JsonResponse
    {
        $author = Author::where('slug', $slug)->first();

        if (!$author) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Autor no encontrado'],
            ], 404);
        }

        $perPage = min($request->get('per_page', 10), 50);

        $articles = $author->articles()
            ->with(['author', 'tags'])
            ->published()
            ->orderByDesc('published_at')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'data' => $articles->items(),
                'pagination' => [
                    'current_page' => $articles->currentPage(),
                    'last_page' => $articles->lastPage(),
                    'per_page' => $articles->perPage(),
                    'total' => $articles->total(),
                ],
            ],
        ]);
    }
}
