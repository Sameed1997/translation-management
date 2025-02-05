<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Translation;

class TranslationTest extends TestCase
{
    public function test_translation_creation(): void
    {
        $translation = Translation::factory()->create([
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello',
            'tags' => ['mobile', 'web'],
        ]);

        $this->assertDatabaseHas('translations', [
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello',
        ]);

        $this->assertIsArray($translation->tags);
    }

    public function test_translation_update(): void
    {
        $translation = Translation::factory()->create();
        $translation->update(['content' => 'Updated content']);

        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'content' => 'Updated content',
        ]);
    }
}
