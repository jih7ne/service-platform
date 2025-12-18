<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnfantsSeeder extends Seeder
{
    public function run(): void
    {
        // Enfants créés via les réservations babysitting
        $enfants = [
            [
                'nom' => 'Martin',
                'prenom' => 'Léo',
                'sexe' => 'garcon',
                'dateNaissance' => '2020-05-15',
                'age' => 3,
                'idIntervenant' => 6, // Babysitter 1
                'id_client' => 1, // Client 1
                'allergies' => 'Aucune',
                'notes_speciales' => 'Aime les jeux de construction',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Dubois',
                'prenom' => 'Emma',
                'sexe' => 'fille',
                'dateNaissance' => '2019-08-22',
                'age' => 4,
                'idIntervenant' => 7, // Babysitter 2
                'id_client' => 2, // Client 2
                'allergies' => 'Arachides',
                'notes_speciales' => 'Timide au début',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Bernard',
                'prenom' => 'Louis',
                'sexe' => 'garcon',
                'dateNaissance' => '2021-03-10',
                'age' => 2,
                'idIntervenant' => 8, // Babysitter 3
                'id_client' => 3, // Client 3
                'allergies' => 'Pollens',
                'notes_speciales' => 'Très énergique',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Petit',
                'prenom' => 'Chloé',
                'sexe' => 'fille',
                'dateNaissance' => '2020-11-28',
                'age' => 3,
                'idIntervenant' => 6, // Babysitter 1
                'id_client' => 4, // Client 4
                'allergies' => 'Aucune',
                'notes_speciales' => 'Adore les dessins animés',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Durand',
                'prenom' => 'Hugo',
                'sexe' => 'garcon',
                'dateNaissance' => '2019-07-05',
                'age' => 4,
                'idIntervenant' => 7, // Babysitter 2
                'id_client' => 5, // Client 5
                'allergies' => 'Lactose',
                'notes_speciales' => 'Aime les livres',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insérer les enfants
        foreach ($enfants as $enfant) {
            DB::table('enfants')->insert($enfant);
        }

        $this->command->info('Enfants créés avec succès!');
    }
}
