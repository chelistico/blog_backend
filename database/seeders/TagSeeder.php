<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'TypeScript', 'slug' => 'typescript', 'description' => 'Lenguaje de programación tipado basado en JavaScript'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Lenguaje de programación para desarrollo web'],
            ['name' => 'React', 'slug' => 'react', 'description' => 'Biblioteca JavaScript para construir interfaces de usuario'],
            ['name' => 'Frontend', 'slug' => 'frontend', 'description' => 'Desarrollo de interfaces de usuario web'],
            ['name' => 'Backend', 'slug' => 'backend', 'description' => 'Desarrollo del lado del servidor'],
            ['name' => 'Programación', 'slug' => 'programacion', 'description' => 'Artículos sobre programación en general'],
            ['name' => 'Arquitectura', 'slug' => 'arquitectura', 'description' => 'Patrones y buenas prácticas de arquitectura de software'],
            ['name' => 'Microservicios', 'slug' => 'microservicios', 'description' => 'Diseño de sistemas basados en microservicios'],
            ['name' => 'DevOps', 'slug' => 'devops', 'description' => 'Integración de desarrollo y operaciones'],
            ['name' => 'Bases de datos', 'slug' => 'bases-de-datos', 'description' => 'Administración y diseño de bases de datos'],
            ['name' => 'PostgreSQL', 'slug' => 'postgresql', 'description' => 'Sistema de base de datos relacional'],
            ['name' => 'MongoDB', 'slug' => 'mongodb', 'description' => 'Base de datos NoSQL orientada a documentos'],
            ['name' => 'Seguridad', 'slug' => 'seguridad', 'description' => 'Seguridad en aplicaciones web'],
            ['name' => 'Docker', 'slug' => 'docker', 'description' => 'Plataforma de contenedores'],
            ['name' => 'Kubernetes', 'slug' => 'kubernetes', 'description' => 'Orquestación de contenedores'],
            ['name' => 'IA', 'slug' => 'ia', 'description' => 'Inteligencia Artificial y Machine Learning'],
            ['name' => 'Herramientas', 'slug' => 'herramientas', 'description' => 'Herramientas para desarrolladores'],
            ['name' => 'Productividad', 'slug' => 'productividad', 'description' => 'Tips y trucos para ser más productivo'],
            ['name' => 'Performance', 'slug' => 'performance', 'description' => 'Optimización de rendimiento'],
            ['name' => 'Optimización', 'slug' => 'optimizacion', 'description' => 'Mejora del rendimiento de aplicaciones'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
