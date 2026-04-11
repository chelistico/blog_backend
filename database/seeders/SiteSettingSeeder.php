<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Branding
            [
                'key' => 'site_name',
                'value' => 'TechDaily',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Nombre del sitio',
            ],
            [
                'key' => 'site_title',
                'value' => 'TechDaily - Noticias de Tecnología',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Título completo del sitio',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Noticias de tecnología',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Tagline del sitio',
            ],
            [
                'key' => 'logo',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Logo principal',
            ],
            [
                'key' => 'logo_light',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Logo versión clara',
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Favicon del sitio',
            ],
            // SEO
            [
                'key' => 'seo_title',
                'value' => null,
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Título SEO (meta title)',
            ],
            [
                'key' => 'seo_description',
                'value' => 'Tu fuente diaria de noticias sobre tecnología, programación y desarrollo de sistemas.',
                'type' => 'textarea',
                'group' => 'seo',
                'description' => 'Descripción meta',
            ],
            [
                'key' => 'seo_keywords',
                'value' => 'tecnología, programación, desarrollo, software, noticias tech',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Palabras clave',
            ],
            [
                'key' => 'og_image',
                'value' => null,
                'type' => 'image',
                'group' => 'seo',
                'description' => 'Imagen Open Graph por defecto',
            ],
            // Social
            [
                'key' => 'social_twitter',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'description' => 'Twitter/X',
            ],
            [
                'key' => 'social_facebook',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'description' => 'Facebook',
            ],
            [
                'key' => 'social_linkedin',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'description' => 'LinkedIn',
            ],
            [
                'key' => 'social_github',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'description' => 'GitHub',
            ],
            // Analytics
            [
                'key' => 'analytics_google',
                'value' => null,
                'type' => 'text',
                'group' => 'analytics',
                'description' => 'Google Analytics ID',
            ],
            [
                'key' => 'analytics_google_tag',
                'value' => null,
                'type' => 'text',
                'group' => 'analytics',
                'description' => 'Google Tag Manager ID',
            ],
            // Ads
            [
                'key' => 'ads_adsense_client',
                'value' => null,
                'type' => 'text',
                'group' => 'ads',
                'description' => 'AdSense Client ID',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
