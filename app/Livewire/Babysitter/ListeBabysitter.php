<?php

namespace App\Livewire\Babysitter;

use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class ListeBabysitter extends Component
{
    use WithPagination;

    public $search = '';
    public $priceMin = 30;
    public $priceMax = 250; // Augmenté de 150 à 250 DH
    public $ville = '';
    public $experience = null;
    public $non_fumeur = false;
    public $permis_conduire = false;
    public $voiture = false; // Nouveau filtre
    public $possede_enfant = false; // Nouveau filtre
    public $preference_domicile = ''; // Nouveau filtre
    public $selectedServices = [];
    public $selectedFormations = []; // Nouveau filtre
    public $selectedCategories = []; // Nouveau filtre
    public $selectedExperiences = []; // Nouveau filtre
    public $babysittersWithLocation = [];
    public $showMap = false;

    protected $queryString = ['search', 'priceMin', 'priceMax', 'ville', 'experience'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPriceMin()
    {
        $this->resetPage();
    }

    public function updatingPriceMax()
    {
        $this->resetPage();
    }

    public function updatingVille()
    {
        $this->resetPage();
    }

    public function updatingNonFumeur()
    {
        $this->resetPage();
    }

    public function updatingPermisConduire()
    {
        $this->resetPage();
    }

    public function updatingSelectedServices()
    {
        $this->resetPage();
    }

    public function updatingVoiture()
    {
        $this->resetPage();
    }

    public function updatingPossedeEnfant()
    {
        $this->resetPage();
    }

    public function updatingPreferenceDomicile()
    {
        $this->resetPage();
    }

    public function updatingSelectedFormations()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingSelectedExperiences()
    {
        $this->resetPage();
    }

    public function toggleService($serviceId)
    {
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_filter($this->selectedServices, fn($id) => $id !== $serviceId);
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }

    public function toggleFormation($formationId)
    {
        if (in_array($formationId, $this->selectedFormations)) {
            $this->selectedFormations = array_filter($this->selectedFormations, fn($id) => $id !== $formationId);
        } else {
            $this->selectedFormations[] = $formationId;
        }
    }

    public function toggleCategorie($categorieId)
    {
        if (in_array($categorieId, $this->selectedCategories)) {
            $this->selectedCategories = array_filter($this->selectedCategories, fn($id) => $id !== $categorieId);
        } else {
            $this->selectedCategories[] = $categorieId;
        }
    }

    public function toggleExperience($experienceId)
    {
        if (in_array($experienceId, $this->selectedExperiences)) {
            $this->selectedExperiences = array_filter($this->selectedExperiences, fn($id) => $id !== $experienceId);
        } else {
            $this->selectedExperiences[] = $experienceId;
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->priceMin = 30;
        $this->priceMax = 250; // Mis à jour
        $this->ville = '';
        $this->experience = null;
        $this->non_fumeur = false;
        $this->permis_conduire = false;
        $this->voiture = false;
        $this->possede_enfant = false;
        $this->preference_domicile = '';
        $this->selectedServices = [];
        $this->selectedFormations = [];
        $this->selectedCategories = [];
        $this->selectedExperiences = [];
        $this->resetPage();
    }

    public function toggleMap()
    {
        $this->showMap = !$this->showMap;
    }

    public function render()
    {
        $query = Babysitter::with([
            'intervenant.utilisateur.localisations',
            'intervenant.disponibilites',
            'superpouvoirs',
            'formations',
            'categoriesEnfants',
            'experiencesBesoinsSpeciaux'
        ])->valide();
      
    

        // Filtre par prix
        if ($this->priceMin && $this->priceMin > 0) {
            $query->where('prixHeure', '>=', $this->priceMin);
        }
        if ($this->priceMax && $this->priceMax > 0) {
            $query->where('prixHeure', '<=', $this->priceMax);
        }

        // Filtre par ville
        if ($this->ville) {
            $query->whereHas('intervenant.utilisateur.localisations', function ($q) {
                $q->where('ville', 'LIKE', "%{$this->ville}%");
            });
        }

        // Filtre par expérience
        if ($this->experience) {
            $query->where('expAnnee', '>=', $this->experience);
        }

        // Filtre par caractéristiques
        if ($this->non_fumeur) {
            $query->where('estFumeur', false);
        }

        if ($this->permis_conduire) {
            $query->where('permisConduite', true);
        }

        if ($this->voiture) {
            $query->where('mobilite', true);
        }

        if ($this->possede_enfant) {
            $query->where('possedeEnfant', true);
        }

        // Filtre par formations
        if (!empty($this->selectedServices)) {
            $query->whereHas('superpouvoirs', function ($q) {
                $q->whereIn('superpouvoirs.idSuperpouvoir', $this->selectedServices);
            }, '=', count($this->selectedServices));
        }

        // Nouveaux filtres
        if ($this->voiture) {
            $query->where('mobilite', true);
        }

        if ($this->possede_enfant) {
            $query->where('possedeEnfant', true);
        }

        if ($this->preference_domicile) {
            $query->where('preference_domicil', $this->preference_domicile);
        }

        // Filtre par formations
        if (!empty($this->selectedFormations)) {
            $query->whereHas('formations', function ($q) {
                $q->whereIn('formations.idFormation', $this->selectedFormations);
            }, '=', count($this->selectedFormations));
        }

        // Filtre par catégories d'enfants
        if (!empty($this->selectedCategories)) {
            $query->whereHas('categoriesEnfants', function ($q) {
                $q->whereIn('categorie_enfants.idCategorie', $this->selectedCategories);
            }, '=', count($this->selectedCategories));
        }

        // Filtre par expériences besoins spéciaux
        if (!empty($this->selectedExperiences)) {
            $query->whereHas('experiencesBesoinsSpeciaux', function ($q) {
                $q->whereIn('experience_besoins_speciaux.idExperience', $this->selectedExperiences);
            }, '=', count($this->selectedExperiences));
        }

    // Filtre par recherche (nom/prénom/quartier/ville)
        if ($this->search) {
            $query->where(function($subQuery) {
                $subQuery->whereHas('intervenant.utilisateur', function ($q) {
                    $q->where('nom', 'LIKE', "%{$this->search}%")
                      ->orWhere('prenom', 'LIKE', "%{$this->search}%");
                })->orWhereHas('intervenant.utilisateur.localisations', function ($q) {
                    $q->where('adresse', 'LIKE', "%{$this->search}%")
                      ->orWhere('ville', 'LIKE', "%{$this->search}%");
                });
            });
        }

        $babysitters = $query->paginate(15);

        // Récupérer les babysitters avec localisation pour la carte
        $locationData = DB::table('babysitters')
            ->join('intervenants', 'babysitters.idBabysitter', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('intervenants.statut', 'VALIDE')
            ->select('babysitters.idBabysitter', 'utilisateurs.prenom', 'utilisateurs.nom', 
                     'localisations.latitude', 'localisations.longitude', 'localisations.ville', 
                     'babysitters.prixHeure', 'utilisateurs.photo', 'utilisateurs.note')
            ->get();

        $this->babysittersWithLocation = $locationData->filter(function($babysitter) {
            return $babysitter->latitude && $babysitter->longitude;
        });

        // Debug: Vérifier combien ont des coordonnées
        \Log::info('Babysitters avec coordonnées: ' . $this->babysittersWithLocation->count());

        // Récupérer tous les services pour le filtre
        $allServices = Superpouvoir::all();
        $allFormations = Formation::all();
        $allCategories = CategorieEnfant::all();
        $allExperiences = ExperienceBesoinSpeciaux::all();

        // Villes disponibles
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Fes', 'Agadir'];

        // Compter le nombre total de babysitters disponibles
        $totalBabysitters = Babysitter::valide()->count();

        return view('livewire.babysitter.liste-babysitter', [
            'babysitters' => $babysitters,
            'allServices' => $allServices,
            'allFormations' => $allFormations,
            'allCategories' => $allCategories,
            'allExperiences' => $allExperiences,
            'villes' => $villes,
            'totalBabysitters' => $totalBabysitters,
            'babysittersWithLocation' => $this->babysittersWithLocation,
        ]);
    }
}