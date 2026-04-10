<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => fake()->paragraph(2),
            'content' => $this->generateContent(),
            'main_image' => fake()->imageUrl(1200, 630, 'technology'),
            'embedded_images' => [
                fake()->imageUrl(800, 600, 'technology'),
                fake()->imageUrl(800, 600, 'business'),
            ],
            'video_url' => null,
            'author_id' => Author::factory(),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'read_time' => fake()->numberBetween(3, 20),
            'views' => fake()->numberBetween(0, 10000),
            'is_published' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
        ]);
    }

    private function generateContent(): string
    {
        $content = '<p>' . fake()->paragraphs(3, true) . '</p>';
        $content .= '<h2>' . fake()->sentence() . '</h2>';
        $content .= '<p>' . fake()->paragraphs(2, true) . '</p>';
        
        // Agregar ejemplos de código
        $content .= '<p>Aquí hay un ejemplo de código:</p>';
        $content .= '<pre><code>const hello = "mundo";';
        $content .= "\n";
        $content .= 'console.log(hello);</code></pre>';
        
        $content .= '<p>' . fake()->paragraphs(2, true) . '</p>';
        
        return $content;
    }
}
