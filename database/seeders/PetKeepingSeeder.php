<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetKeepingSeeder extends Seeder
{
    private $moroccanCities = [
        'Casablanca', 'Rabat', 'Fès', 'Marrakech', 'Tanger', 
        'Meknès', 'Agadir', 'Oujda', 'Kénitra', 'Tétouan',
        'Safi', 'El Jadida', 'Nador', 'Settat', 'Beni Mellal',
        'Khémisset', 'Larache', 'Khouribga', 'Berkane', 'Taourirt'
    ];

    private $weekDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    
    private $animalNames = [
        'Bella', 'Max', 'Charlie', 'Luna', 'Lucy', 'Cooper', 'Daisy', 'Milo', 'Bailey', 'Sadie',
        'Rocky', 'Chloe', 'Buddy', 'Lola', 'Zoe', 'Oscar', 'Molly', 'Tucker', 'Ruby', 'Leo'
    ];
    
    private $animalSpecies = ['Chien', 'Chat', 'Oiseau', 'Lapin', 'Hamster', 'Cochon d\'Inde', 'Poisson'];
    
    private $dogBreeds = ['Labrador', 'Golden Retriever', 'Berger Allemand', 'Beagle', 'Bulldog', 'Caniche'];
    private $catBreeds = ['Siamois', 'Persan', 'Main Coon', 'Bengal', 'Sphynx', 'Européen'];
    private $birdBreeds = ['Perroquet', 'Canari', 'Perruche', 'Cacatoès', 'Ara'];
    private $rabbitBreeds = ['Nain', 'Angora', 'Bélier', 'Rex'];
    
    private $vaccinationStatuses = ['ONCE', 'RECURRING', 'NEVER', 'MULTIPLE'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Starting step-by-step seeding...\n\n";
        
        // STEP 1: Create services
        echo "Step 1: Creating services...\n";
        $serviceIds = $this->createServices();
        
        // STEP 2: Create admin
        echo "\nStep 2: Creating admin...\n";
        $adminId = $this->createAdmin();
        
        // STEP 3: Create users (clients and intervenants)
        echo "\nStep 3: Creating users...\n";
        list($clientUserIds, $intervenantUserIds) = $this->createUsers($adminId);
        
        // STEP 4: Create intervenants
        echo "\nStep 4: Creating intervenants...\n";
        $intervenantIds = $this->createIntervenants($intervenantUserIds, $adminId);
        
        // STEP 5: Create localisations for all users
        echo "\nStep 5: Creating localisations...\n";
        $this->createLocalisations(array_merge($clientUserIds, $intervenantUserIds));
        
        // STEP 6: Create OffreService (link intervenants to services)
        echo "\nStep 6: Creating OffreService...\n";
        $this->createOffreService($intervenantIds, $serviceIds);
        
        // STEP 7: Create disponibilites for intervenants
        echo "\nStep 7: Creating disponibilites...\n";
        $this->createDisponibilites($intervenantIds);
        
        // STEP 8: Create petkeepers table entries
        echo "\nStep 8: Creating petkeepers...\n";
        $this->createPetkeepers($intervenantIds);
        
        // STEP 9: Create demandes_intervention from clients to intervenants
        echo "\nStep 9: Creating demandes_intervention...\n";
        $demandeIds = $this->createDemandesIntervention($clientUserIds, $intervenantIds, $serviceIds);
        
        // STEP 10: Create animals for clients
        echo "\nStep 10: Creating animals...\n";
        $animalIds = $this->createAnimals($clientUserIds, $demandeIds);
        
        // STEP 11: Link animals to demands
        echo "\nStep 11: Linking animals to demands...\n";
        $this->createAnimalDemandeLinks($demandeIds, $animalIds);
        
        // STEP 12: Create invoices for demands
        echo "\nStep 12: Creating invoices...\n";
        $this->createInvoices($demandeIds);
        
        // STEP 13: Create feedbacks between clients and intervenants
        echo "\nStep 13: Creating feedbacks...\n";
        $this->createFeedbacks($clientUserIds, $intervenantUserIds, $demandeIds);
        
        // STEP 14: Create petkeeping services
        echo "\nStep 14: Creating petkeeping services...\n";
        $this->createPetkeepingServices($intervenantIds);
        
        echo "\n=== All steps completed successfully! ===\n";
    }
    
    private function createServices()
    {
        $services = [
            ['nomService' => 'Pet Boarding', 'description' => 'Overnight care'],
            ['nomService' => 'Pet Sitting', 'description' => 'In-home care'],
            ['nomService' => 'Dog Walking', 'description' => 'Daily walks'],
            ['nomService' => 'Pet Grooming', 'description' => 'Bathing & grooming'],
            ['nomService' => 'Training', 'description' => 'Obedience training'],
            ['nomService' => 'Drop-in Visits', 'description' => 'Short check-ins'],
        ];
        
        foreach ($services as $service) {
            $service['created_at'] = now();
            $service['updated_at'] = now();
        }
        
        // Insert and get all services with their IDs
        DB::table('services')->insert($services);
        $servicesData = DB::table('services')->get()->toArray();
        
        echo "✓ Created " . count($servicesData) . " services\n";
        
        return $servicesData;
    }
    
    private function createAdmin()
    {
        // Check if admin exists
        $admin = DB::table('admins')->where('emailAdmin', 'nyirendaamos1@gmail.com')->first();
        
        if (!$admin) {
            $adminId = DB::table('admins')->insertGetId([
                'emailAdmin' => 'nyirendaamos1@gmail.com',
                'passwordAdmin' => Hash::make('admin123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "✓ Created new admin with ID: {$adminId}\n";
        } else {
            $adminId = $admin->id;
            echo "✓ Admin already exists with ID: {$adminId}\n";
        }
        
        return $adminId;
    }
    
    private function createUsers($adminId)
    {
        $users = [
            // 4 Intervenants
            [
                'nom' => 'Johnson', 'prenom' => 'Sarah', 'email' => 'nyirendaamos1@gmail.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345678',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.9,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah',
                'nbrAvis' => 127, 'dateNaissance' => '1985-05-15', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Rodriguez', 'prenom' => 'Emily', 'email' => 'emily.rodriguez@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345679',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 5.0,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Emily',
                'nbrAvis' => 203, 'dateNaissance' => '1988-03-10', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Martinez', 'prenom' => 'David', 'email' => 'david.martinez@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345680',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.7,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=David',
                'nbrAvis' => 156, 'dateNaissance' => '1992-11-30', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Lee', 'prenom' => 'Jennifer', 'email' => 'jennifer.lee@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345681',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.9,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jennifer',
                'nbrAvis' => 178, 'dateNaissance' => '1987-07-18', 'idAdmin' => $adminId,
            ],
            // 2 Clients (more clients for variety)
            [
                'nom' => 'Chen', 'prenom' => 'Michael', 'email' => 'nyirendaamos22@gmail.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345682',
                'statut' => 'actif', 'role' => 'client', 'note' => 4.8,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Michael',
                'nbrAvis' => 89, 'dateNaissance' => '1990-08-22', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Benali', 'prenom' => 'Fatima', 'email' => 'fatima.benali@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345683',
                'statut' => 'actif', 'role' => 'client', 'note' => 4.9,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Fatima',
                'nbrAvis' => 45, 'dateNaissance' => '1993-04-15', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Alaoui', 'prenom' => 'Karim', 'email' => 'karim.alaoui@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+212612345684',
                'statut' => 'actif', 'role' => 'client', 'note' => 4.7,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Karim',
                'nbrAvis' => 32, 'dateNaissance' => '1988-09-10', 'idAdmin' => $adminId,
            ],
        ];
        
        // Add timestamps
        foreach ($users as &$user) {
            $user['created_at'] = now();
            $user['updated_at'] = now();
        }
        
        // Clear table and insert new users
        DB::table('utilisateurs')->truncate();
        DB::table('utilisateurs')->insert($users);
        
        // Get intervenant user IDs
        $intervenantUserIds = DB::table('utilisateurs')
            ->where('role', 'intervenant')
            ->orderBy('idUser', 'asc')
            ->pluck('idUser')
            ->toArray();
            
        // Get client user IDs
        $clientUserIds = DB::table('utilisateurs')
            ->where('role', 'client')
            ->orderBy('idUser', 'asc')
            ->pluck('idUser')
            ->toArray();
            
        echo "✓ Created " . count($users) . " users\n";
        echo "  - Intervenants: " . count($intervenantUserIds) . " users\n";
        echo "  - Clients: " . count($clientUserIds) . " users\n";
        
        return [$clientUserIds, $intervenantUserIds];
    }
    
    private function createIntervenants($intervenantUserIds, $adminId)
    {
        DB::table('intervenants')->truncate();
        
        $intervenants = [];
        
        foreach ($intervenantUserIds as $userId) {
            $intervenants[] = [
                'statut' => 'VALIDE',
                'IdIntervenant' => $userId,
                'idAdmin' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('intervenants')->insert($intervenants);
        
        // Get intervenant IDs (should be same as user IDs for IdIntervenant)
        $intervenantIds = DB::table('intervenants')->pluck('IdIntervenant')->toArray();
        
        echo "✓ Created " . count($intervenants) . " intervenants\n";
        
        return $intervenantIds;
    }
    
    private function createLocalisations($userIds)
    {
        DB::table('localisations')->truncate();
        
        $localisations = [];
        $coordinates = [
            // Casablanca coordinates
            ['lat' => 33.573110, 'lng' => -7.589843],
            // Rabat coordinates
            ['lat' => 33.971588, 'lng' => -6.849813],
            // Marrakech coordinates
            ['lat' => 31.629472, 'lng' => -7.981084],
            // Tanger coordinates
            ['lat' => 35.759465, 'lng' => -5.833954],
            // Fès coordinates
            ['lat' => 34.018125, 'lng' => -5.007845],
            // Agadir coordinates
            ['lat' => 30.427755, 'lng' => -9.598107],
        ];
        
        foreach ($userIds as $index => $userId) {
            $cityIndex = $index % count($this->moroccanCities);
            $coordIndex = $index % count($coordinates);
            
            $localisations[] = [
                'latitude' => $coordinates[$coordIndex]['lat'] + (rand(-100, 100) / 10000),
                'longitude' => $coordinates[$coordIndex]['lng'] + (rand(-100, 100) / 10000),
                'ville' => $this->moroccanCities[$cityIndex],
                'adresse' => 'Rue ' . ($index + 1) . ', Quartier Centre',
                'idUser' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('localisations')->insert($localisations);
        echo "✓ Created " . count($localisations) . " localisations\n";
    }
    
    private function createOffreService($intervenantIds, $serviceIds)
    {
        DB::table('offres_services')->truncate();
        
        $offres = [];
        
        // Map intervenants to services (each intervenant offers 2-3 services)
        $serviceMapping = [
            // Sarah Johnson offers services 1, 2, 3
            [$serviceIds[0], $serviceIds[1], $serviceIds[2]],
            // Emily Rodriguez offers services 0, 4, 5
            [$serviceIds[0], $serviceIds[4], $serviceIds[5]],
            // David Martinez offers services 1, 3
            [$serviceIds[1], $serviceIds[3]],
            // Jennifer Lee offers services 2, 4
            [$serviceIds[2], $serviceIds[4]],
        ];
        
        foreach ($intervenantIds as $index => $intervenantId) {
            if (isset($serviceMapping[$index])) {
                foreach ($serviceMapping[$index] as $serviceId) {
                    $offres[] = [
                        'idIntervenant' => $intervenantId,
                        'idService' => $serviceId,
                    ];
                }
            }
        }
        
        DB::table('offres_services')->insert($offres);
        echo "✓ Created " . count($offres) . " service offerings\n";
    }
    
    private function createDisponibilites($intervenantIds)
    {
        DB::table('disponibilites')->truncate();
        
        $disponibilites = [];
        
        foreach ($intervenantIds as $intervenantId) {
            // Create regular weekly availability (3-4 days per week)
            $daysCount = rand(3, 5);
            $selectedDays = array_rand($this->weekDays, $daysCount);
            
            if (!is_array($selectedDays)) {
                $selectedDays = [$selectedDays];
            }
            
            foreach ($selectedDays as $dayIndex) {
                $day = $this->weekDays[$dayIndex];
                
                $disponibilites[] = [
                    'heureDebut' => $this->randomTime(8, 10),
                    'heureFin' => $this->randomTime(16, 20),
                    'jourSemaine' => $day,
                    'est_reccurent' => 1,
                    'date_specifique' => null,
                    'idIntervenant' => $intervenantId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Add one specific date availability
            $disponibilites[] = [
                'heureDebut' => $this->randomTime(9, 12),
                'heureFin' => $this->randomTime(15, 18),
                'jourSemaine' => 'Samedi',
                'est_reccurent' => 0,
                'date_specifique' => now()->addDays(rand(7, 30))->format('Y-m-d'),
                'idIntervenant' => $intervenantId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('disponibilites')->insert($disponibilites);
        echo "✓ Created " . count($disponibilites) . " disponibilites\n";
    }
    
    private function createPetkeepers($intervenantIds)
    {
        DB::table('petkeepers')->truncate();
        
        $petkeepers = [];
        $specialites = [
            'Spécialiste chiens', 'Spécialiste chats', 'Soins petits animaux',
            'Garde longue durée', 'Soins spéciaux', 'Entraîneur canin'
        ];
        
        foreach ($intervenantIds as $index => $intervenantId) {
            $petkeepers[] = [
                'idPetKeeper' => $intervenantId,
                'nombres_services_demandes' => rand(5, 50),
                'years_of_experience' => 5,
                'specialite' => $specialites[$index % count($specialites)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('petkeepers')->insert($petkeepers);
        echo "✓ Created " . count($petkeepers) . " petkeepers\n";
    }
    
    private function createDemandesIntervention($clientUserIds, $intervenantIds, $serviceIds)
    {
        DB::table('demandes_intervention')->truncate();
        
        $demandes = [];
        $statuses = ['validée', 'en_attente', 'refusée', 'annulée'];
        $reasons = [
            'Pas disponible à cette date',
            'Urgence personnelle',
            'Conflit d\'horaire',
            'Changement de plan'
        ];
        
        $demandeIds = [];
        
        for ($i = 0; $i < 12; $i++) {
            $clientId = $clientUserIds[array_rand($clientUserIds)];
            $intervenantId = $intervenantIds[array_rand($intervenantIds)];
            $serviceId = $serviceIds[array_rand($serviceIds)];
            $status = $statuses[array_rand($statuses)];
            
            $demande = [
                'dateDemande' => now()->subDays(rand(0, 30)),
                'dateSouhaitee' => now()->addDays(rand(1, 60))->format('Y-m-d'),
                'heureDebut' => $this->randomTime(8, 12),
                'heureFin' => $this->randomTime(13, 18),
                'statut' => $status,
                'raisonAnnulation' => ($status == 'annulée' || $status == 'refusée') 
                    ? $reasons[array_rand($reasons)] 
                    : null,
                'lieu' => 'Domicile client',
                'note_speciales' => rand(0, 1) ? 'Animal nécessitant des soins particuliers' : null,
                'idIntervenant' => $intervenantId,
                'idClient' => $clientId,
                'idService' => $serviceId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $demandes[] = $demande;
        }
        
        DB::table('demandes_intervention')->insert($demandes);
        
        // Get the created demande IDs
        $demandeIds = DB::table('demandes_intervention')->pluck('idDemande')->toArray();
        
        echo "✓ Created " . count($demandes) . " demandes d'intervention\n";
        
        return $demandeIds;
    }
    
    private function createAnimals($clientUserIds, $demandeIds)
    {
        DB::table('animals')->truncate();
        
        $animals = [];
        $animalIds = [];
        
        // Create 2-3 animals per client
        foreach ($clientUserIds as $clientId) {
            $numAnimals = rand(1, 3);
            
            for ($i = 0; $i < $numAnimals; $i++) {
                $species = $this->animalSpecies[array_rand($this->animalSpecies)];
                list($race, $poidsRange, $tailleRange, $ageRange) = $this->getAnimalSpecs($species);
                
                $animal = [
                    'idClient' => $clientId,
                    'idDemande' => $demandeIds[array_rand($demandeIds)], // Link to a random demand
                    'nomAnimal' => $this->animalNames[array_rand($this->animalNames)],
                    'poids' => rand($poidsRange[0], $poidsRange[1]) + (rand(0, 99) / 100),
                    'taille' => rand($tailleRange[0], $tailleRange[1]) + (rand(0, 99) / 100),
                    'age' => rand($ageRange[0], $ageRange[1]),
                    'sexe' => rand(0, 1) ? 'M' : 'F',
                    'race' => $race,
                    'espece' => $species,
                    'statutVaccination' => $this->vaccinationStatuses[array_rand($this->vaccinationStatuses)],
                    'note_comportementale' => $this->generateBehaviorNote(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $animals[] = $animal;
            }
        }
        
        DB::table('animals')->insert($animals);
        
        // Get the created animal IDs
        $animalIds = DB::table('animals')->pluck('idAnimale')->toArray();
        
        echo "✓ Created " . count($animals) . " animals\n";
        
        return $animalIds;
    }
    
    private function createAnimalDemandeLinks($demandeIds, $animalIds)
    {
        DB::table('animal_demande')->truncate();
        
        $links = [];
        
        // For each demand, link 1-2 animals
        foreach ($demandeIds as $demandeId) {
            $numAnimals = rand(1, 2);
            $selectedAnimals = array_rand($animalIds, min($numAnimals, count($animalIds)));
            
            if (!is_array($selectedAnimals)) {
                $selectedAnimals = [$selectedAnimals];
            }
            
            foreach ($selectedAnimals as $animalIndex) {
                $links[] = [
                    'idDemande' => $demandeId,
                    'idAnimal' => $animalIds[$animalIndex],
                ];
            }
        }
        
        DB::table('animal_demande')->insert($links);
        echo "✓ Created " . count($links) . " animal-demande links\n";
    }
    
    private function createInvoices($demandeIds)
    {
        DB::table('factures')->truncate();
        
        $invoices = [];
        $invoiceNumber = 1000;
        
        // Create invoices only for validated demands
        $validatedDemandes = array_slice($demandeIds, 0, 8); // Assume first 8 are validated
        
        foreach ($validatedDemandes as $demandeId) {
            $invoices[] = [
                'montantTotal' => $this->randomDouble(50, 300),
                'numFacture' => $invoiceNumber++,
                'idDemande' => $demandeId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('factures')->insert($invoices);
        echo "✓ Created " . count($invoices) . " invoices\n";
    }
    
    private function createFeedbacks($clientUserIds, $intervenantUserIds, $demandeIds)
    {
        DB::table('feedbacks')->truncate();
        
        $feedbacks = [];
        
        // Create feedbacks from clients to intervenants
        foreach ($clientUserIds as $clientId) {
            $numFeedbacks = rand(1, 3);
            
            for ($i = 0; $i < $numFeedbacks; $i++) {
                $intervenantId = $intervenantUserIds[array_rand($intervenantUserIds)];
                $demandeId = $demandeIds[array_rand($demandeIds)];
                
                // Create good feedback (80% chance) or bad feedback (20% chance)
                $isGoodFeedback = rand(1, 100) <= 80;
                
                $feedbacks[] = [
                    'idAuteur' => $clientId,
                    'idCible' => $intervenantId,
                    'typeAuteur' => 'client',
                    'commentaire' => $isGoodFeedback 
                        ? $this->generateGoodComment() 
                        : $this->generateBadComment(),
                    'credibilite' => $isGoodFeedback ? rand(4, 5) : rand(1, 2),
                    'sympathie' => $isGoodFeedback ? rand(4, 5) : rand(1, 3),
                    'ponctualite' => $isGoodFeedback ? rand(4, 5) : rand(1, 2),
                    'proprete' => $isGoodFeedback ? rand(4, 5) : rand(2, 3),
                    'qualiteTravail' => $isGoodFeedback ? rand(4, 5) : rand(1, 2),
                    'estVisible' => true,
                    'dateAffichage' => now(),
                    'moyenne' => rand(1, 5),
                    'dateCreation' => now(),
                    'idDemande' => $demandeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Create feedbacks from intervenants to clients (less frequent)
        foreach ($intervenantUserIds as $intervenantId) {
            if (rand(0, 1)) { // 50% chance
                $clientId = $clientUserIds[array_rand($clientUserIds)];
                $demandeId = $demandeIds[array_rand($demandeIds)];
                
                $feedbacks[] = [
                    'idAuteur' => $intervenantId,
                    'idCible' => $clientId,
                    'typeAuteur' => 'intervenant',
                    'commentaire' => rand(0, 1) 
                        ? 'Client très agréable, animaux bien éduqués' 
                        : 'Communication facile, paiement ponctuel',
                    'credibilite' => rand(4, 5),
                    'sympathie' => rand(4, 5),
                    'ponctualite' => rand(4, 5),
                    'proprete' => rand(4, 5),
                    'qualiteTravail' => null, // Not applicable for client feedback
                    'estVisible' => true,
                    'dateAffichage' => now(),
                    'moyenne' => rand(1, 5),
                    'dateCreation' => now(),
                    'idDemande' => $demandeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('feedbacks')->insert($feedbacks);
        echo "✓ Created " . count($feedbacks) . " feedbacks\n";
    }
    
    private function createPetkeepingServices($intervenantIds)
    {
        DB::table('petkeeping')->truncate();

        $servicesData = DB::table('services')->get()->toArray();
        
        $petkeepingServices = [];
    
        // Define petkeeping type mapping based on service names
        $petkeepingTypeMapping = [
            'Pet Boarding' => 'PENSION',
            'Pet Sitting' => 'A_DOMICILE',
            'Dog Walking' => 'PROMENADE',
            'Pet Grooming' => 'TOILETTAGE',
            'Training' => 'DRESSAGE',
            'Drop-in Visits' => 'DEPLACEMENT',
        ];
        
        // Map each intervenant to services
        $intervenantServiceMappings = [
            // Sarah Johnson
            0 => [
                ['service_name' => 'Pet Boarding', 'pets' => 'Chien'],
                ['service_name' => 'Pet Sitting', 'pets' => 'Chien'],
            ],
            // Emily Rodriguez
            1 => [
                ['service_name' => 'Pet Sitting', 'pets' => 'Chat'],
                ['service_name' => 'Drop-in Visits', 'pets' => 'Chat'],
            ],
            // David Martinez
            2 => [
                ['service_name' => 'Pet Boarding', 'pets' => 'Chien'],
                ['service_name' => 'Training', 'pets' => 'Oiseau'],
            ],
            // Jennifer Lee
            3 => [
                ['service_name' => 'Dog Walking', 'pets' => 'Reptile'],
                ['service_name' => 'Pet Grooming', 'pets' => 'Chien'],
            ],
        ];
        
        // Create a mapping of service name to ID
        $serviceNameToId = [];
        foreach ($servicesData as $service) {
            $serviceNameToId[$service->nomService] = $service->idService;
        }
        
        foreach ($intervenantServiceMappings as $index => $mappings) {
            if (isset($intervenantIds[$index])) {
                foreach ($mappings as $mapping) {
                    $serviceId = $serviceNameToId[$mapping['service_name']] ?? null;
                    
                    if ($serviceId) {
                        $petkeepingServices[] = [
                            'idPetKeeping' => $serviceId,
                            'idPetKeeper' => $intervenantIds[$index],
                            'categorie_petkeeping' => $petkeepingTypeMapping[$mapping['service_name']],
                            'accepts_aggressive_pets' => rand(0, 1),
                            'accepts_untrained_pets' => rand(0, 1),
                            'vaccination_required' => rand(0, 1),
                            'pet_type' => $mapping['pets'],
                            'payment_criteria' => 'PER_HOUR',
                            'base_price' => $this->randomDouble(20, 60),
                            'note' => rand(1,5),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }
        
        DB::table('petkeeping')->insert($petkeepingServices);
        echo "✓ Created " . count($petkeepingServices) . " petkeeping services\n";
    }
    
    private function getAnimalSpecs($species)
    {
        switch ($species) {
            case 'Chien':
                return [
                    $this->dogBreeds[array_rand($this->dogBreeds)],
                    [5, 40], // poids range in kg
                    [25, 80], // taille range in cm
                    [1, 15]   // age range in years
                ];
            case 'Chat':
                return [
                    $this->catBreeds[array_rand($this->catBreeds)],
                    [3, 8],   // poids
                    [20, 35], // taille
                    [1, 18]   // age
                ];
            case 'Oiseau':
                return [
                    $this->birdBreeds[array_rand($this->birdBreeds)],
                    [0.1, 2], // poids
                    [10, 50], // taille
                    [1, 30]   // age
                ];
            case 'Lapin':
                return [
                    $this->rabbitBreeds[array_rand($this->rabbitBreeds)],
                    [1, 5],   // poids
                    [20, 40], // taille
                    [1, 10]   // age
                ];
            default:
                return [
                    'Standard',
                    [0.1, 3], // poids
                    [5, 30],  // taille
                    [1, 5]    // age
                ];
        }
    }
    
    private function generateBehaviorNote()
    {
        $behaviors = [
            'Très calme et obéissant',
            'Joueur et énergique',
            'Un peu timide au début',
            'Nécessite une approche douce',
            'Sociable avec les autres animaux',
            'A besoin de beaucoup d\'exercice',
            'Très affectueux',
            'Indépendant mais gentil',
            'A peur des bruits forts',
            'Aime les câlins'
        ];
        
        return $behaviors[array_rand($behaviors)];
    }
    
    private function generateGoodComment()
    {
        $comments = [
            'Excellent service! Mon animal était très bien traité.',
            'Très professionnel et attentionné. Je recommande vivement!',
            'Ponctuel et très doux avec les animaux. Parfait!',
            'Communication excellente et soins de qualité.',
            'Mon chien adore ses promenades avec cet intervenant.',
            'Service impeccable, je ferai à nouveau appel à eux.',
            'Très bon rapport qualité-prix, animaux très heureux.',
            'Personne de confiance, je peux partir sereinement.',
            'Soins adaptés aux besoins spécifiques de mon animal.',
            'Très satisfait du service, à recommander sans hésitation.'
        ];
        
        return $comments[array_rand($comments)];
    }
    
    private function generateBadComment()
    {
        $comments = [
            'Retard de 30 minutes sans prévenir.',
            'Pas très attentionné avec mon animal.',
            'Communication difficile, peu de retours.',
            'Le service n\'était pas à la hauteur de mes attentes.',
            'Problème de ponctualité à plusieurs reprises.',
            'Peu d\'interaction avec mon animal pendant la garde.',
            'N\'a pas suivi toutes les instructions données.',
            'Le prix ne correspondait pas au service rendu.',
            'Manque de professionnalisme dans l\'approche.',
            'Mon animal semblait stressé après le service.'
        ];
        
        return $comments[array_rand($comments)];
    }
    
    private function randomTime($startHour, $endHour)
    {
        $hour = rand($startHour, $endHour - 1);
        $minute = rand(0, 1) ? '00' : '30';
        
        return sprintf('%02d:%s:00', $hour, $minute);
    }
    
    private function randomDouble($min = 10.0, $max = 50.0): float
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}