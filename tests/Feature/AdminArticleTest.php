<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_article(): void
    {
        $admin = User::factory()->admin()->create();
        $author = Author::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($admin)->postJson('/api/admin/articles', [
            'title' => 'New Article',
            'summary' => 'Article summary',
            'content' => '<p>Content here</p>',
            'main_image' => 'https://example.com/image.jpg',
            'author_id' => $author->id,
            'tags' => [$tag->id],
            'is_published' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Article');

        $this->assertDatabaseHas('articles', ['title' => 'New Article']);
    }

    public function test_non_admin_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['role' => 'author']);

        $response = $this->actingAs($user)->getJson('/api/admin/articles');

        $response->assertStatus(403);
    }

    public function test_can_update_article(): void
    {
        $admin = User::factory()->admin()->create();
        $article = Article::factory()->create();

        $response = $this->actingAs($admin)->putJson("/api/admin/articles/{$article->id}", [
            'title' => 'Updated Title',
            'summary' => $article->summary,
            'content' => $article->content,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title');
    }

    public function test_can_delete_article(): void
    {
        $admin = User::factory()->admin()->create();
        $article = Article::factory()->create();

        $response = $this->actingAs($admin)->deleteJson("/api/admin/articles/{$article->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_unauthenticated_user_cannot_access_admin(): void
    {
        $response = $this->getJson('/api/admin/articles');

        $response->assertStatus(401);
    }
}
