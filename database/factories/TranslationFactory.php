<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = \App\Models\Translation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'key' => 'key_' . $this->faker->unique()->numberBetween(1, 100000),
            'content' => $this->faker->sentence,
            'tags' => $this->faker->randomElements(['mobile', 'desktop', 'web'], rand(1, 3)),
        ];
    }
}
