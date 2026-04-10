<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'name' => 'Banner Principal - Top',
                'position' => 'top',
                'dimensions' => '728x90',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Banner Lateral - Sidebar',
                'position' => 'sidebar',
                'dimensions' => '300x250',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Banner Inline - Entre artículos',
                'position' => 'inline',
                'dimensions' => '728x90',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Banner Inferior - Bottom',
                'position' => 'bottom',
                'dimensions' => '728x90',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Banner Mobile',
                'position' => 'mobile',
                'dimensions' => '320x100',
                'is_active' => true,
                'order' => 1,
            ],
        ];

        foreach ($ads as $ad) {
            Advertisement::updateOrCreate(
                ['name' => $ad['name']],
                $ad
            );
        }
    }
}
