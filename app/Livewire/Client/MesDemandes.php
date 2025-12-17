<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

class MesDemandes extends Component
{
    use WithPagination;

    // Filtres
    public $search = '';
    public $filtreService = '';
    public $filtreStatut = '';

    // Modal
    public $selectedDemande = null;
    public $showModal = false;
    public $animalDetails = null;

    // Pour le select de filtre
    public $servicesList = [];

    public function mount()
    {
        $this->servicesList = DB::table('services')->get();
    }

    // Reset pagination quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFiltreService() { $this->resetPage(); }
    public function updatedFiltreStatut() { $this->resetPage(); }

    public function openModal($id)
    {
        // 1. Récupération de la demande de base
        $this->selectedDemande = DB::table('demandes_intervention')
            // MODIFICATION ICI : leftJoin au lieu de join pour éviter les erreurs si le service n'existe plus
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->leftJoin('utilisateurs', 'demandes_intervention.idIntervenant', '=', 'utilisateurs.idUser')
            ->select(
                'demandes_intervention.*',
                'services.nomService',
                'services.description as desc_service',
                'utilisateurs.prenom as prenom_intervenant',
                'utilisateurs.nom as nom_intervenant',
                'utilisateurs.photo as photo_intervenant',
                'utilisateurs.telephone as tel_intervenant'
            )
            ->where('demandes_intervention.idDemande', $id)
            ->first();

        // 2. Si c'est une garde d'animaux, on cherche l'animal
        $this->animalDetails = null;
        $pivotAnimal = DB::table('animal_demande')->where('idDemande', $id)->first();
        
        if ($pivotAnimal) {
            $this->animalDetails = DB::table('animals')
                ->where('idAnimale', $pivotAnimal->idAnimal)
                ->first();
        }

        // Calcul du prix estimatif
        if ($this->selectedDemande) {
            $this->selectedDemande->prix_estime = $this->calculerPrix(
                $this->selectedDemande->heureDebut, 
                $this->selectedDemande->heureFin
            );
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedDemande = null;
        $this->animalDetails = null;
    }

    public function annulerDemande($id)
    {
        $user = Auth::user();
        // Sécurité : vérifier si l'utilisateur est connecté
        if (!$user) return;

        DB::table('demandes_intervention')
            ->where('idDemande', $id)
            ->where('idClient', DB::table('utilisateurs')
                ->where('email', $user->email)
                ->value('idUser'))
            ->update(['statut' => 'annulée']);
            
        session()->flash('message', 'La demande a été annulée.');
    }

    private function calculerPrix($debut, $fin)
    {
        if (!$debut || !$fin) return 0;
        try {
            $h1 = Carbon::parse($debut);
            $h2 = Carbon::parse($fin);
            $heures = $h1->diffInHours($h2);
            // Exemple : 50 MAD/heure par défaut
            return max($heures * 50, 50); 
        } catch (\Exception $e) { 
            return 0; 
        }
    }

    public function render()
    {
        // Récupération sécurisée de l'ID utilisateur
        $user = Auth::user();
        $userId = $user ? DB::table('utilisateurs')
            ->where('email', $user->email)
            ->value('idUser') : null;

        if (!$userId) {
            return view('livewire.client.mes-demandes', [
                'demandes' => collect(),
                'stats' => ['total' => 0, 'acceptees' => 0, 'attente' => 0, 'refusees' => 0]
            ])->layout('layouts.app');
        }

        // Statistiques
        $stats = [
            'total' => DB::table('demandes_intervention')->where('idClient', $userId)->count(),
            'acceptees' => DB::table('demandes_intervention')->where('idClient', $userId)->where('statut', 'validée')->count(),
            'attente' => DB::table('demandes_intervention')->where('idClient', $userId)->where('statut', 'en_attente')->count(),
            'refusees' => DB::table('demandes_intervention')->where('idClient', $userId)->where('statut', 'refusée')->count(),
        ];

        // Requête principale
        $query = DB::table('demandes_intervention')
            // C'EST ICI LA CORRECTION PRINCIPALE : leftJoin
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->leftJoin('utilisateurs', 'demandes_intervention.idIntervenant', '=', 'utilisateurs.idUser')
            ->select(
                'demandes_intervention.*',
                'services.nomService',
                'utilisateurs.prenom as prenom_intervenant',
                'utilisateurs.nom as nom_intervenant'
            )
            ->where('demandes_intervention.idClient', $userId);

        // Filtres
        if ($this->search) {
            $query->where('services.nomService', 'like', "%{$this->search}%");
        }
        if ($this->filtreService) {
            $query->where('demandes_intervention.idService', $this->filtreService);
        }
        if ($this->filtreStatut) {
            $query->where('demandes_intervention.statut', $this->filtreStatut);
        }

        // Pagination
        $demandes = $query->orderBy('demandes_intervention.dateDemande', 'desc')->paginate(5);

        // Calcul du prix pour chaque demande
        foreach ($demandes as $demande) {
            $demande->prix_estime = $this->calculerPrix($demande->heureDebut, $demande->heureFin);
        }

        return view('livewire.client.mes-demandes', [
            'demandes' => $demandes,
            'stats' => $stats
        ])->layout('layouts.app');
    }
}