<?php

namespace Database\Seeders\PetKeeping;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetKeepingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Starting step-by-step seeding...\n\n";
        
        // STEP 1: Create services
        echo "Step 1: Creating services...\n";
        $this->createServices();
        
        // STEP 2: Create admin
        echo "\nStep 2: Creating admin...\n";
        $adminId = $this->createAdmin();
        
        // STEP 3: Create users
        echo "\nStep 3: Creating users...\n";
        $userIds = $this->createUsers($adminId);
        
        // STEP 4: Create intervenants
        echo "\nStep 4: Creating intervenants...\n";
        $intervenantIds = $this->createIntervenants($userIds, $adminId);
        
        // STEP 5: Create petkeeping services
        echo "\nStep 5: Creating petkeeping services...\n";
        $this->createPetkeepingServices($intervenantIds);
        
        // STEP 6: Create certifications
        // echo "\nStep 6: Creating certifications...\n";
        // $this->createCertifications($intervenantIds);
        
        echo "\n=== All steps completed successfully! ===\n";
    }
    
    private function createServices()
    {
        $services = [
            ['nomService' => 'Pet Boarding', 'description' => 'Overnight care', 'statut' => 'ACTIVE'],
            ['nomService' => 'Pet Sitting', 'description' => 'In-home care', 'statut' => 'ACTIVE'],
            ['nomService' => 'Dog Walking', 'description' => 'Daily walks', 'statut' => 'ACTIVE'],
            ['nomService' => 'Pet Grooming', 'description' => 'Bathing & grooming', 'statut' => 'ACTIVE'],
            ['nomService' => 'Training', 'description' => 'Obedience training', 'statut' => 'ACTIVE'],
            ['nomService' => 'Drop-in Visits', 'description' => 'Short check-ins', 'statut' => 'ACTIVE'],
        ];
        
        foreach ($services as $service) {
            $service['created_at'] = now();
            $service['updated_at'] = now();
        }
        
        DB::table('services')->insert($services);
        $count = DB::table('services')->count();
        echo "✓ Created {$count} services\n";
    }
    
    private function createAdmin()
    {
        // Check if admin exists
        $admin = DB::table('admins')->where('emailAdmin', 'admin@petcare.com')->first();
        
        if (!$admin) {
            $adminId = DB::table('admins')->insertGetId([
                'emailAdmin' => 'admin@petcare.com',
                'passwordAdmin' => Hash::make('password123'),
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
            // 5 Pet Keepers
            [
                'nom' => 'Johnson', 'prenom' => 'Sarah', 'email' => 'sarah@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+1234567890',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.9,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah',
                'nbrAvis' => 127, 'dateNaissance' => '1985-05-15', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Chen', 'prenom' => 'Michael', 'email' => 'michael@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+1234567891',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.8,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Michael',
                'nbrAvis' => 89, 'dateNaissance' => '1990-08-22', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Rodriguez', 'prenom' => 'Emily', 'email' => 'emily@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+1234567892',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 5.0,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Emily',
                'nbrAvis' => 203, 'dateNaissance' => '1988-03-10', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Martinez', 'prenom' => 'David', 'email' => 'david@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+1234567893',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.7,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=David',
                'nbrAvis' => 156, 'dateNaissance' => '1992-11-30', 'idAdmin' => $adminId,
            ],
            [
                'nom' => 'Lee', 'prenom' => 'Jennifer', 'email' => 'jennifer@example.com',
                'password' => Hash::make('password123'), 'telephone' => '+1234567894',
                'statut' => 'actif', 'role' => 'intervenant', 'note' => 4.9,
                'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jennifer',
                'nbrAvis' => 178, 'dateNaissance' => '1987-07-18', 'idAdmin' => $adminId,
            ],
        ];
        
        // Add timestamps
        foreach ($users as &$user) {
            $user['created_at'] = now();
            $user['updated_at'] = now();
        }
        
        // Insert users
        DB::table('utilisateurs')->insert($users);
        
        // Get their IDs
        $userIds = DB::table('utilisateurs')
            ->where('role', 'intervenant')
            ->orderBy('idUser', 'asc')
            ->pluck('idUser')
            ->toArray();
            
        echo "✓ Created " . count($userIds) . " users with IDs: " . implode(', ', $userIds) . "\n";
        
        return $userIds;
    }
    
    private function createIntervenants($userIds, $adminId)
    {
        $intervenants = [];
        
        foreach ($userIds as $userId) {
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
        $intervenantData = DB::table('intervenants')->get();
        $intervenantIds = $intervenantData->pluck('IdIntervenant')->toArray();
        
        echo "✓ Created " . count($intervenants) . " intervenants\n";
        echo "  Intervenant IDs: " . implode(', ', $intervenantIds) . "\n";
        
        return $intervenantIds;
    }
    
    private function createPetkeepingServices($intervenantIds)
    {
        $services = [];
        
        // Map each intervenant to services (simplified version)
        $serviceMappings = [
            // Sarah Johnson (first intervenant)
            0 => [
                ['idPetKeeping' => 1, 'categorie' => 'PENSION', 'pets' => 'Dogs'],
                ['idPetKeeping' => 2, 'categorie' => 'A_DOMICILE', 'pets' => 'Dogs'],
            ],
            // Michael Chen
            1 => [
                ['idPetKeeping' => 2, 'categorie' => 'A_DOMICILE', 'pets' => 'Cats,Small Pets'],
                ['idPetKeeping' => 6, 'categorie' => 'DEPLACEMENT', 'pets' => 'Cats'],
            ],
            // Emily Rodriguez
            2 => [
                ['idPetKeeping' => 1, 'categorie' => 'PENSION', 'pets' => 'Dogs'],
                ['idPetKeeping' => 5, 'categorie' => 'DRESSAGE', 'pets' => 'Rabbit'],
            ],
            // David Martinez
            3 => [
                ['idPetKeeping' => 3, 'categorie' => 'PROMENADE', 'pets' => 'Birds'],
            ],
            // Jennifer Lee
            4 => [
                ['idPetKeeping' => 1, 'categorie' => 'PENSION', 'pets' => 'Dogs,Cats,Rabbits'],
                ['idPetKeeping' => 4, 'categorie' => 'GARDERIE', 'pets' => 'Dogs'],
            ],
        ];
        
        foreach ($serviceMappings as $index => $mappings) {
            if (isset($intervenantIds[$index])) {
                foreach ($mappings as $mapping) {
                    $services[] = [
                        'idPetKeeping' => $mapping['idPetKeeping'],
                        'idPetKeeper' => $intervenantIds[$index],
                        'categorie_petkeeping' => $mapping['categorie'],
                        'accepts_aggressive_pets' => 0,
                        'accepts_untrained_pets' => 1,
                        'vaccination_required' => 1,
                        'pet_type' => $mapping['pets'],
                        'payment_criteria' => 'PER_HOUR',
                        'base_price' => $this->randomDouble(), 
                        'statut' => 'ACTIVE',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        
        DB::table('petkeeping')->insert($services);
        echo "✓ Created " . count($services) . " petkeeping services\n";
    }

    function randomDouble($min = 10.0, $max = 50.0): float
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    
    private function createCertifications($intervenantIds)
    {
        $certifications = [
            // Sarah Johnson
            [
                'idPetKeeper' => $intervenantIds[0],
                'certification' => 'Pet First Aid & CPR Certified',
                'document' => 'certificates/firstaid.pdf',
            ],
            [
                'idPetKeeper' => $intervenantIds[0],
                'certification' => 'Professional Dog Trainer',
                'document' => 'certificates/trainer.pdf',
            ],
            // Emily Rodriguez
            [
                'idPetKeeper' => $intervenantIds[2],
                'certification' => 'Certified Dog Walker',
                'document' => 'certificates/walker.pdf',
            ],
            // Jennifer Lee
            [
                'idPetKeeper' => $intervenantIds[4],
                'certification' => 'Veterinary Assistant',
                'document' => 'certificates/vet.pdf',
            ],
        ];
        
        foreach ($certifications as &$cert) {
            $cert['created_at'] = now();
            $cert['updated_at'] = now();
        }
        
        DB::table('petkeeper_certifications')->insert($certifications);
        echo "✓ Created " . count($certifications) . " certifications\n";
    }
}