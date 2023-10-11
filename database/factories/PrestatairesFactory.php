<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrestatairesFactory extends Factory
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
            'prestataire' => 1,
        ];
    }
}
