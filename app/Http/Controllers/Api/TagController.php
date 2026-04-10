<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Tag::query();

        if ($request->boolean('withCount')) {
            $query->withCount('articles');
        }

        $tags = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => TagResource::collection($tags),
            'message' => 'Etiquetas obtenidas exitosamente',
        ]);
    }

    public function show(string $tag): JsonResponse
    {
        $tagModel = Tag::where('slug', $tag)->firstOrFail();

        if (request()->boolean('withCount')) {
            $tagModel->loadCount('articles');
        }

        return response()->json([
            'success' => true,
            'data' => new TagResource($tagModel),
            'message' => 'Etiqueta obtenida exitosamente',
        ]);
    }
}
