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
use Illuminate\Support\Facades\Mail;
use App\Mail\PetKeeping\PetKeeperEmailVerification;
use App\Models\PetKeeping\PetKeeping;
use App\Models\Shared\Disponibilite;
use App\Models\Shared\Service;

class PetKeeperRegistration extends Component
{
    use WithFileUploads;
    
    public $currentStep = 1;
    public $totalSteps = 7;
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

    public $verification_code;
    public $verification_code_incomplete = true;
    public $verification_code_full;

    public ?string $generated_verification_code = null;
    public ?\Carbon\Carbon $verification_code_expires_at = null;
    
    // Étape 2: Contact
    public $adresse;
    public $ville;
    public $code_postal;
    public $pays = '';
    public $profile_photo;
    
    // Étape 3: Professionnel
    public $specialite;
    public $years_experience = 0;
    public $certificationList = [
        'Certificat de capacité animaux domestiques',
        'Formation première secours animaliers',
        'Formation comportement animal',
        'Certificat toilettage',
        'Formation éducation canine',
        'ACACED (Attestation de connaissances)'
    ];


    // Etape 4: Creation du service

    public $number_of_services = 0;
    public $max_services = 2;
    public $services = [];
   
    
    // Étape 5: Compétences
    public $certifications = [];
    public $special_skills = [];
    public $availabilities = [];
    
    // Étape 6: Documents
    public $criminal_record;
    public $proof_of_address;
    public $animal_certificates = [];


    

    
    
    
    
