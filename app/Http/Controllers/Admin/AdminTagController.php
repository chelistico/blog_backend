<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::withCount('articles')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:tags,slug',
            'description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $tag = Tag::create($validated);

        return response()->json([
            'success' => true,
            'data' => $tag,
            'message' => 'Tag creado exitosamente',
        ], 201);
    }

    public function show(int $tag): JsonResponse
    {
        $tag = Tag::withCount('articles')->findOrFail($tag);

        return response()->json([
            'success' => true,
            'data' => $tag,
        ]);
    }

    public function update(Request $request, int $tag): JsonResponse
    {
        $tag = Tag::findOrFail($tag);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'slug' => "nullable|string|max:100|unique:tags,slug,{$tag->id}",
            'description' => 'nullable|string|max:500',
        ]);

        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $tag->update($validated);

        return response()->json([
            'success' => true,
            'data' => $tag->fresh(),
            'message' => 'Tag actualizado exitosamente',
        ]);
    }

    public function destroy(int $tag): JsonResponse
    {
        $tag = Tag::findOrFail($tag);

        if ($tag->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'HAS_ARTICLES', 'message' => 'El tag tiene artículos asociados'],
            ], 422);
        }

        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag eliminado exitosamente',
        ]);
    }
}
