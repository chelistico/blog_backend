<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'María González',
                'slug' => 'maria-gonzalez',
                'avatar' => 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=200',
                'bio' => 'Desarrolladora Full Stack con más de 8 años de experiencia en tecnologías web modernas. Especializado en React, Node.js y arquitecturas de microservicios.',
                'email' => 'maria@techdaily.com',
                'social_links' => [
                    'twitter' => 'https://twitter.com/mariagonzalez',
                    'github' => 'https://github.com/mariagonzalez',
                    'linkedin' => 'https://linkedin.com/in/mariagonzalez',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Ramírez',
                'slug' => 'carlos-ramirez',
                'avatar' => 'https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=200',
                'bio' => 'Ingeniero de sistemas y amante del código limpio. Experto en arquitectura de microservicios, Kubernetes y CI/CD.',
                'email' => 'carlos@techdaily.com',
                'social_links' => [
                    'twitter' => 'https://twitter.com/carlosramirez',
                    'github' => 'https://github.com/carlosramirez',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Laura Martínez',
                'slug' => 'laura-martinez',
                'avatar' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=200',
                'bio' => 'Frontend Developer apasionada por React y las interfaces de usuario. Creadora de contenido sobre diseño UX y accesibilidad web.',
                'email' => 'laura@techdaily.com',
                'social_links' => [
                    'twitter' => 'https://twitter.com/lauramartinez',
                    'github' => 'https://github.com/lauramartinez',
                    'linkedin' => 'https://linkedin.com/in/lauramartinez',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($authors as $author) {
            Author::updateOrCreate(['email' => $author['email']], $author);
        }

        // Crear autores adicionales con factory si es necesario
        if (Author::count() < 5) {
            Author::factory(3)->create();
        }
    }
}
