<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervenant>
 */
class IntervenantFactory extends Factory
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
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->email(),
            'password' => \Hash::make('test'),
            'prestataire' => false,
        ];
    }
}
