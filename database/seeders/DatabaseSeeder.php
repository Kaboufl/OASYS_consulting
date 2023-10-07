<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Intervenant;
use App\Models\Admin;

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
        $intervenant->email = 'mw3pumat8@gmail.com';
        $intervenant->password = \Hash::make('7putoqte');
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
        
    }
}
