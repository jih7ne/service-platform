<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Babysitting\Babysitter;
use App\Models\SoutienScolaire\Professeur;
use App\Models\PetKeeping\PetKeeper;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des clients de test
        for ($i = 1; $i <= 5; $i++) {
            Utilisateur::create([
                'nom' => 'Client' . $i,
                'prenom' => 'Test',
                'email' => 'client' . $i . '@test.com',
                'password' => Hash::make('password'),
                'telephone' => '0612345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => 'client',
                'statut' => 'actif',
                'ville' => 'Casablanca',
            ]);
        }

        // Créer des babysitters
        for ($i = 1; $i <= 3; $i++) {
            $user = Utilisateur::create([
                'nom' => 'Babysitter' . $i,
                'prenom' => 'Test',
                'email' => 'babysitter' . $i . '@test.com',
                'password' => Hash::make('password'),
                'telephone' => '0622345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => 'intervenant',
                'statut' => 'actif',
                'ville' => 'Rabat',
            ]);

            $intervenant = Intervenant::create([
                'IdIntervenant' => $user->idUser,
                'statut' => 'VALIDE',
            ]);

            Babysitter::create([
                'idBabysitter' => $intervenant->IdIntervenant,
                'prixHeure' => 50 + ($i * 10),
                'expAnnee' => $i * 2,
                'langues' => json_encode(['Français', 'Arabe']),
            ]);
        }

        // Créer des professeurs
        for ($i = 1; $i <= 3; $i++) {
            $user = Utilisateur::create([
                'nom' => 'Professeur' . $i,
                'prenom' => 'Test',
                'email' => 'professeur' . $i . '@test.com',
                'password' => Hash::make('password'),
                'telephone' => '0632345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => 'intervenant',
                'statut' => 'actif',
                'ville' => 'Marrakech',
            ]);

            $intervenant = Intervenant::create([
                'IdIntervenant' => $user->idUser,
                'statut' => 'VALIDE',
            ]);

            Professeur::create([
                'intervenant_id' => $intervenant->IdIntervenant,
                'surnom' => 'Prof' . $i,
                'niveau_etudes' => 'Master',
                'biographie' => 'Professeur expérimenté',
            ]);
        }

        // Créer des gardiens d'animaux
        for ($i = 1; $i <= 2; $i++) {
            $user = Utilisateur::create([
                'nom' => 'PetKeeper' . $i,
                'prenom' => 'Test',
                'email' => 'petkeeper' . $i . '@test.com',
                'password' => Hash::make('password'),
                'telephone' => '0642345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => 'intervenant',
                'statut' => 'actif',
                'ville' => 'Tanger',
            ]);

            $intervenant = Intervenant::create([
                'IdIntervenant' => $user->idUser,
                'statut' => 'VALIDE',
            ]);

            PetKeeper::create([
                'idPetKeeper' => $intervenant->IdIntervenant,
                'specialite' => 'Chiens et chats',
                'nombres_services_demandes' => $i * 5,
            ]);
        }

        // Créer un utilisateur suspendu pour test
        $suspendedUser = Utilisateur::create([
            'nom' => 'Suspendu',
            'prenom' => 'Compte',
            'email' => 'suspendu@test.com',
            'password' => Hash::make('password'),
            'telephone' => '0699999999',
            'role' => 'client',
            'statut' => 'suspendu',
            'ville' => 'Fès',
        ]);

        $this->command->info('✅ Utilisateurs de test créés avec succès !');
    }
}