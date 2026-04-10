<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        $name = fake()->name();
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'avatar' => fake()->imageUrl(200, 200, 'people'),
            'bio' => fake()->paragraph(2),
            'email' => fake()->unique()->safeEmail(),
            'social_links' => [
                'twitter' => 'https://twitter.com/' . fake()->userName(),
                'github' => 'https://github.com/' . fake()->userName(),
                'linkedin' => 'https://linkedin.com/in/' . fake()->userName(),
            ],
            'is_active' => true,
        ];
    }
}
