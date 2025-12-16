<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PetKeeping\PetKeepingSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Services de base
            ServiceSeeder::class,
            
            // Admin
            AdminSeeder::class,
            
            // Matières et niveaux pour soutien scolaire
            MatieresNiveauxSeeder::class,
            
            // PetKeeping (contient users, intervenants, services)
            PetKeepingSeeder::class,
        ]);
        
        $this->command->info('✅ Tous les seeders ont été exécutés avec succès !');
    }
}