<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $position = $request->get('position');

        $query = Advertisement::active()->orderBy('order');

        if ($position) {
            $query->where('position', $position);
        }

        $advertisements = $query->get();

        return response()->json([
            'success' => true,
            'data' => $advertisements,
        ]);
    }
}
