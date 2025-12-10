<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use App\Models\Shared\Intervenant;
use App\Models\SoutienScolaire\Professeur;
use App\Models\Shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

    // Étape 4 : Documents
    public $cinDocument = null; // Document CIN (fichier)
    public $diplome = null;
    public $photo = null;
    public $niveauEtudes = '';

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
                'matieres.*.matiere_id' => 'required|exists:matieres,id_matiere',
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
        'CIN.required' => 'Le numéro CIN est obligatoire',
        'cinDocument.required' => 'Le document CIN est obligatoire',
        'cinDocument.mimes' => 'Le CIN doit être au format PDF, JPG ou PNG',
        'cinDocument.max' => 'Le fichier CIN ne doit pas dépasser 5MB',
    ];

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function nextStep()
    {
        $this->validate();
        
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function addMatiere()
    {
        $this->matieres[] = [
            'matiere_id' => '',
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
                'statut' => 'EN_ATTENTE',
                'idIntervenant' => $user->idUser,
                'idAdmin' => $admin->idAdmin,
            ]);

            // 4. Créer la localisation avec latitude et longitude
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
            $cinDocumentPath = null;
            $diplomePath = null;
            $photoPath = null;

            if ($this->cinDocument) {
                $cinDocumentPath = $this->cinDocument->store('cin_documents', 'public');
            }

            if ($this->diplome) {
                $diplomePath = $this->diplome->store('diplomes', 'public');
            }

            if ($this->photo) {
                $photoPath = $this->photo->store('photos', 'public');
                $user->update(['photo' => $photoPath]);
            }

            // 6. Créer le professeur
            $professeur = Professeur::create([
                'cin_document' => $cinDocumentPath, // Chemin du document CIN
                'surnom' => $this->surnom,
                'biographie' => $this->biographie,
                'diplome' => $diplomePath,
                'niveau_etudes' => $this->niveauEtudes,
                'intervenant_id' => $intervenant->idIntervenant,
            ]);

            // 7. Créer les services professeur
            foreach ($this->matieres as $matiere) {
                \App\Models\SoutienScolaire\ServiceProf::create([
                    'titre' => $matiere['titre'] ?? 'Cours de matière',
                    'description' => $matiere['description'] ?? '',
                    'prix_par_heure' => $matiere['prix_par_heure'],
                    'status' => 'actif',
                    'type_service' => $matiere['type_service'] ?? 'enligne',
                    'professeur_id' => $professeur->id_professeur,
                    'matiere_id' => $matiere['matiere_id'],
                    'niveau_id' => $matiere['niveau_id'],
                ]);
            }

            DB::commit();

            // Afficher la page de succès
            $this->registrationComplete = true;

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l\'inscription : ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tutoring.register-professeur');
    }
}