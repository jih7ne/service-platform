<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\shared\Utilisateur;
use App\Models\shared\Intervenant;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\PreferenceDomicil;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\shared\Disponibilite;
use App\Models\shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BabysitterRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 5;

    // Étape 1
    public $prenom, $nom, $email, $date_naissance;
    public $mot_de_passe, $mot_de_passe_confirmation;
    public $je_fume = false, $jai_enfants = false;
    public $permis_conduire = false, $jai_voiture = false;

    // Étape 2
    public $telephone, $adresse, $photo_profil;
    public $latitude, $longitude, $ville;

    // Étape 3
    public $prix_horaire, $annees_experience, $niveau_etudes;
    public $description, $experience_detaillee;
    public $langues = [];
    public $categories_enfants = [];

    // Étape 4
    public $certifications = [];
    public $superpowers = [];
    public $disponibilites = [];

    // Étape 5
    public $radiographie_thorax, $coproculture_selles;
    public $certificat_aptitude, $casier_judiciaire;

    public function mount()
    {
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        foreach ($jours as $jour) {
            $this->disponibilites[$jour] = [];
        }
    }

    public function rules()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email|unique:utilisateurs,email',
                'date_naissance' => 'required|date|before:today',
                'mot_de_passe' => 'required|min:8|confirmed',
            ];
        }

        if ($this->currentStep == 2) {
            $rules = [
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:500',
                'photo_profil' => 'nullable|image|max:5120',
            ];
        }

        if ($this->currentStep == 3) {
            $rules = [
                'prix_horaire' => 'required|numeric|min:0',
                'annees_experience' => 'required|string',
                'niveau_etudes' => 'required|string|max:500',
                'description' => 'required|string|max:1000',
                'experience_detaillee' => 'required|string|max:2000',
                'langues' => 'required|array|min:1',
            ];
        }

        if ($this->currentStep == 5) {
            $rules = [
                'casier_judiciaire' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'radiographie_thorax' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'coproculture_selles' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'certificat_aptitude' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas',
            'telephone.required' => 'Le téléphone est obligatoire',
            'adresse.required' => 'L\'adresse est obligatoire',
            'prix_horaire.required' => 'Le prix horaire est obligatoire',
            'annees_experience.required' => 'Les années d\'expérience sont obligatoires',
            'niveau_etudes.required' => 'Le niveau d\'études est obligatoire',
            'description.required' => 'La description est obligatoire',
            'experience_detaillee.required' => 'L\'expérience détaillée est obligatoire',
            'langues.required' => 'Sélectionnez au moins une langue',
            'casier_judiciaire.required' => 'Le casier judiciaire est obligatoire',
        ];
    }

    public function suivant()
    {
        // Valider seulement si des règles existent pour cette étape
        $rules = $this->rules();
        if (!empty($rules)) {
            $this->validate();
        }
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function precedent()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function ajouterDisponibilite($jour)
    {
        $this->disponibilites[$jour][] = ['debut' => '', 'fin' => ''];
    }

    public function supprimerDisponibilite($jour, $index)
    {
        unset($this->disponibilites[$jour][$index]);
        $this->disponibilites[$jour] = array_values($this->disponibilites[$jour]);
    }

    public function finaliser()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // 1. Créer l'utilisateur
            $photoPath = null;
            if ($this->photo_profil) {
                $photoPath = $this->photo_profil->store('babysitters/photos', 'public');
            }

            $utilisateur = Utilisateur::create([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'password' => Hash::make($this->mot_de_passe),
                'telephone' => $this->telephone,
                'dateNaissance' => $this->date_naissance,
                'role' => 'intervenant',
                'statut' => 'actif',
                'photo' => $photoPath,
            ]);

            // 2. Créer la localisation (optionnel)
            if ($this->adresse) {
                Localisation::create([
                    'idUser' => $utilisateur->idUser,
                    'latitude' => $this->latitude ?? 0,
                    'longitude' => $this->longitude ?? 0,
                    'ville' => $this->ville ?? '',
                    'adresse' => $this->adresse,
                ]);
            }

            // 3. Créer l'intervenant
            $intervenant = new Intervenant();
            $intervenant->IdIntervenant = $utilisateur->idUser;
            $intervenant->statut = 'EN_ATTENTE';
            $intervenant->save();

            // 4. Upload des documents
            $procedeJuridique = null;
            $coprocultureSelles = null;
            $certifAptitude = null;
            $radiographieThorax = null;

            if ($this->casier_judiciaire) {
                $procedeJuridique = $this->casier_judiciaire->store('babysitters/documents', 'public');
            }
            if ($this->coproculture_selles) {
                $coprocultureSelles = $this->coproculture_selles->store('babysitters/documents', 'public');
            }
            if ($this->certificat_aptitude) {
                $certifAptitude = $this->certificat_aptitude->store('babysitters/documents', 'public');
            }
            if ($this->radiographie_thorax) {
                $radiographieThorax = $this->radiographie_thorax->store('babysitters/documents', 'public');
            }

            // 5. Créer le profil babysitter
            // Convertir les années d'expérience en nombre
            $expAnneeInt = 0;
            switch($this->annees_experience) {
                case '0-1':
                    $expAnneeInt = 0;
                    break;
                case '1-3':
                    $expAnneeInt = 2;
                    break;
                case '3-5':
                    $expAnneeInt = 4;
                    break;
                case '5+':
                    $expAnneeInt = 5;
                    break;
            }

            $babysitter = new Babysitter();
            $babysitter->idBabysitter = $intervenant->IdIntervenant;
            $babysitter->prixHeure = $this->prix_horaire;
            $babysitter->expAnnee = $expAnneeInt;
            $babysitter->niveauEtudes = $this->niveau_etudes;
            $babysitter->description = $this->description;
            $babysitter->langues = json_encode($this->langues);
            $babysitter->procedeJuridique = $procedeJuridique;
            $babysitter->coprocultureSelles = $coprocultureSelles;
            $babysitter->certifAptitudeMentale = $certifAptitude;
            $babysitter->radiographieThorax = $radiographieThorax;
            $babysitter->estFumeur = $this->je_fume;
            $babysitter->mobilite = $this->jai_voiture;
            $babysitter->possedeEnfant = $this->jai_enfants;
            $babysitter->permisConduite = $this->permis_conduire;
            $babysitter->maladies = $this->experience_detaillee;
            $babysitter->save();

            // Récupérer l'ID du babysitter (qui est le même que IdIntervenant)
            $idBabysitter = $intervenant->IdIntervenant;

            // 6. Associer les catégories d'enfants
            if (!empty($this->categories_enfants)) {
                foreach ($this->categories_enfants as $categorieNom) {
                    $categorie = CategorieEnfant::firstOrCreate(['categorie' => $categorieNom]);
                    DB::table('choisir_categories')->insert([
                        'idCategorie' => $categorie->idCategorie,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 7. Associer les formations/certifications
            if (!empty($this->certifications)) {
                foreach ($this->certifications as $formationNom) {
                    $formation = Formation::firstOrCreate(['formation' => $formationNom]);
                    DB::table('choisir_formations')->insert([
                        'idFormation' => $formation->idFormation,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 8. Associer les superpourvoirs
            if (!empty($this->superpowers)) {
                foreach ($this->superpowers as $superpouvoirNom) {
                    $superpouvoir = Superpouvoir::firstOrCreate(['superpouvoir' => $superpouvoirNom]);
                    DB::table('choisir_superpourvoirs')->insert([
                        'idSuperpouvoir' => $superpouvoir->idSuperpouvoir,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 9. Créer les disponibilités
            $jourMapping = [
                'lundi' => 'Lundi',
                'mardi' => 'Mardi',
                'mercredi' => 'Mercredi',
                'jeudi' => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi' => 'Samedi',
                'dimanche' => 'Dimanche',
            ];

            foreach ($this->disponibilites as $jour => $plages) {
                if (!empty($plages)) {
                    foreach ($plages as $plage) {
                        if (!empty($plage['debut']) && !empty($plage['fin'])) {
                            Disponibilite::create([
                                'idIntervenant' => $intervenant->IdIntervenant,
                                'jourSemaine' => $jourMapping[$jour],
                                'heureDebut' => $plage['debut'],
                                'heureFin' => $plage['fin'],
                                'est_reccurent' => true,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            session()->flash('success', 'Inscription réussie ! Votre profil est en attente de validation par un administrateur.');
            
            return redirect()->to('/connexion');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage());
            
            return;
        }
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-registration');
    }
}