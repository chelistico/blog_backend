<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            // Make avatar nullable and add social_links and is_active columns if missing
            if (!Schema::hasColumn('authors', 'social_links')) {
                $table->json('social_links')->nullable()->after('email');
            }
            if (!Schema::hasColumn('authors', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('social_links');
            }
            
            // Modify avatar to be nullable
            $table->string('avatar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            // Revert avatar back to not nullable
            $table->string('avatar')->change();
            
            // Remove added columns if they didn't exist before
            if (Schema::hasColumn('authors', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('authors', 'social_links')) {
                $table->dropColumn('social_links');
            }
        });
    }
};
