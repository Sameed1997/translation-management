<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Translation,User};
use Laravel\Sanctum\Sanctum;
use Faker\Factory as FakerFactory;

class TranslationPerformanceTest extends TestCase
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

    public function test_json_export_performance(): void
    {
        $startTime = microtime(true);

        $response = $this->getJson('/api/export');

        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;

        $response->assertStatus(200);

        $this->assertLessThan(0.5, $executionTime, 'Response time exceeded 500ms');
    }
}
