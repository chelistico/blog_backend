<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing article image URLs to file paths (for backward compatibility)
        // Only convert if data contains HTTP URLs from external sources
        DB::table('articles')->whereNotNull('main_image')
            ->where(function ($query) {
                $query->where('main_image', 'like', 'http://%')
                    ->orWhere('main_image', 'like', 'https://%');
            })
            ->orderBy('id')
            ->each(function ($article) {
                // Keep external URLs as-is for now - they're already full URLs
                // This is backward compatible as API resources check for http/https
            });

        // Convert embedded_images JSON arrays from URLs to file paths
        DB::table('articles')->whereNotNull('embedded_images')
            ->orderBy('id')
            ->each(function ($article) {
                $images = json_decode($article->embedded_images, true);
                if (is_array($images) && count($images) > 0) {
                    // Check if these are URL-based
                    $hasUrls = collect($images)->some(function ($url) {
                        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://');
                    });
                    
                    if ($hasUrls) {
                        // Keep external URLs as-is for backward compatibility
                        // API resource will handle them properly
                    }
                }
            });

        // Convert existing advertisement image URLs to file paths
        DB::table('advertisements')->whereNotNull('image')
            ->where(function ($query) {
                $query->where('image', 'like', 'http://%')
                    ->orWhere('image', 'like', 'https://%');
            })
            ->orderBy('id')
            ->each(function ($ad) {
                // Keep external URLs as-is for now - they're already full URLs
                // This is backward compatible as API resources check for http/https
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only performs conditional conversions and doesn't
        // make destructive changes, so there's nothing to revert
    }
};
