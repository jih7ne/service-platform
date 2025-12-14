<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;
use App\Models\Shared\Localisation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BabysitterProfile extends Component
{
    use WithFileUploads;

    public $babysitter;
    public $utilisateur;
    public $intervenant;
    public $localisations;

    // Personal Information
    public $nom, $prenom, $email, $telephone, $dateNaissance, $photo;
    public $newPhoto;

    // Professional Information
    public $prixHeure, $expAnnee, $langues = [], $description, $niveauEtudes;
    public $procedeJuridique, $coprocultureSelles, $certifAptitudeMentale, $radiographieThorax;
    public $maladies, $estFumeur, $mobilite, $possedeEnfant, $permisConduite, $preference_domicil;

    // Skills and Activities
    public $selectedSuperpouvoirs = [];
    public $selectedFormations = [];
    public $selectedCategories = [];
    public $selectedExperiences = [];

    // Available options
    public $allSuperpouvoirs;
    public $allFormations;
    public $allCategories;
    public $allExperiences;

    // Location
    public $adresse, $ville;
    public $latitude, $longitude;

    // Edit modes
    public $editPersonalInfo = false;
    public $editProfessionalInfo = false;
    public $editSkills = false;
    public $editLocation = false;

    protected $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telephone' => 'required|string|max:20',
        'dateNaissance' => 'required|date|before:today',
        'prixHeure' => 'required|numeric|min:0',
        'expAnnee' => 'required|integer|min:0',
        'description' => 'nullable|string|max:1000',
        'niveauEtudes' => 'nullable|string|max:255',
        'maladies' => 'nullable|string|max:500',
        'adresse' => 'nullable|string|max:255',
        'ville' => 'nullable|string|max:100',
        'newPhoto' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->loadProfileData();
        $this->loadAvailableOptions();
    }

    private function loadProfileData()
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'intervenant') {
            return;
        }

        $this->utilisateur = $user;
        $this->intervenant = $user->intervenant;
        $this->babysitter = $this->intervenant?->babysitter;

        if (!$this->babysitter) {
            return;
        }

        // Load personal information
        $this->nom = $this->utilisateur->nom;
        $this->prenom = $this->utilisateur->prenom;
        $this->email = $this->utilisateur->email;
        $this->telephone = $this->utilisateur->telephone;
        $this->dateNaissance = $this->utilisateur->dateNaissance?->format('Y-m-d');
        $this->photo = $this->utilisateur->photo;

        // Load professional information
        $this->prixHeure = $this->babysitter->prixHeure;
        $this->expAnnee = $this->babysitter->expAnnee;
        $this->langues = $this->babysitter->langues ?? [];
        $this->description = $this->babysitter->description;
        $this->niveauEtudes = $this->babysitter->niveauEtudes;
        $this->procedeJuridique = $this->babysitter->procedeJuridique;
        $this->coprocultureSelles = $this->babysitter->coprocultureSelles;
        $this->certifAptitudeMentale = $this->babysitter->certifAptitudeMentale;
        $this->radiographieThorax = $this->babysitter->radiographieThorax;
        $this->maladies = $this->babysitter->maladies;
        $this->estFumeur = $this->babysitter->estFumeur;
        $this->mobilite = $this->babysitter->mobilite;
        $this->possedeEnfant = $this->babysitter->possedeEnfant;
        $this->permisConduite = $this->babysitter->permisConduite;
        $this->preference_domicil = $this->babysitter->preference_domicil;

        // Load skills
        $this->selectedSuperpouvoirs = $this->babysitter->superpouvoirs->pluck('idSuperpouvoir')->toArray();
        $this->selectedFormations = $this->babysitter->formations->pluck('idFormation')->toArray();
        $this->selectedCategories = $this->babysitter->categoriesEnfants->pluck('idCategorie')->toArray();
        $this->selectedExperiences = $this->babysitter->experiencesBesoinsSpeciaux->pluck('idExperience')->toArray();

        // Load location
        $this->loadLocationData();
    }

    private function loadLocationData()
    {
        $location = $this->utilisateur->localisations()->first();
        if ($location) {
            $this->adresse = $location->adresse;
            $this->ville = $location->ville;
            $this->latitude = $location->latitude;
            $this->longitude = $location->longitude;
        }
    }

    private function loadAvailableOptions()
    {
        $this->allSuperpouvoirs = Superpouvoir::all();
        $this->allFormations = Formation::all();
        $this->allCategories = CategorieEnfant::all();
        $this->allExperiences = ExperienceBesoinSpeciaux::all();
    }

    public function savePersonalInfo()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('utilisateurs', 'email')->ignore($this->utilisateur->idUser, 'idUser')],
            'telephone' => 'required|string|max:20',
            'dateNaissance' => 'required|date|before:today',
        ]);

        // Handle photo upload
        if ($this->newPhoto) {
            $this->photo = $this->newPhoto->store('photos', 'public');
        }

        $this->utilisateur->update([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'dateNaissance' => $this->dateNaissance,
            'photo' => $this->photo,
        ]);

        $this->editPersonalInfo = false;
        $this->dispatch('showMessage', 'Informations personnelles mises à jour avec succès');
    }

    public function saveProfessionalInfo()
    {
        $this->validate([
            'prixHeure' => 'required|numeric|min:0',
            'expAnnee' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'niveauEtudes' => 'nullable|string|max:255',
            'maladies' => 'nullable|string|max:500',
        ]);

        $this->babysitter->update([
            'prixHeure' => $this->prixHeure,
            'expAnnee' => $this->expAnnee,
            'langues' => $this->langues,
            'description' => $this->description,
            'niveauEtudes' => $this->niveauEtudes,
            'procedeJuridique' => $this->procedeJuridique,
            'coprocultureSelles' => $this->coprocultureSelles,
            'certifAptitudeMentale' => $this->certifAptitudeMentale,
            'radiographieThorax' => $this->radiographieThorax,
            'maladies' => $this->maladies,
            'estFumeur' => $this->estFumeur,
            'mobilite' => $this->mobilite,
            'possedeEnfant' => $this->possedeEnfant,
            'permisConduite' => $this->permisConduite,
            'preference_domicil' => $this->preference_domicil,
        ]);

        $this->editProfessionalInfo = false;
        $this->dispatch('showMessage', 'Informations professionnelles mises à jour avec succès');
    }

    public function saveSkills()
    {
        // Sync skills
        $this->babysitter->superpouvoirs()->sync($this->selectedSuperpouvoirs);
        $this->babysitter->formations()->sync($this->selectedFormations);
        $this->babysitter->categoriesEnfants()->sync($this->selectedCategories);
        $this->babysitter->experiencesBesoinsSpeciaux()->sync($this->selectedExperiences);

        $this->editSkills = false;
        $this->dispatch('showMessage', 'Compétences mises à jour avec succès');
    }

    public function saveLocation()
    {
        $this->validate([
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
        ]);

        // Delete existing location
        $this->utilisateur->localisations()->delete();

        // Create new location if any field is filled
        if ($this->adresse || $this->ville) {
            $this->utilisateur->localisations()->create([
                'adresse' => $this->adresse,
                'ville' => $this->ville,
            ]);
        }

        $this->editLocation = false;
        $this->dispatch('showMessage', 'Localisation mise à jour avec succès');
    }

    public function cancelEdit($section)
    {
        switch ($section) {
            case 'personal':
                $this->editPersonalInfo = false;
                $this->loadProfileData();
                break;
            case 'professional':
                $this->editProfessionalInfo = false;
                $this->loadProfileData();
                break;
            case 'skills':
                $this->editSkills = false;
                $this->loadProfileData();
                break;
            case 'location':
                $this->editLocation = false;
                $this->loadProfileData();
                break;
        }
    }

    public function getLevelAttribute()
    {
        $completedSittings = $this->babysitter?->demandes()
            ->whereIn('statut', ['validée', 'terminée'])
            ->count() ?? 0;

        return min(12, floor($completedSittings / 10) + 1);
    }

    public function getIsExpertAttribute()
    {
        return ($this->utilisateur->note ?? 0) >= 4.5 && $this->level >= 8;
    }

    public function getMapData()
    {
        $location = $this->utilisateur->localisations()->first();
        
        if ($location && $location->latitude && $location->longitude) {
            return [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'address' => $location->adresse . ', ' . $location->ville,
                'hasLocation' => true
            ];
        }
        
        // Coordonnées par défaut pour Casablanca si pas de localisation
        return [
            'latitude' => 33.5731,
            'longitude' => -7.5898,
            'address' => $this->adresse . ', ' . $this->ville ?: 'Casablanca, Maroc',
            'hasLocation' => false
        ];
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-profile');
    }
}