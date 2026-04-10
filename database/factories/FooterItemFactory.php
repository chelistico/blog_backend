<?php

namespace Database\Factories;

use App\Models\FooterItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FooterItemFactory extends Factory
{
    protected $model = FooterItem::class;

    public function definition(): array
    {
        return [
            'section' => fake()->randomElement(['categories', 'legal', 'info', 'social']),
            'title' => fake()->words(2, true),
            'content' => null,
            'link_url' => '/' . fake()->slug(),
            'order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
