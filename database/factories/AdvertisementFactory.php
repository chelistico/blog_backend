<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'position' => fake()->randomElement(['top', 'sidebar', 'inline', 'bottom', 'mobile']),
            'image' => fake()->imageUrl(728, 90, 'business'),
            'link' => fake()->url(),
            'code' => null,
            'dimensions' => fake()->randomElement(['728x90', '300x250', '320x100']),
            'is_active' => true,
            'start_date' => null,
            'end_date' => null,
            'order' => fake()->numberBetween(1, 10),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function withCode(): static
    {
        return $this->state(fn(array $attributes) => [
            'code' => '<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-XXXXXXXX" data-ad-slot="XXXXXXXX"></ins>',
            'image' => null,
        ]);
    }
}
