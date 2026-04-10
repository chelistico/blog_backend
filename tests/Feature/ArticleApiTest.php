<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_published_articles(): void
    {
        Article::factory()->count(3)->create(['is_published' => true]);
        Article::factory()->create(['is_published' => false]);

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'slug', 'summary', 'author', 'tags']
                    ],
                    'pagination' => ['current_page', 'last_page', 'per_page', 'total']
                ]
            ])
            ->assertJsonCount(3, 'data.data');
    }

    public function test_can_show_single_article(): void
    {
        $article = Article::factory()->create([
            'is_published' => true,
            'title' => 'Test Article'
        ]);

        $response = $this->getJson("/api/articles/{$article->slug}");

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Test Article')
            ->assertJsonPath('data.slug', $article->slug);
    }

    public function test_increments_views_on_show(): void
    {
        $article = Article::factory()->create(['is_published' => true, 'views' => 10]);

        $this->getJson("/api/articles/{$article->slug}");

        $this->assertEquals(11, $article->fresh()->views);
    }

    public function test_can_search_articles(): void
    {
        Article::factory()->create(['title' => 'Laravel Tutorial', 'is_published' => true]);
        Article::factory()->create(['title' => 'React Guide', 'is_published' => true]);

        $response = $this->getJson('/api/articles/search?q=Laravel');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.title', 'Laravel Tutorial');
    }

    public function test_can_filter_articles_by_tag(): void
    {
        $tag = Tag::factory()->create(['slug' => 'php']);
        $article1 = Article::factory()->create(['is_published' => true]);
        $article2 = Article::factory()->create(['is_published' => true]);

        $article1->tags()->attach($tag);

        $response = $this->getJson('/api/articles/by-tag/php');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data');
    }

    public function test_draft_articles_not_visible(): void
    {
        $article = Article::factory()->create(['is_published' => false]);

        $response = $this->getJson("/api/articles/{$article->slug}");

        $response->assertStatus(404);
    }
}
