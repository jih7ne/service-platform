<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeperCertification;
use App\Models\PetKeeping\PaymentCriteria;
use App\Models\Shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PetKeeperRegistration extends Component
{
    use WithFileUploads;
    
    public $currentStep = 1;
    public $totalSteps = 5;
    public $registrationComplete = false;
    public $uploadErrors = [];
    
    // Étape 1: Profil
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $password_confirmation;
    public $dateNaissance;
    public $telephone;
    
    // Étape 2: Contact
    public $adresse;
    public $ville;
    public $code_postal;
    public $pays = 'France';
    public $profile_photo;
    
    // Étape 3: Professionnel
    public $specialite;
    public $years_experience = 0;
    public $accepted_animal_types = [];
    public $accepted_animal_sizes = [];
    public $services = [];
    public $description;
    public $hourly_rate;
    
    // Étape 4: Compétences
    public $certifications = [];
    public $special_skills = [];
    public $housing_type;
    public $has_outdoor_space = false;
    public $availabilities = [];
    
    // Étape 5: Documents
    public $criminal_record;
    public $proof_of_address;
    public $animal_certificates = [];
    
    // Constantes
    public $animalTypes = [
        'Chiens', 'Chats', 'Rongeurs', 'Oiseaux', 'Reptiles', 'Autres'
    ];
    
    public $animalSizes = [
        'Petit' => 'Petit',
        'Moyen' => 'Moyen', 
        'Grand' => 'Grand'
    ];
    
    public $serviceTypes = [
        'Garde à domicile (chez le client)',
        'Garde à domicile (chez moi)',
        'Promenade',
        'Visite à domicile',
        'Transport',
        'Garde de nuit',
        'Administration de médicaments',
        'Garde de jour'
    ];
    
    public $certificationList = [
        'Certificat de capacité animaux domestiques',
        'Formation première secours animaliers',
        'Formation comportement animal',
        'Certificat toilettage',
        'Formation éducation canine',
        'ACACED (Attestation de connaissances)'
    ];
    
    public $specialSkillsList = [
        'Administration médicamenteuse',
        'Médication',
        'Toilettage',
        'Éducation/Comportement',
        'Animaux à besoins spéciaux',
        'Garde animaux multiples'
    ];
    
    public $housingTypes = [
        'Appartement',
        'Maison',
        'Villa',
        'Ferme'
    ];
    
    public $days = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 
        'Vendredi', 'Samedi', 'Dimanche'
    ];
    
    // Méthodes de navigation
    public function nextStep()
    {
        $this->validateCurrentStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }
    
    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }
    
    private function validateCurrentStep()
    {
        $rules = $this->getValidationRules();
        if (isset($rules[$this->currentStep])) {
            $this->validate($rules[$this->currentStep]);
        }
    }
    
    private function getValidationRules()
    {
        return [
            1 => [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:utilisateurs,email',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'dateNaissance' => 'required|date|before:-18 years',
                'telephone' => 'required|string|max:20',
            ],
            2 => [
                'adresse' => 'required|string|max:255',
                'ville' => 'required|string|max:100',
                'code_postal' => 'required|string|max:10',
                'pays' => 'required|string|max:50',
            ],
            3 => [
                'specialite' => 'required|string|max:255',
                'years_experience' => 'required|integer|min:0|max:50',
                'accepted_animal_types' => 'required|array|min:1',
                'services' => 'required|array|min:1',
                'description' => 'required|string|min:50|max:2000',
                'hourly_rate' => 'required|numeric|min:0',
            ],
            4 => [
                'certifications' => 'array',
                'special_skills' => 'array',
                'housing_type' => 'required|string',
            ],
            5 => [
                'criminal_record' => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360',
                'proof_of_address' => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360',
                'animal_certificates.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:15360',
            ],
        ];
    }
    
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['criminal_record', 'proof_of_address'])) {
            $this->validateOnly($propertyName, $this->getValidationRules()[5]);
            
            $file = $this->{$propertyName};
            if ($file && $file->getSize() > 15 * 1024 * 1024) {
                $this->addError($propertyName, 'Le fichier est trop volumineux (max 15MB)');
                $this->{$propertyName} = null;
            }
        }
        
        if ($propertyName === 'animal_certificates') {
            foreach ($this->animal_certificates as $index => $certificate) {
                if ($certificate && $certificate->getSize() > 15 * 1024 * 1024) {
                    $this->addError("animal_certificates.{$index}", 'Le fichier est trop volumineux (max 15MB)');
                    unset($this->animal_certificates[$index]);
                }
            }
        }
    }
    
    public function submit()
    {
        $this->validateAll();
        
        if (!$this->validateFileUploads()) {
            return;
        }
        
        // DÉSACTIVER FK POUR SQLITE
        DB::statement('PRAGMA foreign_keys = OFF;');
        
        try {
            DB::beginTransaction();
            
            // 1. Créer ou récupérer admin
            $admin = \App\Models\Shared\Admin::first();
            if (!$admin) {
                $admin = \App\Models\Shared\Admin::create([
                    'emailAdmin' => 'admin@helpora.com',
                    'passwordAdmin' => Hash::make('admin123456')
                ]);
            }
            
            // 2. Créer l'utilisateur
            $utilisateur = Utilisateur::create([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telephone' => $this->telephone,
                'dateNaissance' => $this->dateNaissance,
                'role' => 'intervenant',
                'statut' => 'actif',
                'note' => 0,
                'nbrAvis' => 0,
                'idAdmin' => $admin->idAdmin
            ]);
            
            Log::info('Utilisateur créé', [
                'idUser' => $utilisateur->idUser,
                'email' => $utilisateur->email
            ]);
            
            // 3. Créer l'intervenant
            $intervenant = Intervenant::create([
                'statut' => 'EN_ATTENTE',
                'idIntervenant' => $utilisateur->idUser,
                'idAdmin' => $admin->idAdmin,
            ]);
            
            Log::info('Intervenant créé', [
                'id' => $intervenant->id,
                'idIntervenant' => $intervenant->idIntervenant,
                'user_id' => $utilisateur->idUser
            ]);
            
            // 4. Ajouter la localisation
            Localisation::create([
                'ville' => $this->ville,
                'adresse' => $this->adresse,
                'idUser' => $utilisateur->idUser,
                'latitude' => 0.0,
                'longitude' => 0.0,
            ]);
            
            Log::info('Localisation créée', ['user_id' => $utilisateur->idUser]);
            
            // 5. Créer le pet keeper
            $petKeeperId = $utilisateur->idUser;
            
            DB::table('petkeepers')->insert([
                'idPetKeeper' => $petKeeperId,
                'nombres_services_demandes' => 0,
                'specialite' => $this->specialite,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $petKeeper = PetKeeper::find($petKeeperId);
            
            if (!$petKeeper) {
                throw new \Exception('Impossible de créer le pet keeper');
            }
            
            Log::info('PetKeeper créé', [
                'idPetKeeper' => $petKeeper->idPetKeeper,
                'specialite' => $petKeeper->specialite
            ]);
            
            // 6. Créer le service petkeeping (SANS idIntervenant car colonne n'existe pas)
            $petKeepingService = \App\Models\Shared\Service::create([
                'nomService' => 'PetKeeping - ' . $this->specialite,
                'description' => $this->description,
                'statut' => 'ACTIVE',
                // Note: idIntervenant n'existe pas dans la table services
            ]);
            
            Log::info('Service créé', [
                'idService' => $petKeepingService->idService,
                'nomService' => $petKeepingService->nomService
            ]);
            
            // 7. Créer l'entrée petkeeping (si la table existe avec les bonnes colonnes)
            try {
                // Vérifier si la table petkeeping existe
                if (\Schema::hasTable('petkeeping')) {
                    // Vérifier les colonnes existantes
                    $hasIdPetKeeping = \Schema::hasColumn('petkeeping', 'idPetKeeping');
                    $hasIdPetKeeper = \Schema::hasColumn('petkeeping', 'idPetKeeper');
                    
                    if ($hasIdPetKeeping && $hasIdPetKeeper) {
                        \App\Models\PetKeeping\PetKeeping::create([
                            'idPetKeeping' => $petKeepingService->idService,
                            'idPetKeeper' => $intervenant->idIntervenant,
                            'categorie_petkeeping' => 'A_DOMICILE',
                            'accepts_aggressive_pets' => in_array('Administration médicamenteuse', $this->special_skills) ? 1 : 0,
                            'accepts_untrained_pets' => in_array('Éducation/Comportement', $this->special_skills) ? 1 : 0,
                            'vaccination_required' => 1,
                            'pet_type' => implode(',', $this->accepted_animal_types),
                            'statut' => 'ACTIVE',
                        ]);
                        
                        Log::info('PetKeeping créé', [
                            'idPetKeeping' => $petKeepingService->idService,
                            'idPetKeeper' => $intervenant->idIntervenant
                        ]);
                    } else {
                        Log::warning('Table petkeeping existe mais colonnes manquantes');
                    }
                } else {
                    Log::warning('Table petkeeping n\'existe pas');
                }
            } catch (\Exception $e) {
                Log::error('Erreur création petkeeping: ' . $e->getMessage());
                // Continuer même si petkeeping échoue
            }
            
            // 8. GÉRER LES UPLOADS DE FICHIERS
            $uploadSuccess = $this->handleFileUploads($utilisateur, $petKeeper);
            
            if (!$uploadSuccess && !empty($this->uploadErrors)) {
                throw new \Exception(implode(', ', $this->uploadErrors));
            }
            
            // 9. Ajouter les certifications
            foreach ($this->certifications as $certification) {
                if (!empty($certification)) {
                    \App\Models\PetKeeping\PetKeeperCertification::create([
                        'idPetKeeper' => $petKeeper->idPetKeeper,
                        'certification' => $certification,
                        'document' => '',
                    ]);
                }
            }
            
            // 10. Ajouter les critères de paiement
            \App\Models\PetKeeping\PaymentCriteria::create([
                'idPetKeeper' => $petKeeper->idPetKeeper,
                'criteria' => 'PER_HOUR',
                'description' => 'Tarif horaire',
                'base_price' => $this->hourly_rate,
            ]);
            
            DB::commit();
            
            // RÉACTIVER FK
            DB::statement('PRAGMA foreign_keys = ON;');
            
            $this->showSuccessMessage($utilisateur, $petKeeper, $petKeepingService);
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Réactiver FK même en cas d'erreur
            DB::statement('PRAGMA foreign_keys = ON;');
            $this->addError('submit', 'Erreur lors de l\'inscription: ' . $e->getMessage());
            Log::error('Registration error: ' . $e->getMessage());
        }
    }
    
    private function validateAll()
    {
        $allRules = [];
        foreach ($this->getValidationRules() as $stepRules) {
            $allRules = array_merge($allRules, $stepRules);
        }
        $this->validate($allRules);
    }
    
    private function validateFileUploads()
    {
        $rules = $this->getValidationRules()[5];
        
        try {
            if ($this->criminal_record) {
                $validator = \Validator::make(
                    ['criminal_record' => $this->criminal_record],
                    ['criminal_record' => $rules['criminal_record']]
                );
                
                if ($validator->fails()) {
                    $this->addError('criminal_record', $validator->errors()->first('criminal_record'));
                    return false;
                }
            }
            
            if ($this->proof_of_address) {
                $validator = \Validator::make(
                    ['proof_of_address' => $this->proof_of_address],
                    ['proof_of_address' => $rules['proof_of_address']]
                );
                
                if ($validator->fails()) {
                    $this->addError('proof_of_address', $validator->errors()->first('proof_of_address'));
                    return false;
                }
            }
            
            return true;
            
        } catch (\Exception $e) {
            $this->addError('file_upload', 'Erreur de validation des fichiers');
            return false;
        }
    }
    
    private function handleFileUploads($utilisateur, $petKeeper)
    {
        $this->uploadErrors = [];
        
        try {
            // 1. Photo de profil
            if ($this->profile_photo) {
                $profilePath = $this->profile_photo->store('profile-photos', 'public');
                $utilisateur->update(['photo' => $profilePath]);
                Log::info('Profile photo saved', [
                    'user_id' => $utilisateur->idUser, 
                    'path' => $profilePath
                ]);
            }
            
            // 2. Casier judiciaire
            if ($this->criminal_record) {
                $criminalPath = $this->criminal_record->store('documents/criminal-records', 'public');
                
                PetKeeperCertification::create([
                    'idPetKeeper' => $petKeeper->idPetKeeper,
                    'certification' => 'EXTRACT_DE_CASIER_JUDICIAIRE',
                    'document' => $criminalPath,
                ]);
                
                Log::info('Criminal record saved', [
                    'petkeeper_id' => $petKeeper->idPetKeeper,
                    'path' => $criminalPath
                ]);
            }
            
            // 3. Justificatif de domicile
            if ($this->proof_of_address) {
                $addressPath = $this->proof_of_address->store('documents/proof-of-address', 'public');
                
                PetKeeperCertification::create([
                    'idPetKeeper' => $petKeeper->idPetKeeper,
                    'certification' => 'JUSTIFICATIF_DE_DOMICILE',
                    'document' => $addressPath,
                ]);
                
                Log::info('Proof of address saved', [
                    'petkeeper_id' => $petKeeper->idPetKeeper,
                    'path' => $addressPath
                ]);
            }
            
            // 4. Certificats animaux
            if (!empty($this->animal_certificates)) {
                foreach ($this->animal_certificates as $certificate) {
                    if ($certificate) {
                        $path = $certificate->store('documents/animal-certificates', 'public');
                        
                        PetKeeperCertification::create([
                            'idPetKeeper' => $petKeeper->idPetKeeper,
                            'certification' => 'CERTIFICAT_ANIMALIER_' . strtoupper(pathinfo($certificate->getClientOriginalName(), PATHINFO_FILENAME)),
                            'document' => $path,
                        ]);
                        
                        Log::info('Animal certificate saved', [
                            'petkeeper_id' => $petKeeper->idPetKeeper,
                            'path' => $path
                        ]);
                    }
                }
            }
            
            return true;
            
        } catch (\Exception $e) {
            $this->uploadErrors[] = 'Erreur lors de l\'upload des fichiers: ' . $e->getMessage();
            Log::error('File upload error: ' . $e->getMessage());
            return false;
        }
    }
    
    private function showSuccessMessage($utilisateur, $petKeeper, $service = null)
    {
        // Récupérer tous les documents sauvegardés
        $documents = PetKeeperCertification::where('idPetKeeper', $petKeeper->idPetKeeper)->get();
        
        $documentList = [];
        foreach ($documents as $doc) {
            $hasFile = !empty($doc->document) && $doc->document !== '';
            $documentList[] = [
                'type' => $doc->certification,
                'has_file' => $hasFile ? '✅ AVEC FICHIER' : '✅ SANS FICHIER',
                'file_name' => $hasFile ? basename($doc->document) : 'Aucun fichier'
            ];
        }
        
        // Construire le message
        $message = "🎉 <strong>Inscription PetKeeper réussie !</strong><br><br>";
        $message .= "📋 <strong>Résumé :</strong><br>";
        $message .= "• ID Utilisateur : <strong>{$utilisateur->idUser}</strong><br>";
        $message .= "• Email : <strong>{$utilisateur->email}</strong><br>";
        $message .= "• ID PetKeeper : <strong>{$petKeeper->idPetKeeper}</strong><br>";
        
        if ($service) {
            $message .= "• ID Service : <strong>{$service->idService}</strong><br>";
            $message .= "• Nom Service : <strong>{$service->nomService}</strong><br>";
        }
        
        $message .= "• Documents enregistrés : <strong>" . count($documentList) . "</strong><br><br>";
        
        $message .= "📎 <strong>Documents :</strong><br>";
        foreach ($documentList as $doc) {
            $message .= "• {$doc['type']} - {$doc['has_file']}";
            if ($doc['file_name'] !== 'Aucun fichier') {
                $message .= " ({$doc['file_name']})";
            }
            $message .= "<br>";
        }
        
        // Stocker dans la session
        session()->flash('registration_success', $message);
        
        // Mettre à jour le statut
        $this->registrationComplete = true;
        
        // Log final
        Log::info('=== REGISTRATION COMPLETED ===', [
            'user_id' => $utilisateur->idUser,
            'email' => $utilisateur->email,
            'petkeeper_id' => $petKeeper->idPetKeeper,
            'service_id' => $service ? $service->idService : 'null',
            'documents_count' => count($documentList)
        ]);
    }
    
    public function removeFile($fileType, $index = null)
    {
        switch ($fileType) {
            case 'criminal_record':
                $this->criminal_record = null;
                break;
            case 'proof_of_address':
                $this->proof_of_address = null;
                break;
            case 'animal_certificate':
                if ($index !== null && isset($this->animal_certificates[$index])) {
                    unset($this->animal_certificates[$index]);
                    $this->animal_certificates = array_values($this->animal_certificates);
                }
                break;
            case 'profile_photo':
                $this->profile_photo = null;
                break;
        }
    }
    
    public function addCertificate()
    {
        $this->animal_certificates[] = null;
    }
    
    public function addAvailability($day)
    {
        if (!isset($this->availabilities[$day])) {
            $this->availabilities[$day] = [];
        }
        
        $this->availabilities[$day][] = [
            'start' => '09:00',
            'end' => '17:00'
        ];
    }
    
    public function removeAvailability($day, $index)
    {
        if (isset($this->availabilities[$day][$index])) {
            unset($this->availabilities[$day][$index]);
            $this->availabilities[$day] = array_values($this->availabilities[$day]);
        }
    }
    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-registration');
    }
}