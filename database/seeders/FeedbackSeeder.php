<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        // Feedbacks pour les demandes terminées
        $feedbacks = [
            [
                'idAuteur' => 1, // Sophie Martin (professeur)
                'idCible' => 4, // Lucas Petit (élève)
                'typeAuteur' => 'intervenant',
                'commentaire' => 'Excellent élève, très motivé et attentif. Les progrès sont visibles.',
                'credibilite' => 5,
                'sympathie' => 4,
                'ponctualite' => 5,
                'proprete' => 4,
                'qualiteTravail' => 5,
                'moyenne' => 4.60, // (5+4+5+4+5)/5
                'estVisible' => true,
                'dateCreation' => now()->subDays(4),
                'idDemande' => 1,
                'idService' => 1,
            ],
            [
                'idAuteur' => 4, // Lucas Petit (élève)
                'idCible' => 1, // Sophie Martin (professeur)
                'typeAuteur' => 'client',
                'commentaire' => 'Professeur très patient et pédagogue. Lucas a beaucoup progressé.',
                'credibilite' => 5,
                'sympathie' => 5,
                'ponctualite' => 5,
                'proprete' => 5,
                'qualiteTravail' => 5,
                'moyenne' => 5.00, // (5+5+5+5+5)/5
                'estVisible' => true,
                'dateCreation' => now()->subDays(4),
                'idDemande' => 1,
                'idService' => 1,
            ]
        ];

        // Insérer les feedbacks
        foreach ($feedbacks as $feedback) {
            DB::table('feedbacks')->insert($feedback);
        }

        $this->command->info('Feedbacks créés avec succès!');
    }
}
