<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrestataireFactory extends Factory
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
            'siret' => '12345678912345',
            'raison_sociale' => fake()->company(),
            'nom' => fake()->name(),
            'adresse' => fake()->streetAddress(),
            'code_postal' => fake()->randomNumber(5, true),
            'ville' => fake()->city(),
            'taux_horaire' => fake()->randomFloat(2, 0, 100),
            'id_intervenant' => \App\Models\Intervenant::factory()->create(['prestataire' => true])
        ];
    }
}
