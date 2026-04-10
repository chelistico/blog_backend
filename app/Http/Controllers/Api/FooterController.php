<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use Illuminate\Http\JsonResponse;

class FooterController extends Controller
{
    public function index(): JsonResponse
    {
        $footer = FooterItem::active()
            ->orderBy('section')
            ->orderBy('order')
            ->get()
            ->groupBy('section');

        return response()->json([
            'success' => true,
            'data' => $footer,
        ]);
    }
}
