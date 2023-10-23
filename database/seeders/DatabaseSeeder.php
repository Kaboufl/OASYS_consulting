<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Intervenant;
use App\Models\Prestataire;
use App\Models\Admin;
use App\Models\Domaine;
use App\Models\Projet;
use App\Models\Client;
use Database\Factories\PrestatairesFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        

        $intervenant = new Intervenant;
        
        $intervenant->nom = 'OASYS';
        $intervenant->prenom = 'Admin';
        $intervenant->email = 'admin@oasys-consulting.com';
        $intervenant->password = \Hash::make('admin');
        $intervenant->prestataire = false;
        
        $intervenant->save();
        
        $admin = new Admin;
        $admin->id_intervenant = $intervenant->id;
        
        $admin->save();
        
        $intervenant = new Intervenant;
        
        $intervenant->nom = 'test';
        $intervenant->prenom = 'test';
        $intervenant->email = 'test@test.com';
        $intervenant->password = \Hash::make('test');
        $intervenant->prestataire = false;

        $intervenant->save();

        $domaine = new Domaine;
        $domaine->libelle = "Formation";
        $domaine->save();

        $domaine = new Domaine;
        $domaine->libelle = "Systèmes & réseaux";
        $domaine->save();

        $domaine = new Domaine;
        $domaine->libelle = "Développement";
        $domaine->save();

        $domaine = new Domaine;
        $domaine->libelle = "Infogérance";
        $domaine->save();


        Prestataire::factory(5)->create();

        Intervenant::factory(10)->create();

        Client::factory(12)->create();

        Projet::factory(8)->create();
        
    }
}
