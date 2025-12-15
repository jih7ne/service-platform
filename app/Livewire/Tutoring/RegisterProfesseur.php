<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use App\Models\Shared\Intervenant;
use App\Models\SoutienScolaire\Professeur;
use App\Models\SoutienScolaire\Matiere;
use App\Models\SoutienScolaire\Niveau;
use App\Models\Shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\Tutoring\InscriptionProfesseurEnCours;
use App\Mail\Tutoring\NouvelleInscriptionProfesseurAdmin;
use App\Mail\Tutoring\VerificationCodeEmail;
use Carbon\Carbon;

class RegisterProfesseur extends Component
{
    use WithFileUploads;

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
        // Charger les matières et niveaux disponibles
        $this->availableMatieres = Matiere::all();
        $this->availableNiveaux = Niveau::all();
    }

    protected function rules()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'firstName' => 'required|min:2|max:50',
                'lastName' => 'required|min:2|max:50',
                'email' => 'required|email|unique:utilisateurs,email',
                'password' => 'required|min:8',
                'telephone' => 'required|min:10|max:20',
                'dateNaissance' => 'required|date|before:today',
            ];
        } elseif ($this->currentStep == 1.5) {
            $rules = [
                'verificationCode' => 'required|size:10',
            ];
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

    public function sendVerificationCode()
    {
        // Valider uniquement les champs de l'étape 1
        $this->validate([
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|min:2|max:50',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
        ]);

        // Générer un code à 10 chiffres
        $this->generatedCode = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        
        // Stocker le code en cache pour 10 minutes
        Cache::put('verification_code_' . $this->email, $this->generatedCode, now()->addMinutes(10));
        
        // Envoyer l'email
        Mail::to($this->email)->send(new VerificationCodeEmail($this->generatedCode, $this->firstName));
        
        // Passer à l'étape de vérification
        $this->currentStep = 1.5;
        
        session()->flash('success', 'Code de vérification envoyé à ' . $this->email);
    }

    public function verifyCode()
    {
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

        // Code correct
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
            $this->sendVerificationCode();
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
                'statut' => 'VALIDE',
                'idIntervenant' => $user->idUser,
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

            // 5. Upload des fichiers
            $cinDocumentPath = $this->cinDocument ? $this->cinDocument->store('cin_documents', 'public') : null;
            $diplomePath = $this->diplome ? $this->diplome->store('diplomes', 'public') : null;
            $photoPath = $this->photo ? $this->photo->store('photos', 'public') : null;

            if ($photoPath) {
                $user->update(['photo' => $photoPath]);
            }

            // 6. Créer le professeur
            $professeur = Professeur::create([
                'cin_document' => $cinDocumentPath,
                'surnom' => $this->surnom,
                'biographie' => $this->biographie,
                'diplome' => $diplomePath,
                'niveau_etudes' => $this->niveauEtudes,
                'intervenant_id' => $intervenant->idIntervenant,
            ]);

            // 7. Créer les services professeur
            $matieresData = [];
            foreach ($this->matieres as $matiere) {
                // Si "Autre" est sélectionné, créer une nouvelle matière
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

                // Récupérer les noms pour l'email
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

            // Email aux admins
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