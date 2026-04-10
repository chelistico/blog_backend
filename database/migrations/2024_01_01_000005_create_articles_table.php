<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('content');
            $table->string('main_image');
            $table->json('embedded_images')->nullable();
            $table->string('video_url')->nullable();
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->integer('read_time')->default(5);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
