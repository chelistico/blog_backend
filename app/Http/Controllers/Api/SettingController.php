<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = SiteSetting::all()->groupBy('group');

        $formatted = $settings->map(function ($groupSettings) {
            return $groupSettings->mapWithKeys(function ($setting) {
                $value = match($setting->type) {
                    'json' => json_decode($setting->value, true),
                    'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                    default => $setting->value,
                };
                return [$setting->key => $value];
            });
        });

        return response()->json([
            'success' => true,
            'data' => $formatted,
        ]);
    }
}
