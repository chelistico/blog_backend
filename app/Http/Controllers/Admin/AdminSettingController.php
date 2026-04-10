<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = SiteSetting::query();

        if ($request->has('group')) {
            $query->where('group', $request->group);
        }

        $settings = $query->orderBy('group')->orderBy('key')->get();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    public function show(int $setting): JsonResponse
    {
        $setting = SiteSetting::findOrFail($setting);

        return response()->json([
            'success' => true,
            'data' => $setting,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|exists:site_settings,key',
            'value' => 'nullable',
        ]);

        $setting = SiteSetting::where('key', $validated['key'])->first();
        $setting->update(['value' => $validated['value']]);

        return response()->json([
            'success' => true,
            'data' => $setting->fresh(),
            'message' => 'Configuración actualizada exitosamente',
        ]);
    }

    public function updateMultiple(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|exists:site_settings,key',
            'settings.*.value' => 'nullable',
        ]);

        foreach ($validated['settings'] as $item) {
            SiteSetting::where('key', $item['key'])->update(['value' => $item['value']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Configuraciones actualizadas exitosamente',
        ]);
    }
}
