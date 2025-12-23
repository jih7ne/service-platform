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
    public $auto_localisation = false;

    // Edit modes
    public $editPersonalInfo = false;
    public $editProfessionalInfo = false;
    public $editSkills = false;
    public $editLocation = false;

    // Statistics
    public $statistics = [];

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
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'newPhoto' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->loadProfileData();
        $this->loadAvailableOptions();
        $this->calculateStatistics();
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
        $this->procedeJuridique = (bool) $this->babysitter->procedeJuridique;
        $this->coprocultureSelles = (bool) $this->babysitter->coprocultureSelles;
        $this->certifAptitudeMentale = (bool) $this->babysitter->certifAptitudeMentale;
        $this->radiographieThorax = (bool) $this->babysitter->radiographieThorax;
        $this->maladies = $this->babysitter->maladies;
        $this->estFumeur = (bool) $this->babysitter->estFumeur;
        $this->mobilite = (bool) $this->babysitter->mobilite;
        $this->possedeEnfant = (bool) $this->babysitter->possedeEnfant;
        $this->permisConduite = (bool) $this->babysitter->permisConduite;
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

    public function updatedAutoLocalisation($value)
    {
        // Quand l'utilisateur active la géolocalisation, on déclenche le JS
        if ($value) {
            $this->dispatch('getLocation');
        }
    }

    public function setLocation($latitude, $longitude, $ville, $adresse = '')
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ville = $ville;
        $this->adresse = $adresse;
    }

    private function loadAvailableOptions()
    {
        $this->allSuperpouvoirs = Superpouvoir::all();
        $this->allFormations = Formation::all();
        $this->allCategories = CategorieEnfant::all();
        $this->allExperiences = ExperienceBesoinSpeciaux::all();
    }

    private function calculateStatistics()
    {
        if (!$this->babysitter) {
            $this->statistics = [
                'completedSittings' => 0,
                'averageRating' => 0,
                'pendingRequests' => 0,
                'totalEarnings' => 0,
                'responseRate' => 0,
                'onTimeRate' => 0,
            ];
            return;
        }

        $completedSittings = $this->babysitter->demandes()
            ->whereIn('statut', ['validée', 'terminée'])
            ->count();

        $feedbacks = $this->utilisateur->feedbacksRecus()->where('estVisible', true)->get();
        $reviewCount = $feedbacks->count();
        $averageRating = 0;

        if ($reviewCount > 0) {
            $totalRating = $feedbacks->sum(function ($feedback) {
                return ($feedback->credibilite + $feedback->sympathie + $feedback->ponctualite + $feedback->proprete + $feedback->qualiteTravail) / 5;
            });
            $averageRating = round($totalRating / $reviewCount, 1);
        }

        $pendingRequests = $this->babysitter->demandes()
            ->where('statut', 'en_attente')
            ->count();

        $totalEarnings = $this->babysitter->demandes()
            ->whereIn('statut', ['validée', 'terminée'])
            ->get()
            ->sum(function ($demande) {
                return $demande->prix; // Utilise l'accesseur getPrixAttribute()
            });

        $this->statistics = [
            'completedSittings' => $completedSittings,
            'averageRating' => $averageRating,
            'reviewCount' => $reviewCount,
            'pendingRequests' => $pendingRequests,
            'totalEarnings' => $totalEarnings,
            'responseRate' => 85, // Placeholder - calculate based on actual response data
            'onTimeRate' => 90, // Placeholder - calculate based on actual punctuality data
        ];
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
        $this->calculateStatistics();
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

        // Ensure boolean values are properly cast
        $this->babysitter->update([
            'prixHeure' => $this->prixHeure,
            'expAnnee' => $this->expAnnee,
            'langues' => $this->langues,
            'description' => $this->description,
            'niveauEtudes' => $this->niveauEtudes,
            'procedeJuridique' => (bool) $this->procedeJuridique,
            'coprocultureSelles' => (bool) $this->coprocultureSelles,
            'certifAptitudeMentale' => (bool) $this->certifAptitudeMentale,
            'radiographieThorax' => (bool) $this->radiographieThorax,
            'maladies' => $this->maladies,
            'estFumeur' => (bool) $this->estFumeur,
            'mobilite' => (bool) $this->mobilite,
            'possedeEnfant' => (bool) $this->possedeEnfant,
            'permisConduite' => (bool) $this->permisConduite,
            'preference_domicil' => $this->preference_domicil,
        ]);

        $this->editProfessionalInfo = false;
        $this->calculateStatistics();
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
        $this->calculateStatistics();
        $this->dispatch('showMessage', 'Compétences mises à jour avec succès');
    }

    public function saveLocation()
    {
        $rules = [
            'ville' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];

        if (!$this->auto_localisation) {
            $rules['adresse'] = 'required|string|max:255';
        } else {
            $rules['adresse'] = 'nullable|string|max:255';
        }

        $this->validate($rules);

        // Delete existing location
        $this->utilisateur->localisations()->delete();

        // Create new location if any field is filled
        if ($this->adresse || $this->ville) {
            // Use provided coordinates or defaults
            $latitude = $this->latitude ?: 31.791702; // Default: center of Morocco
            $longitude = $this->longitude ?: -7.092600;

            $this->utilisateur->localisations()->create([
                'adresse' => $this->adresse,
                'ville' => $this->ville,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }

        $this->editLocation = false;
        $this->calculateStatistics();
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

    public function enableEdit($section)
    {
        switch ($section) {
            case 'personal':
                $this->editPersonalInfo = true;
                break;
            case 'professional':
                $this->editProfessionalInfo = true;
                break;
            case 'skills':
                $this->editSkills = true;
                break;
            case 'location':
                $this->editLocation = true;
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
        return ($this->statistics['averageRating'] ?? 0) >= 4.5 && $this->level >= 8;
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-profile');
    }
}