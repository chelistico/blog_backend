<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AuthorSeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            SiteSettingSeeder::class,
            AdvertisementSeeder::class,
            FooterSeeder::class,
        ]);
    }
}
