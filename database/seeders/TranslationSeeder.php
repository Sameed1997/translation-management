<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Translation;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        $faker->unique(true);
        
        foreach (range(1, 12) as $batch) {
            Translation::factory()->count(10000)->create();
            $faker->unique(true); // Reset unique constraints after each batch
        }
    }
}
