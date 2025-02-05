<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Translation,User};
use Laravel\Sanctum\Sanctum;

class TranslationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate using Sanctum
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'] // Grant all permissions
        );
    }

    public function test_store_translation(): void
    {
        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'sameed',
            'content' => 'Welcome',
            'tags' => ['web', 'desktop'],
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['locale' => 'en', 'key' => 'sameed']);

        $this->assertDatabaseHas('translations', ['key' => 'sameed']);
    }

    public function test_update_translation(): void
    {
        $translation = Translation::factory()->create([
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello',
        ]);

        $response = $this->putJson("/api/translations/{$translation->id}", [
            'content' => 'Hello, Sameed!',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['content' => 'Hello, Sameed!']);

        $this->assertDatabaseHas('translations', ['content' => 'Hello, Sameed!']);
    }

    public function test_view_translation(): void
    {
        $translation = Translation::factory()->create();

        $response = $this->getJson("/api/translations/{$translation->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['key' => $translation->key]);
    }

    public function test_search_translations(): void
    {
        Translation::factory()->create([
            'tags' => ['mobile'],
            'key' => 'key1',
            'content' => 'Mobile content',
        ]);

        $response = $this->getJson('/api/translations?tags=mobile');

        $response->assertStatus(200)
                 ->assertJsonFragment(['content' => 'Mobile content']);
    }

    public function test_export_translations(): void
    {
        $response = $this->getJson('/api/export');

        $response->assertStatus(200);
    }

}
