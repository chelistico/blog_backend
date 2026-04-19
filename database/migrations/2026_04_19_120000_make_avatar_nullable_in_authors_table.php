<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            // Make avatar nullable - authors can be created without avatar initially
            $table->string('avatar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            // Revert avatar back to NOT NULL
            $table->string('avatar')->nullable(false)->change();
        });
    }
};
