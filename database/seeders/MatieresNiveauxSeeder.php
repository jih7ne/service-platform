<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoutienScolaire\Matiere;
use App\Models\SoutienScolaire\Niveau;

class MatieresNiveauxSeeder extends Seeder
{
    public function run(): void
    {
        // Matières
        $matieres = [
            ['nom_matiere' => 'Mathématiques', 'description' => 'Cours de mathématiques'],
            ['nom_matiere' => 'Physique-Chimie', 'description' => 'Cours de physique et chimie'],
            ['nom_matiere' => 'Français', 'description' => 'Cours de français'],
            ['nom_matiere' => 'Anglais', 'description' => 'Cours d\'anglais'],
            ['nom_matiere' => 'Arabe', 'description' => 'Cours d\'arabe'],
            ['nom_matiere' => 'SVT', 'description' => 'Sciences de la vie et de la terre'],
        ];

        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
        }

        // Niveaux
        $niveaux = [
            ['nom_niveau' => 'Primaire', 'description' => 'Niveau primaire'],
            ['nom_niveau' => 'Collège', 'description' => 'Niveau collège'],
            ['nom_niveau' => 'Lycée', 'description' => 'Niveau lycée'],
            ['nom_niveau' => 'Université', 'description' => 'Niveau universitaire'],
        ];

        foreach ($niveaux as $niveau) {
            Niveau::create($niveau);
        }
    }
}