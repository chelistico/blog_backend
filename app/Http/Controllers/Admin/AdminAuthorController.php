<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Author::withCount('articles');

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $authors = $query->orderBy('name')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'data' => AuthorResource::collection($authors),
                'pagination' => [
                    'current_page' => $authors->currentPage(),
                    'last_page' => $authors->lastPage(),
                    'per_page' => $authors->perPage(),
                    'total' => $authors->total(),
                ],
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:authors,slug',
            'avatar' => 'nullable|string|url',
            'bio' => 'nullable|string|max:1000',
            'email' => 'required|email|unique:authors,email',
            'social_links' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $author = Author::create($validated);

        return response()->json([
            'success' => true,
            'data' => new AuthorResource($author),
            'message' => 'Autor creado exitosamente',
        ], 201);
    }

    public function show(int $author): JsonResponse
    {
        $author = Author::withCount('articles')->findOrFail($author);

        return response()->json([
            'success' => true,
            'data' => new AuthorResource($author),
        ]);
    }

    public function update(Request $request, int $author): JsonResponse
    {
        $author = Author::findOrFail($author);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => "nullable|string|max:255|unique:authors,slug,{$author->id}",
            'avatar' => 'nullable|string|url',
            'bio' => 'nullable|string|max:1000',
            'email' => "sometimes|required|email|unique:authors,email,{$author->id}",
            'social_links' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $author->update($validated);

        return response()->json([
            'success' => true,
            'data' => new AuthorResource($author->fresh()),
            'message' => 'Autor actualizado exitosamente',
        ]);
    }

    public function destroy(int $author): JsonResponse
    {
        $author = Author::findOrFail($author);

        if ($author->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'HAS_ARTICLES', 'message' => 'El autor tiene artículos asociados'],
            ], 422);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Autor eliminado exitosamente',
        ]);
    }
}
