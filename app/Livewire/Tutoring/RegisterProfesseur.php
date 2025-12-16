<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use App\Models\Shared\Intervenant;
use App\Models\SoutienScolaire\Professeur;
use App\Models\Shared\Service;
use App\Models\Shared\OffreService; // NOUVEAU
use App\Models\SoutienScolaire\Matiere;
use App\Models\SoutienScolaire\Niveau;
use App\Models\Shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Mail\Tutoring\InscriptionProfesseurEnCours;
use App\Mail\Tutoring\NouvelleInscriptionProfesseurAdmin;
use App\Mail\Tutoring\VerificationCodeEmail;
use Carbon\Carbon;

class RegisterProfesseur extends Component
{
    use WithFileUploads;

    // NOUVEAU : Détection si utilisateur déjà connecté
    public $isExistingUser = false;
    public $existingIntervenant = null;
    public $canAddService = true;
    public $currentServicesCount = 0;

    // Stepper
    public $currentStep = 1;
    public $registrationComplete = false;

    // Étape 1 : Informations personnelles
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $password = '';
    public $telephone = '';
    public $dateNaissance = '';
    public $showPassword = false;

    // Étape 1.5 : Vérification email
    public $verificationCode = '';
    public $generatedCode = '';
    public $codeVerified = false;

    // Étape 2 : Localisation
    public $pays = '';
    public $ville = '';
    public $region = '';
    public $adresseComplete = '';
    public $latitude = null;
    public $longitude = null;

    // Étape 3 : Matières et niveaux
    public $matieres = [];
    public $surnom = '';
    public $biographie = '';
    public $availableMatieres = [];
    public $availableNiveaux = [];

    // Étape 4 : Documents
    public $cinDocument = null;
    public $diplome = null;
    public $photo = null;
    public $niveauEtudes = '';

    public function mount()
    {
        // NOUVEAU : Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            $user = Auth::user();
            
            // Vérifier si c'est un intervenant
          $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();
            
            if ($intervenant) {
                $this->isExistingUser = true;
                $this->existingIntervenant = $intervenant;
                
                // Compter les services actifs ou en attente
   $this->currentServicesCount = OffreService::where('idIntervenant', $intervenant->IdIntervenant)
                    ->whereIn('statut', ['EN_ATTENTE', 'VALIDE'])
                    ->count();
                
                // Vérifier s'il peut ajouter un service
                if ($this->currentServicesCount >= 2) {
                    $this->canAddService = false;
                    session()->flash('error', 'Vous avez déjà atteint la limite de 2 services. Vous ne pouvez pas en ajouter d\'autres.');
                    return redirect()->route('dashboard'); // Rediriger vers le dashboard
                }
                
                // Pré-remplir les informations de l'utilisateur existant
                $this->firstName = $user->prenom;
                $this->lastName = $user->nom;
                $this->email = $user->email;
                $this->telephone = $user->telephone;
                $this->dateNaissance = $user->dateNaissance;
                
                // Récupérer la localisation existante
                $localisation = Localisation::where('idUser', $user->idUser)->first();
                if ($localisation) {
                    $this->pays = $localisation->pays;
                    $this->ville = $localisation->ville;
                    $this->region = $localisation->region;
                    $this->adresseComplete = $localisation->adresse;
                    $this->latitude = $localisation->latitude;
                    $this->longitude = $localisation->longitude;
                }
                
                // Sauter l'étape de vérification email
                $this->codeVerified = true;
                
                session()->flash('info', "Bienvenue ! Vous pouvez ajouter un nouveau service ({$this->currentServicesCount}/2 services actuels).");
            }
        }
        
