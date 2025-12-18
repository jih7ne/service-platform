<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Localisation;
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
        // Créer des clients de test avec leurs adresses
        for ($i = 1; $i <= 5; $i++) {
            $user = Utilisateur::create([
                'nom' => 'Client' . $i,
                'prenom' => 'Test',
                'email' => 'client' . $i . '@test.com',
                'password' => Hash::make('password'),
                'telephone' => '0612345' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'role' => 'client',
                'statut' => 'actif',
                'dateNaissance' => '1990-01-01',
            ]);

            // Ajouter 1-2 adresses par client
            $addresses = [
                ['adresse' => 'Rue Mohamed ' . $i, 'ville' => 'Casablanca'],
                ['adresse' => 'Avenue Hassan ' . $i, 'ville' => 'Rabat']
            ];
            
            $addressCount = ($i <= 2) ? 2 : 1; // Les 2 premiers clients ont 2 adresses
            
            for ($j = 0; $j < $addressCount; $j++) {
                Localisation::create([
                    'idUser' => $user->idUser,
                    'adresse' => $addresses[$j]['adresse'],
                    'ville' => $addresses[$j]['ville'],
                    'latitude' => 33.5731 + ($i * 0.01) + ($j * 0.005), // Coordonnées fictives pour Casablanca/Rabat
                    'longitude' => -7.5898 + ($i * 0.01) + ($j * 0.005),
                ]);
            }
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
                'dateNaissance' => '1985-05-15',
            ]);

            // Ajouter une adresse pour chaque babysitter
            Localisation::create([
                'idUser' => $user->idUser,
                'adresse' => 'Boulevard Babysitter ' . $i,
                'ville' => 'Marrakech',
                'latitude' => 31.6295 + ($i * 0.01), // Coordonnées fictives pour Marrakech
                'longitude' => -7.9811 + ($i * 0.01),
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
                'dateNaissance' => '1978-03-20',
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
                'CIN' => 'AB123456',
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
                'dateNaissance' => '1975-07-10',
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
            'statut' => 'suspendue',
            'dateNaissance' => '1988-12-25',
        ]);

        $this->command->info('✅ Utilisateurs de test créés avec succès !');
    }
}