    public $days = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 
        'Vendredi', 'Samedi', 'Dimanche'
    ];
    

    public function mount()
    {
        if (empty($this->services)) {
            $this->addService();
        }
    }

    private function generateAndSendVerificationCode(): void
    {
        $code = (string) random_int(1000000000, 9999999999);

        $this->generated_verification_code = Hash::make($code);
        $this->verification_code_expires_at = now()->addMinutes(10);

        Mail::to($this->email)->send(
            new PetKeeperEmailVerification(
                $this->email,
                $this->prenom,
                $this->nom,
                $code
            )
        );
    }


    public function resendVerificationCode()
    {
        $this->resetErrorBag('verification_code');
        $this->verification_code_full = null;

        $this->generateAndSendVerificationCode();

        session()->flash(
            'verification_code_resent',
            'Un nouveau code de vérification a été envoyé.'
        );

        $this->dispatch('clear-verification-code');
    }


    public function changeEmail()
    {
        $this->currentStep = 1;

        $this->generated_verification_code = null;
        $this->verification_code_expires_at = null;

        $this->dispatch('step-changed', step: 1);
    }

    private function verifyEmailCode(): bool
    {
        if (!$this->verification_code_full || strlen($this->verification_code_full) !== 10) {
            $this->verification_code_incomplete = true;
            $this->addError('verification_code', 'Veuillez entrer le code complet.');
            return false;
        }

        if (!$this->generated_verification_code ||
            !$this->verification_code_expires_at ||
            now()->greaterThan($this->verification_code_expires_at)) {

            $this->addError('verification_code', 'Le code a expiré. Veuillez en demander un nouveau.');
            return false;
        }

        if (!Hash::check($this->verification_code_full, $this->generated_verification_code)) {
            $this->addError('verification_code', 'Code de vérification incorrect.');
            return false;
        }

        $this->verification_code_incomplete = false;
        return true;
    }

    
    public function nextStep()
    {
        $this->validateCurrentStep();

        

        if ($this->currentStep === 2 && !$this->verifyEmailCode()) {
            return;
        }

        if ($this->currentStep === 1) {
            $this->generateAndSendVerificationCode();
        }

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
            // 2 => [
            //     'verification_code' => 'required|numeric|max:10',
            // ],
            3 => [
                'adresse' => 'required|string|max:255',
                'ville' => 'required|string|max:100',
                'code_postal' => 'required|string|max:10',
                'pays' => 'required|string|max:50',
            ],
            4 => [
                'services' => 'required|array|min:1', 
                'services.*.service_name' => 'required|string|max:255',
                'services.*.service_description' => 'nullable|string|max:1000',
                'services.*.service_status' => 'nullable|string|in:ACTIVE,INACTIVE,ARCHIVED',
                'services.*.service_category' => 'required|string|max:255',
                'services.*.service_payment_criteria' => 'required|string|max:255',
                'services.*.service_pet_type' => 'required|string|max:255',
                'services.*.service_base_price' => 'required|numeric|min:0',
                'services.*.service_accepts_aggressive_pets' => 'sometimes|boolean',
                'services.*.service_accepts_untrained_pets' => 'sometimes|boolean',
                'services.*.service_vaccination_required' => 'sometimes|boolean',
            ],
            5 => [
                'specialite' => 'required|string|max:255',
                'years_experience' => 'required|integer|min:0|max:50',
                'certifications' => 'array',
            ],
            6 => [
                'availabilities' => 'array'
            ],
            7 => [
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

      
        // if (!$this->validateFileUploads()) {
        //     return;
        // }

        try {
            DB::beginTransaction();

            $utilisateur = Utilisateur::create([
                'nom'         => $this->nom,
                'prenom'      => $this->prenom,
                'email'       => $this->email,
                'password'    => Hash::make($this->password),
                'telephone'   => $this->telephone,
                'dateNaissance' => $this->dateNaissance,
                'role'        => 'intervenant',
                'statut'      => 'actif',
                'note'        => 0,
                'nbrAvis'     => 0,
                'idAdmin'     => null,
            ]);

            
            $intervenant = Intervenant::create([
                'idIntervenant' => $utilisateur->idUser,
                'statut'        => 'EN_ATTENTE',
                'idAdmin'       => null,
            ]);

            
            Localisation::create([
                'idUser'   => $utilisateur->idUser,
                'ville'    => $this->ville,
                'adresse'  => $this->adresse,
                'latitude' => 0,
                'longitude'=> 0,
            ]);

            
            $petKeeper = PetKeeper::create([
                'idPetKeeper'              => $utilisateur->idUser,
                'nombres_services_demandes'=> 0,
                'specialite'               => $this->specialite,
                'years_of_experience'      => $this->years_experience
            ]);

            
            if (!$this->handleFileUploads($utilisateur, $petKeeper)) {
                throw new \Exception("Erreur lors de l'upload des fichiers");
            }

            
            foreach ($this->certifications as $cert) {
                if (!empty($cert)) {
                    PetKeeperCertification::create([
                        'idPetKeeper'   => $petKeeper->idPetKeeper,
                        'certification' => $cert,
                        'document'      => '',
                    ]);
                }
            }



            //Create Services
            foreach ($this->services as $service) {
                if (!$service) continue;

                $g_service = Service::create([
                    'nomService' => $service['service_name'],
                    'description' => $service['service_description'],
                    'statut' => $service['service_status'],
                ]);

                PetKeeping::create([
                    'idPetKeeping' => $g_service->idService,
                    'idPetKeeper' => $petKeeper->idPetKeeper,
                    'categorie_petkeeping' => $service['service_category'],
                    'accepts_aggressive_pets' => $service['service_accepts_aggressive_pets'] ?? false,
                    'accepts_untrained_pets' => $service['service_accepts_untrained_pets'] ?? false,
                    'vaccination_required' => $service['service_vaccination_required'] ?? false,
                    'pet_type' => $service['service_pet_type'],
                    'payment_criteria' => $service['service_payment_criteria'],
                    'base_price' => $service['service_base_price'],
                    'statut' => $g_service['statut'],
                ]);
            }



            //Storing availabilities

            foreach ($this->availabilities as $day => $slots) {
                foreach ($slots as $slot) {
                    if (
                        empty($slot['start']) ||
                        empty($slot['end'])
                    ) {
                        continue;
                    }
                    
                    Disponibilite::create([
                        'heureDebut'     => $slot['start'],
                        'heureFin'       => $slot['end'],
                        'jourSemaine'    => $day,              
                        'est_reccurent'  => true,
                        'date_specifique' => null,
                        'idIntervenant'  => $petKeeper->idPetKeeper,
                    ]);
                }
            }

            DB::commit();
            $this->showSuccessMessage($utilisateur, $petKeeper);

        } catch (\Exception $e) {
            DB::rollBack();

            $this->addError('submit', 'Erreur lors de l\'inscription: '.$e->getMessage());
            Log::error('Registration error: '.$e->getMessage());
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
    
    private function showSuccessMessage($utilisateur, $petKeeper)
    {
        
        $documents = PetKeeperCertification::where('idPetKeeper', $petKeeper->idPetKeeper)->get();

        $documentList = [];
        foreach ($documents as $doc) {
            $hasFile = !empty($doc->document);
            $documentList[] = [
                'type'      => $doc->certification,
                'has_file'  => $hasFile ? 'Avec fichier' : 'Sans fichier',
                'file_name' => $hasFile ? basename($doc->document) : 'Aucun fichier'
            ];
        }

        
        $message  = "<strong>Inscription PetKeeper effectuée avec succès.</strong><br><br>";
        $message .= "<strong>Résumé :</strong><br>";
        $message .= "• Email : <strong>{$utilisateur->email}</strong><br>";

        

        $message .= "• Nombre de documents enregistrés : <strong>" . count($documentList) . "</strong><br><br>";

        $message .= "<strong>Documents :</strong><br>";
        foreach ($documentList as $doc) {
            $message .= "• {$doc['type']} - {$doc['has_file']}";
            if ($doc['file_name'] !== 'Aucun fichier') {
                $message .= " ({$doc['file_name']})";
            }
            $message .= "<br>";
        }

        
        session()->flash('registration_success', $message);

        
        $this->registrationComplete = true;

        
        Log::info('REGISTRATION COMPLETED', [
            'user_id'        => $utilisateur->idUser,
            'email'          => $utilisateur->email,
            'petkeeper_id'   => $petKeeper->idPetKeeper,
            'documents_count'=> count($documentList)
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


    public function addService()
    {
        
        if (count($this->services) < $this->max_services) {
            $this->dispatch('service-added');
            $this->services[] = [
                'service_name' => '',
                'service_description' => '',
                'service_status' => 'ACTIVE',
                'service_category' => '',
                'service_payment_criteria' => 'PER_HOUR',
                'service_pet_type' => '',
                'service_base_price' => 10,
                'service_accepts_aggressive_pets' => false,
                'service_accepts_untrained_pets' => false,
                'service_vaccination_required' => false,
            ];
            
            $this->number_of_services = count($this->services);
        }
    }

    public function removeService($index)
    {
        if ($index > 0 && isset($this->services[$index])) {
            unset($this->services[$index]);
            $this->services = array_values($this->services); // Reindex array
            $this->number_of_services = count($this->services);
        }
    }
    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-registration');
    }
}