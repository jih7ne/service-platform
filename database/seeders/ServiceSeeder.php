<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shared\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // On utilise firstOrCreate pour ne pas créer de doublons si on lance la commande 2 fois
        
        // 1. Service Soutien Scolaire
        Service::firstOrCreate(
            ['nomService' => 'Soutien Scolaire'], 
            [
                'description' => 'Cours particuliers, aide aux devoirs et préparation aux examens.',
                
            ]
        );

        // 2. Service Babysitting
        Service::firstOrCreate(
            ['nomService' => 'Babysitting'], 
            [
                'description' => 'Garde d\'enfants ponctuelle ou régulière.',
                
            ]
        );

        // 3. Service Pet Keeping
        Service::firstOrCreate(
            ['nomService' => 'Pet Keeping'], 
            [
                'description' => 'Garde d\'animaux, promenades et visites à domicile.',
                
            ]
        );
        
        $this->command->info('Les 3 services ont été initialisés correctement !');
    }
}