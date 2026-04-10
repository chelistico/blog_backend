<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminFooterController extends Controller
{
    public function index(): JsonResponse
    {
        $items = FooterItem::orderBy('section')->orderBy('order')->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'section' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'link_url' => 'nullable|string|max:500',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $item = FooterItem::create($validated);

        return response()->json([
            'success' => true,
            'data' => $item,
            'message' => 'Item de footer creado exitosamente',
        ], 201);
    }

    public function show(int $footerItem): JsonResponse
    {
        $item = FooterItem::findOrFail($footerItem);

        return response()->json([
            'success' => true,
            'data' => $item,
        ]);
    }

    public function update(Request $request, int $footerItem): JsonResponse
    {
        $item = FooterItem::findOrFail($footerItem);

        $validated = $request->validate([
            'section' => 'sometimes|required|string|max:50',
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'link_url' => 'nullable|string|max:500',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'data' => $item->fresh(),
            'message' => 'Item de footer actualizado exitosamente',
        ]);
    }

    public function destroy(int $footerItem): JsonResponse
    {
        $item = FooterItem::findOrFail($footerItem);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item de footer eliminado exitosamente',
        ]);
    }
}
