<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemandesSeeder extends Seeder
{
    public function run(): void
    {
        // Services professionnels pour le tutorat
        $servicesProf = [
            [
                'matiere_id' => 1,
                'niveau_id' => 1,
                'type_service' => 'standard',
                'montant_total' => 25.00,
                'duree' => 60,
                'description' => 'Soutien en mathématiques niveau primaire'
            ],
            [
                'matiere_id' => 2,
                'niveau_id' => 2,
                'type_service' => 'standard',
                'montant_total' => 30.00,
                'duree' => 60,
                'description' => 'Soutien en français niveau collège'
            ],
            [
                'matiere_id' => 3,
                'niveau_id' => 3,
                'type_service' => 'standard',
                'montant_total' => 35.00,
                'duree' => 60,
                'description' => 'Soutien en physique niveau lycée'
            ]
        ];

        // Insérer les services professionnels
        foreach ($servicesProf as $service) {
            DB::table('services_prof')->insert($service);
        }

        // Demandes d'intervention
        $demandes = [
            [
                'idClient' => 4, // Lucas Petit
                'idIntervenant' => 1, // Sophie Martin
                'idService' => 1, // Soutien Scolaire
                'dateDemande' => now()->subDays(10),
                'dateSouhaitee' => now()->subDays(5),
                'heureDebut' => '15:00:00',
                'heureFin' => '16:00:00',
                'statut' => 'terminée',
                'note_speciales' => 'Besoin d\'aide en géométrie'
            ],
            [
                'idClient' => 5, // Emma Durand
                'idIntervenant' => 2, // Pierre Dubois
                'idService' => 1, // Soutien Scolaire
                'dateDemande' => now()->subDays(8),
                'dateSouhaitee' => now()->subDays(3),
                'heureDebut' => '16:30:00',
                'heureFin' => '17:30:00',
                'statut' => 'validée',
                'note_speciales' => 'Révision pour le brevet'
            ],
            [
                'idClient' => 6, // Hugo Leroy
                'idIntervenant' => 3, // Marie Bernard
                'idService' => 1, // Soutien Scolaire
                'dateDemande' => now()->subDays(5),
                'dateSouhaitee' => now()->addDays(2),
                'heureDebut' => '14:00:00',
                'heureFin' => '15:00:00',
                'statut' => 'en_attente',
                'note_speciales' => 'Difficultés en algèbre'
            ],
            [
                'idClient' => 7, // Chloé Moreau
                'idIntervenant' => 1, // Sophie Martin
                'idService' => 1, // Soutien Scolaire
                'dateDemande' => now()->subDays(15),
                'dateSouhaitee' => now()->subDays(10),
                'heureDebut' => '10:00:00',
                'heureFin' => '11:00:00',
                'statut' => 'refusée',
                'note_speciales' => 'Disponibilité incompatible'
            ]
        ];

        // Insérer les demandes
        foreach ($demandes as $demande) {
            DB::table('demandes_intervention')->insert($demande);
        }

        // Associer les services professionnels aux demandes
        $demandesProf = [
            ['demande_id' => 1, 'service_prof_id' => 1],
            ['demande_id' => 2, 'service_prof_id' => 2],
            ['demande_id' => 3, 'service_prof_id' => 3],
            ['demande_id' => 4, 'service_prof_id' => 1],
        ];

        foreach ($demandesProf as $demandeProf) {
            DB::table('demandes_prof')->insert($demandeProf);
        }

        $this->command->info('Demandes d\'intervention créées avec succès!');
    }
}
