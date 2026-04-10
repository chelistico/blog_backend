<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAdvertisementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Advertisement::query();

        if ($request->has('position')) {
            $query->where('position', $request->position);
        }

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $advertisements = $query->orderBy('position')->orderBy('order')->get();

        return response()->json([
            'success' => true,
            'data' => $advertisements,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|in:top,sidebar,inline,bottom,mobile',
            'image' => 'nullable|string|url',
            'link' => 'nullable|string|url',
            'code' => 'nullable|string',
            'dimensions' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'order' => 'integer|min:0',
        ]);

        $advertisement = Advertisement::create($validated);

        return response()->json([
            'success' => true,
            'data' => new AdvertisementResource($advertisement),
            'message' => 'Anuncio creado exitosamente',
        ], 201);
    }

    public function show(int $advertisement): JsonResponse
    {
        $advertisement = Advertisement::findOrFail($advertisement);

        return response()->json([
            'success' => true,
            'data' => new AdvertisementResource($advertisement),
        ]);
    }

    public function update(Request $request, int $advertisement): JsonResponse
    {
        $advertisement = Advertisement::findOrFail($advertisement);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|in:top,sidebar,inline,bottom,mobile',
            'image' => 'nullable|string|url',
            'link' => 'nullable|string|url',
            'code' => 'nullable|string',
            'dimensions' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'order' => 'integer|min:0',
        ]);

        $advertisement->update($validated);

        return response()->json([
            'success' => true,
            'data' => new AdvertisementResource($advertisement->fresh()),
            'message' => 'Anuncio actualizado exitosamente',
        ]);
    }

    public function destroy(int $advertisement): JsonResponse
    {
        $advertisement = Advertisement::findOrFail($advertisement);
        $advertisement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anuncio eliminado exitosamente',
        ]);
    }
}
