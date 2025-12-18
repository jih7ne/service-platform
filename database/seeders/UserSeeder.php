<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Professeurs (Intervenants)
        $professeurs = [
            [
                'nom' => 'Martin',
                'prenom' => 'Sophie',
                'email' => 'sophie.martin@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0612345678',
                'typeUtilisateur' => 'intervenant',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ],
            [
                'nom' => 'Dubois',
                'prenom' => 'Pierre',
                'email' => 'pierre.dubois@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0623456789',
                'typeUtilisateur' => 'intervenant',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ],
            [
                'nom' => 'Bernard',
                'prenom' => 'Marie',
                'email' => 'marie.bernard@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0634567890',
                'typeUtilisateur' => 'intervenant',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ]
        ];

        // Élèves (Clients)
        $eleves = [
            [
                'nom' => 'Petit',
                'prenom' => 'Lucas',
                'email' => 'lucas.petit@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0645678901',
                'typeUtilisateur' => 'client',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ],
            [
                'nom' => 'Durand',
                'prenom' => 'Emma',
                'email' => 'emma.durand@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0656789012',
                'typeUtilisateur' => 'client',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ],
            [
                'nom' => 'Leroy',
                'prenom' => 'Hugo',
                'email' => 'hugo.leroy@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0667890123',
                'typeUtilisateur' => 'client',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ],
            [
                'nom' => 'Moreau',
                'prenom' => 'Chloé',
                'email' => 'chloe.moreau@email.com',
                'password' => Hash::make('123456789'),
                'telephone' => '0678901234',
                'typeUtilisateur' => 'client',
                'statutCompte' => 'actif',
                'dateCreation' => now(),
                'photo' => null
            ]
        ];

        // Insérer les professeurs
        foreach ($professeurs as $professeur) {
            DB::table('utilisateurs')->insert($professeur);
        }

        // Insérer les élèves
        foreach ($eleves as $eleve) {
            DB::table('utilisateurs')->insert($eleve);
        }

        // Ajouter les localisations pour les utilisateurs
        $localisations = [
            ['idUser' => 4, 'adresse' => '15 Rue des Écoles', 'ville' => 'Paris', 'codePostal' => '75005'],
            ['idUser' => 5, 'adresse' => '23 Avenue Foch', 'ville' => 'Paris', 'codePostal' => '75116'],
            ['idUser' => 6, 'adresse' => '8 Rue Victor Hugo', 'ville' => 'Lyon', 'codePostal' => '69002'],
            ['idUser' => 7, 'adresse' => '45 Boulevard Gambetta', 'ville' => 'Bordeaux', 'codePostal' => '33000'],
        ];

        foreach ($localisations as $localisation) {
            DB::table('localisations')->insert($localisation);
        }

        $this->command->info('Utilisateurs et localisations créés avec succès!');
    }
}
