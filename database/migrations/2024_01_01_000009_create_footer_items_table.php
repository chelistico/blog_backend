<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_items', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['section', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_items');
    }
};