        // Charger les matières et niveaux disponibles
        $this->availableMatieres = Matiere::all();
        $this->availableNiveaux = Niveau::all();
    }

    protected function rules()
    {
        $rules = [];
if ($this->currentStep == 1) {
    // Si utilisateur existant, pas besoin de valider ces champs
    if (!$this->isExistingUser) {
        $rules = [
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|min:2|max:50',
            'email' => 'required|email', // ENLEVER unique
            'password' => 'required|min:8',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
        ];
    }
} elseif ($this->currentStep == 1.5) {
            if (!$this->isExistingUser) {
                $rules = [
                    'verificationCode' => 'required|size:10',
                ];
            }
        } elseif ($this->currentStep == 2) {
            $rules = [
                'pays' => 'required|string',
                'ville' => 'required|string',
                'region' => 'required|string',
                'adresseComplete' => 'required|string',
            ];
        } elseif ($this->currentStep == 3) {
            $rules = [
                'matieres' => 'required|array|min:1',
                'matieres.*.matiere_id' => 'required',
                'matieres.*.matiere_autre' => 'nullable|string|max:100',
                'matieres.*.niveau_id' => 'required|exists:niveaux,id_niveau',
                'matieres.*.prix_par_heure' => 'required|numeric|min:0',
                'surnom' => 'nullable|string|max:100',
                'biographie' => 'nullable|string',
            ];
        } elseif ($this->currentStep == 4) {
            $rules = [
                'cinDocument' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'diplome' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'photo' => 'nullable|image|max:2048',
                'niveauEtudes' => 'required|string',
            ];
        }

        return $rules;
    }

    protected $messages = [
        'verificationCode.required' => 'Le code de vérification est obligatoire',
        'verificationCode.size' => 'Le code doit contenir exactement 10 caractères',
        'cinDocument.required' => 'Le document CIN est obligatoire',
    ];

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }
public function checkEmailAvailability()
{
    // Vérifier si l'email existe
    $existingUser = Utilisateur::where('email', $this->email)->first();
    
    if ($existingUser) {
        // Vérifier si c'est un intervenant
        $intervenant = Intervenant::where('IdIntervenant', $existingUser->idUser)->first();
        
        if ($intervenant) {
            // Compter les services actifs ou en attente
            $servicesCount = OffreService::where('idIntervenant', $intervenant->IdIntervenant)
                ->whereIn('statut', ['EN_ATTENTE', 'VALIDE'])
                ->count();
            
            if ($servicesCount >= 2) {
                session()->flash('error', 'Cet email est déjà utilisé et a atteint la limite de 2 services.');
                return false;
            } else {
                session()->flash('error', 'Cet email existe déjà. Veuillez vous connecter pour ajouter un nouveau service.');
                return false;
            }
        } else {
            // Email existe mais pas en tant qu'intervenant
            session()->flash('error', 'Cet email est déjà utilisé pour un autre type de compte.');
            return false;
        }
    }
    
    return true; // Email disponible
}
public function sendVerificationCode()
{
    // Si utilisateur existant, sauter cette étape
    if ($this->isExistingUser) {
        $this->currentStep = 2;
        return;
    }
    
    $this->validate([
        'firstName' => 'required|min:2|max:50',
        'lastName' => 'required|min:2|max:50',
        'email' => 'required|email', // ENLEVER unique
        'password' => 'required|min:8',
        'telephone' => 'required|min:10|max:20',
        'dateNaissance' => 'required|date|before:today',
    ]);
    
    // Vérifier la disponibilité de l'email
    if (!$this->checkEmailAvailability()) {
        return; // Stopper si l'email n'est pas disponible
    }}

    public function verifyCode()
    {
        if ($this->isExistingUser) {
            $this->currentStep = 2;
            return;
        }
        
        $this->validate([
            'verificationCode' => 'required|size:10',
        ]);

        $storedCode = Cache::get('verification_code_' . $this->email);
        
        if (!$storedCode) {
            session()->flash('error', 'Le code a expiré. Veuillez demander un nouveau code.');
            return;
        }

        if ($this->verificationCode !== $storedCode) {
            session()->flash('error', 'Code de vérification incorrect.');
            return;
        }

        $this->codeVerified = true;
        Cache::forget('verification_code_' . $this->email);
        $this->currentStep = 2;
        session()->flash('success', 'Email vérifié avec succès !');
    }

    public function resendCode()
    {
        $this->sendVerificationCode();
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            if ($this->isExistingUser) {
                // Utilisateur existant : passer directement à l'étape 2
                $this->currentStep = 2;
            } else {
                // Nouvel utilisateur : envoyer le code de vérification
                $this->sendVerificationCode();
            }
            return;
        }

        $this->validate();
        
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep == 1.5) {
            $this->currentStep = 1;
        } elseif ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function addMatiere()
    {
        $this->matieres[] = [
            'matiere_id' => '',
            'matiere_autre' => '',
            'niveau_id' => '',
            'prix_par_heure' => '',
            'titre' => '',
            'description' => '',
            'type_service' => 'enligne',
        ];
    }

    public function removeMatiere($index)
    {
        unset($this->matieres[$index]);
        $this->matieres = array_values($this->matieres);
    }

    public function submitRegistration()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Récupérer l'ID du service "Soutien Scolaire"
            $service = Service::where('nomService', 'Soutien Scolaire')->first();
            if (!$service) {
                throw new \Exception('Service "Soutien Scolaire" introuvable');
            }

            // NOUVEAU : Gérer utilisateur existant vs nouveau
            if ($this->isExistingUser) {
                $user = Auth::user();
                $intervenant = $this->existingIntervenant;
                $admin = Admin::find($intervenant->idAdmin);
            } else {
                // 1. Créer ou récupérer admin
                $admin = Admin::first();
                if (!$admin) {
                    $admin = Admin::create([
                        'emailAdmin' => 'admin@helpora.com',
                        'passwordAdmin' => Hash::make('admin123456')
                    ]);
                }

                // 2. Créer l'utilisateur
                $user = Utilisateur::create([
                    'nom' => $this->lastName,
                    'prenom' => $this->firstName,
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

                // 3. Créer l'intervenant
          $intervenant = Intervenant::create([
    'IdIntervenant' => $user->idUser,
    'statut' => 'EN_ATTENTE',
    'idAdmin' => $admin->idAdmin,
]);

                // 4. Créer la localisation
                Localisation::create([
                    'latitude' => $this->latitude ?? 0,
                    'longitude' => $this->longitude ?? 0,
                    'ville' => $this->ville,
                    'region' => $this->region,
                    'pays' => $this->pays,
                    'adresse' => $this->adresseComplete,
                    'idUser' => $user->idUser,
                ]);
            }

            // NOUVEAU : Insérer dans offre_service
OffreService::create([
    'idIntervenant' => $intervenant->IdIntervenant,
    'idService' => $service->idService,
    'statut' => 'EN_ATTENTE',
]);

            // 5. Upload des fichiers
            $cinDocumentPath = $this->cinDocument ? $this->cinDocument->store('cin_documents', 'public') : null;
            $diplomePath = $this->diplome ? $this->diplome->store('diplomes', 'public') : null;
            $photoPath = $this->photo ? $this->photo->store('photos', 'public') : null;

            if ($photoPath && !$this->isExistingUser) {
                $user->update(['photo' => $photoPath]);
            }

            // 6. Créer le professeur
$professeur = Professeur::create([
    'CIN' => $cinDocumentPath,
    'surnom' => $this->surnom,
    'biographie' => $this->biographie,
    'diplome' => $diplomePath,
    'niveau_etudes' => $this->niveauEtudes,
    'intervenant_id' => $intervenant->IdIntervenant,
]);

            // 7. Créer les services professeur
            $matieresData = [];
            foreach ($this->matieres as $matiere) {
                $matiereId = $matiere['matiere_id'];
                if ($matiereId === 'autre' && !empty($matiere['matiere_autre'])) {
                    $newMatiere = Matiere::create([
                        'nom_matiere' => $matiere['matiere_autre'],
                        'description' => 'Matière ajoutée par un professeur'
                    ]);
                    $matiereId = $newMatiere->id_matiere;
                }

                \App\Models\SoutienScolaire\ServiceProf::create([
                    'titre' => $matiere['titre'] ?? 'Cours de matière',
                    'description' => $matiere['description'] ?? '',
                    'prix_par_heure' => $matiere['prix_par_heure'],
                    'status' => 'actif',
                    'type_service' => $matiere['type_service'] ?? 'enligne',
                    'professeur_id' => $professeur->id_professeur,
                    'matiere_id' => $matiereId,
                    'niveau_id' => $matiere['niveau_id'],
                ]);

                $matiereModel = Matiere::find($matiereId);
                $niveauModel = Niveau::find($matiere['niveau_id']);
                
                $matieresData[] = [
                    'matiere' => $matiereModel ? $matiereModel->nom_matiere : 'N/A',
                    'niveau' => $niveauModel ? $niveauModel->nom_niveau : 'N/A',
                    'prix' => $matiere['prix_par_heure'],
                ];
            }

            // 8. Envoyer les emails
            $emailDataProf = [
                'prenom' => $this->firstName,
                'nom' => $this->lastName,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'ville' => $this->ville,
                'niveau_etudes' => $this->niveauEtudes,
                'nombre_matieres' => count($this->matieres),
            ];

            Mail::to($this->email)->send(new InscriptionProfesseurEnCours($emailDataProf));

            $now = Carbon::now();
            $emailDataAdmin = [
                'prenom' => $this->firstName,
                'nom' => $this->lastName,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'ville' => $this->ville,
                'pays' => $this->pays,
                'niveau_etudes' => $this->niveauEtudes,
                'date_naissance' => Carbon::parse($this->dateNaissance)->format('d/m/Y'),
                'nombre_matieres' => count($this->matieres),
                'matieres' => $matieresData,
                'biographie' => $this->biographie,
                'a_diplome' => $this->diplome !== null,
                'a_photo' => $this->photo !== null,
                'date_inscription' => $now->format('d/m/Y'),
                'heure_inscription' => $now->format('H:i'),
                'dashboard_url' => url('/admin/dashboard'),
                'profile_url' => url('/admin/professeurs/' . $professeur->id_professeur),
            ];

            $admins = Admin::all();
            foreach ($admins as $admin) {
                Mail::to($admin->emailAdmin)->send(new NouvelleInscriptionProfesseurAdmin($emailDataAdmin));
            }

            DB::commit();

            $this->registrationComplete = true;

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'inscription : ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tutoring.register-professeur', [
            'matieresList' => $this->availableMatieres,
            'niveauxList' => $this->availableNiveaux,
        ]);
    }
}