<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProjetFactory extends Factory
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
            'libelle' => fake()->randomElement([
                "Optimisation de l'infrastructure réseau",
                "Migration vers la fibre optique",
                "Sécurisation des réseaux d'entreprise",
                "Virtualisation des serveurs",
                "Mise en place de VPN sécurisés",
                "Amélioration de la connectivité sans fil",
                "Déploiement de réseaux SD-WAN",
                "Gestion des réseaux IoT",
                "Audit de l'infrastructure réseau",
                "Expansion de la capacité réseau",
                "Mise en place de la téléphonie VoIP",
                "Optimisation de la bande passante",
                "Planification de la redondance réseau",
                "Analyse de la performance réseau",
                "Intégration de la technologie 5G",
                "Développement de réseaux privés",
                "Gestion des projets de cloud hybride",
                "Stratégie de cybersécurité réseau",
                "Optimisation de la latence réseau",
                "Gestion des projets d'automatisation réseau",
            ]),
            'statut' => fake()->randomElement([
                "En cours de planification",
                "En phase de conception",
                "En cours de développement",
                "En phase de test",
                "En cours de déploiement",
                "En cours d'optimisation",
                "En attente d'approbation",
                "En pause temporaire",
                "En phase de documentation",
                "En cours de suivi des performances",
                "En cours de gestion des problèmes",
                "En phase de maintenance",
                "En phase de clôture",
                "En cours de revue client",
                "En phase de formation" ]),
            'taux_horaire' => fake()->randomFloat(2, 50, 500),
            'id_domaine' => fake()->numberBetween(1, 4),
            'id_chef_projet' => \App\Models\Intervenant::factory()->create(),
            'id_client' => fake()->numberBetween(1, 12)
        ];
    }
}
