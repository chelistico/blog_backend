<?php

namespace Database\Seeders;

use App\Models\FooterItem;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Categorías
            ['section' => 'categories', 'title' => 'Frontend', 'link_url' => '/tag/frontend', 'order' => 1],
            ['section' => 'categories', 'title' => 'Backend', 'link_url' => '/tag/backend', 'order' => 2],
            ['section' => 'categories', 'title' => 'DevOps', 'link_url' => '/tag/devops', 'order' => 3],
            ['section' => 'categories', 'title' => 'Bases de datos', 'link_url' => '/tag/bases-de-datos', 'order' => 4],
            ['section' => 'categories', 'title' => 'Seguridad', 'link_url' => '/tag/seguridad', 'order' => 5],
            
            // Legal
            ['section' => 'legal', 'title' => 'Política de Privacidad', 'link_url' => '/privacidad', 'order' => 1],
            ['section' => 'legal', 'title' => 'Términos de Uso', 'link_url' => '/terminos', 'order' => 2],
            ['section' => 'legal', 'title' => 'Contacto', 'link_url' => '/contacto', 'order' => 3],
            
            // Información
            ['section' => 'info', 'title' => 'Sobre Nosotros', 'link_url' => '/sobre-nosotros', 'order' => 1],
            ['section' => 'info', 'title' => 'Anúnciate', 'link_url' => '/anunciate', 'order' => 2],
            ['section' => 'info', 'title' => 'FAQ', 'link_url' => '/faq', 'order' => 3],
        ];

        foreach ($items as $item) {
            FooterItem::updateOrCreate(
                ['section' => $item['section'], 'title' => $item['title']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}
