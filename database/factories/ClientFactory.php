<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'raison_sociale' => fake()->company(),
            'siret' => fake()->numberBetween(10000000000000, 99999999999999),
            'ville' => fake()->city(),
        ];
    }
}
