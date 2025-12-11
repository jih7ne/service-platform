<?php

namespace App\Livewire\Babysitter;

use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Superpouvoir;
use Livewire\Component;
use Livewire\WithPagination;

class ListeBabysitter extends Component
{
    use WithPagination;

    public $search = '';
    public $priceMin = 30;
    public $priceMax = 150;
    public $ville = '';
    public $experience = null;
    public $non_fumeur = false;
    public $permis_conduire = false;
    public $selectedServices = [];

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

    public function toggleService($serviceId)
    {
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_filter($this->selectedServices, fn($id) => $id !== $serviceId);
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->priceMin = 30;
        $this->priceMax = 150;
        $this->ville = '';
        $this->experience = null;
        $this->non_fumeur = false;
        $this->permis_conduire = false;
        $this->selectedServices = [];
        $this->resetPage();
    }

    public function render()
    {
        $query = Babysitter::with([
            'intervenant.utilisateur.localisations',
            'intervenant.disponibilites',
            'superpouvoirs'
        ]);

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

        // Filtre par services (superpouvoirs)
        if (!empty($this->selectedServices)) {
            $query->whereHas('superpouvoirs', function ($q) {
                $q->whereIn('idSuperpouvoir', $this->selectedServices);
            }, '=', count($this->selectedServices));
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

        // Récupérer tous les services pour le filtre
        $allServices = Superpouvoir::all();

        // Villes disponibles
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Tanger', 'Fes', 'Agadir'];

        // Compter le nombre total de babysitters disponibles
        $totalBabysitters = Babysitter::count();

        return view('livewire.babysitter.liste-babysitter', [
            'babysitters' => $babysitters,
            'allServices' => $allServices,
            'villes' => $villes,
            'totalBabysitters' => $totalBabysitters,
        ]);
    }
}
