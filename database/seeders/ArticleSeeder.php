<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Usar un autor existente o crear uno nuevo
        $author = Author::firstOrCreate(
            ['email' => 'carlos.mendoza@techdaily.com'],
            [
                'name' => 'Carlos Mendoza',
                'slug' => 'carlos-mendoza',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop&crop=face',
                'bio' => 'Desarrollador Full Stack con más de 10 años de experiencia. Especializado en JavaScript, TypeScript y arquitecturas escalables.',
                'is_active' => true,
            ]
        );

        // Obtener tags existentes o crear los que falten
        $tagsMapping = [
            'typescript' => Tag::firstOrCreate(['slug' => 'typescript'], ['name' => 'TypeScript']),
            'javascript' => Tag::firstOrCreate(['slug' => 'javascript'], ['name' => 'JavaScript']),
            'react' => Tag::firstOrCreate(['slug' => 'react'], ['name' => 'React']),
            'bases-de-datos' => Tag::firstOrCreate(['slug' => 'bases-de-datos'], ['name' => 'Bases de Datos']),
            'seguridad' => Tag::firstOrCreate(['slug' => 'seguridad'], ['name' => 'Seguridad']),
            'devops' => Tag::firstOrCreate(['slug' => 'devops'], ['name' => 'DevOps']),
            'docker' => Tag::firstOrCreate(['slug' => 'docker'], ['name' => 'Docker']),
            'kubernetes' => Tag::firstOrCreate(['slug' => 'kubernetes'], ['name' => 'Kubernetes']),
            'ia' => Tag::firstOrCreate(['slug' => 'ia'], ['name' => 'Inteligencia Artificial']),
            'rendimiento' => Tag::firstOrCreate(['slug' => 'rendimiento'], ['name' => 'Rendimiento']),
            'arquitectura' => Tag::firstOrCreate(['slug' => 'arquitectura'], ['name' => 'Arquitectura']),
            'programacion' => Tag::firstOrCreate(['slug' => 'programacion'], ['name' => 'Programación']),
        ];

        $articles = [
            [
                'title' => 'El futuro de TypeScript: Novedades en la versión 5.5',
                'slug' => 'futuro-typescript-novedades-55',
                'summary' => 'TypeScript 5.5 trae mejoras significativas en inferencia de tipos, rendimiento del compilador y nuevas características que revolucionarán el desarrollo web moderno.',
                'content' => '<p>TypeScript continúa evolucionando para hacer que el desarrollo JavaScript sea más seguro y productivo. La versión 5.5 introduce cambios que los desarrolladores han estado esperando.</p>

<h2>Inferencia mejorada</h2>
<p>Una de las características más esperadas es la mejora en la inferencia de tipos para funciones literales. Ahora TypeScript puede inferir tipos de retorno de funciones anónimas de manera más precisa.</p>

<pre><code>const result = ["1", "2", "3"].map(parseInt);
// Anterior: (string | number)[]
// Ahora: number[]</code></pre>

<h2>Rendimiento del compilador</h2>
<p>Las mejoras en el rendimiento del compilador hacen que los proyectos grandes se compilen significativamente más rápido. Los tiempos de construcción se han reducido hasta en un 30%.</p>

<h2>Nuevas utilities types</h2>
<p>Se han añadido nuevas utilitarias de tipos que simplifican el trabajo cotidiano con tipos complejos.</p>

<h2>Conclusión</h2>
<p>TypeScript 5.5 marca un hito importante en la historia del lenguaje, haciendo que la experiencia de desarrollo sea más fluida y eficiente.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(1),
                'read_time' => 8,
                'views' => 1250,
                'tags' => ['typescript', 'javascript'],
            ],
            [
                'title' => 'Arquitectura de Microservicios: Patrones y mejores prácticas',
                'slug' => 'arquitectura-microservicios-patrones',
                'summary' => 'Guía completa sobre cómo diseñar y implementar arquitecturas de microservicios escalables y mantenibles en entornos empresariales modernos.',
                'content' => '<p>La arquitectura de microservicios se ha convertido en el estándar para aplicaciones distribuidas a gran escala. En este artículo exploraremos los patrones más efectivos.</p>

<h2>Patrones fundamentales</h2>
<p>Exploramos los patrones de diseño esenciales: API Gateway, Service Mesh, Circuit Breaker, y muchos más.</p>

<h2>Comunicación entre servicios</h2>
<p>La comunicación síncrona vs asíncrona es una decisión crítica. Analizamos cuándo usar cada una y los protocolos involucrados.</p>

<h2>Gestión de datos</h2>
<p>Cada microservicio debe tener su propia base de datos. Discutimos las estrategias de consistencia y transacciones distribuidas.</p>

<h2>Observabilidad</h2>
<p>Logging, métricas y tracing son esenciales para entender el comportamiento del sistema en producción.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(3),
                'read_time' => 12,
                'views' => 2100,
                'tags' => ['arquitectura', 'programacion'],
            ],
            [
                'title' => 'React Server Components: El cambio de paradigma en React',
                'slug' => 'react-server-components-paradigma',
                'summary' => 'React Server Components representan un cambio fundamental en cómo construimos aplicaciones React. Aprende cómo aprovechar esta tecnología.',
                'content' => '<p>Los React Server Components (RSC) han llegado para cambiar la forma en que pensamos el renderizado en React. Este artículo te guiará a través de esta nueva arquitectura.</p>

<h2>¿Qué son los Server Components?</h2>
<p>Los Server Components son componentes que se renderizan exclusivamente en el servidor, enviando HTML al cliente sin JavaScript asociado.</p>

<h2>Beneficios principales</h2>
<ul>
<li>Menor bundle size</li>
<li>Acceso directo a backend</li>
<li>Mejor SEO</li>
<li>Experiencia de usuario mejorada</li>
</ul>

<h2>Ejemplo práctico</h2>
<pre><code>async function ArticleList() {
  const articles = await db.posts.findAll();
  return articles.map(post => <Post key={post.id} {...post} />);
}</code></pre>

<h2>Migración gradual</h2>
<p>Puedes adoptar RSC de forma incremental en tu aplicación existente sin riesgo.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1587620962725-abab7fe55159?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(5),
                'read_time' => 10,
                'views' => 1850,
                'tags' => ['react', 'javascript'],
            ],
            [
                'title' => 'PostgreSQL vs MongoDB: ¿Cuál elegir en 2025?',
                'slug' => 'postgresql-vs-mongodb-2025',
                'summary' => 'Comparativa detallada entre PostgreSQL y MongoDB para ayudarte a tomar la mejor decisión según tu caso de uso específico.',
                'content' => '<p>Elegir la base de datos correcta es crucial para el éxito de tu proyecto. Comparamos dos de las opciones más populares del mercado.</p>

<h2>PostgreSQL: La opción relacional</h2>
<p>PostgreSQL es una base de datos relacional objeto-relacional con más de 35 años de desarrollo activo. Ofrece:</p>
<ul>
<li>SQL completo con extensiones</li>
<li>Transacciones ACID completas</li>
<li>Tipos de datos avanzados</li>
<li>Excelente rendimiento en consultas complejas</li>
</ul>

<h2>MongoDB: La opción de documentos</h2>
<p>MongoDB es una base de datos NoSQL orientada a documentos que brilla en:</p>
<ul>
<li>Flexibilidad de esquema</li>
<li>Escalabilidad horizontal nativa</li>
<li>Documentos JSON nativos</li>
<li>Prototipado rápido</li>
</ul>

<h2>¿Cuándo usar cada una?</h2>
<p>La respuesta depende de tu caso de uso específico. Analizamos los escenarios ideales para cada una.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(7),
                'read_time' => 9,
                'views' => 3200,
                'tags' => ['bases-de-datos'],
            ],
            [
                'title' => 'Seguridad en aplicaciones web: Vulnerabilidades comunes en 2025',
                'slug' => 'seguridad-aplicaciones-web-vulnerabilidades-2025',
                'summary' => 'Análisis de las vulnerabilidades de seguridad más frecuentes en aplicaciones web y cómo protegerse contra ellas de manera efectiva.',
                'content' => '<p>La seguridad web nunca ha sido tan importante. Con el aumento de ataques sofisticados, es crucial conocer las vulnerabilidades más comunes.</p>

<h2>OWASP Top 10</h2>
<p>Actualizamos el análisis del OWASP Top 10 con las últimas estadísticas y casos de estudio reales.</p>

<h2>Vulnerabilidades críticas</h2>
<ul>
<li>Inyección SQL moderna</li>
<li>Cross-Site Scripting (XSS)</li>
<li>Broken Authentication</li>
<li>Sensitive Data Exposure</li>
<li>Security Misconfiguration</li>
</ul>

<h2>Mejores prácticas</h2>
<p>Implementa estas prácticas de seguridad desde el inicio del desarrollo para proteger tu aplicación.</p>

<h2>Herramientas de seguridad</h2>
<p>Conoce las herramientas que te ayudarán a detectar y remediar vulnerabilidades en tu código.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1510511459019-5dda7724fd87?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(10),
                'read_time' => 11,
                'views' => 1560,
                'tags' => ['seguridad'],
            ],
            [
                'title' => 'Docker y Kubernetes: Containerización en producción',
                'slug' => 'docker-kubernetes-containerizacion-produccion',
                'summary' => 'Guía práctica para desplegar aplicaciones containerizadas en producción usando Docker y Kubernetes con las mejores prácticas.',
                'content' => '<p>La containerización ha revolucionado el despliegue de aplicaciones. Aprende a dominar Docker y Kubernetes para entornos de producción.</p>

<h2>Fundamentos de Docker</h2>
<p>Comprende los conceptos básicos: imágenes, contenedores, volúmenes y redes. Construye imágenes optimizadas para producción.</p>

<h2>Kubernetes desde cero</h2>
<p>Domina los componentes de Kubernetes: Pods, Deployments, Services, ConfigMaps y Secrets.</p>

<pre><code>apiVersion: apps/v1
kind: Deployment
metadata:
  name: my-app
spec:
  replicas: 3
  selector:
    matchLabels:
      app: my-app
  template:
    spec:
      containers:
      - name: my-app
        image: my-app:latest
        ports:
        - containerPort: 8080</code></pre>

<h2>Estrategias de despliegue</h2>
<p>Rolling updates, blue-green deployments, canary releases: elige la estrategia correcta para tu caso.</p>

<h2>Monitoring y logging</h2>
<p>Implementa observabilidad completa en tu cluster de Kubernetes.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1667372393119-3d4c48d07fc9?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(14),
                'read_time' => 14,
                'views' => 2800,
                'tags' => ['docker', 'kubernetes', 'devops'],
            ],
            [
                'title' => 'Inteligencia Artificial en desarrollo: GitHub Copilot y alternativas',
                'slug' => 'ia-desarrollo-github-copilot-alternativas',
                'summary' => 'Explora las mejores herramientas de IA para ayudarte a escribir mejor código más rápido, incluyendo GitHub Copilot, Cursor y más.',
                'content' => '<p>La IA está transformando la forma en que escribimos código. En este artículo comparamos las mejores herramientas de asistencia de código.</p>

<h2>GitHub Copilot</h2>
<p>El asistente de código de Microsoft que ha revolucionado la productividad de los desarrolladores. Análisis de sus fortalezas y limitaciones.</p>

<h2>Cursor</h2>
<p>El IDE con IA integrada que ofrece una experiencia de desarrollo completamente nueva. Características únicas que lo distinguen.</p>

<h2>Tabnine</h2>
<p>Alternativa con enfoque en la privacidad y personalización. Ideal para equipos empresariales con requisitos de seguridad.</p>

<h2>Amazon CodeWhisperer</h2>
<p>La propuesta de AWS con integración profunda en el ecosistema de servicios de Amazon.</p>

<h2>¿Cuál elegir?</h2>
<p>Comparativa detallada basada en características, precios y casos de uso específicos.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(20),
                'read_time' => 8,
                'views' => 4500,
                'tags' => ['ia', 'programacion'],
            ],
            [
                'title' => 'Optimización de rendimiento en aplicaciones React',
                'slug' => 'optimizacion-rendimiento-react',
                'summary' => 'Técnicas avanzadas para mejorar el rendimiento de tus aplicaciones React, desde memoización hasta renderizado selectivo.',
                'content' => '<p>El rendimiento es crucial para la experiencia del usuario. Aprende técnicas probadas para hacer tus aplicaciones React más rápidas.</p>

<h2>React.memo y useMemo</h2>
<p>Optimiza re-renderizados innecesarios con las herramientas de memoización de React.</p>

<pre><code>const ExpensiveList = React.memo(({ items }) => {
  return items.map(item => <ListItem key={item.id} {...item} />);
});</code></pre>

<h2>Code splitting</h2>
<p>Carga solo el código que necesitas cuando lo necesitas con React.lazy y Suspense.</p>

<h2>Virtualización de listas</h2>
<p>Maneja grandes cantidades de datos sin sacrificar rendimiento con react-window o react-virtualized.</p>

<h2>Optimización de imágenes</h2>
<p>Estrategias para cargar imágenes de manera eficiente y reducir el tiempo de carga.</p>

<h2>Profiling</h2>
<p>Usa React DevTools Profiler para identificar cuellos de botella en tu aplicación.</p>',
                'main_image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=400&fit=crop',
                'embedded_images' => ['https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600'],
                'video_url' => null,
                'author_id' => $author->id,
                'published_at' => now()->subDays(25),
                'read_time' => 10,
                'views' => 1980,
                'tags' => ['react', 'rendimiento', 'javascript'],
            ],
        ];

        foreach ($articles as $articleData) {
            $tagSlugs = $articleData['tags'];
            unset($articleData['tags']);
            
            // Verificar si el artículo ya existe por slug
            $article = Article::firstOrCreate(
                ['slug' => $articleData['slug']],
                array_merge($articleData, [
                    'author_id' => $author->id,
                    'is_published' => true,
                ])
            );

            $tagIds = collect($tagSlugs)->map(fn($slug) => $tagsMapping[$slug]->id)->toArray();
            $article->tags()->sync($tagIds);
        }
    }
}
