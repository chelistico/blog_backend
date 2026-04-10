<?php

namespace Tests\Unit;

use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_scope_excludes_inactive(): void
    {
        Advertisement::factory()->create(['is_active' => true]);
        Advertisement::factory()->create(['is_active' => false]);

        $this->assertEquals(1, Advertisement::active()->count());
    }

    public function test_active_scope_excludes_expired(): void
    {
        Advertisement::factory()->create([
            'is_active' => true,
            'end_date' => now()->subDay(),
        ]);

        Advertisement::factory()->create([
            'is_active' => true,
            'end_date' => now()->addDay(),
        ]);

        $this->assertEquals(1, Advertisement::active()->count());
    }

    public function test_active_scope_includes_current_start_date(): void
    {
        Advertisement::factory()->create([
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $this->assertEquals(1, Advertisement::active()->count());
    }
}
