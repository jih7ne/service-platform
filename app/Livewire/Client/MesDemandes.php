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

    private function parseAvailability($value): array
    {
        if (!is_string($value)) {
            return [
                'type' => 'text',
                'value' => '',
            ];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return [
                'type' => 'json',
                'value' => $decoded,
            ];
        }
        
        return [
            'type' => 'text',
            'value' => $value,
        ];
    }

    /**
     * Calcule le prix de l'intervention selon le type de service
     */
    private function calculerPrixIntervention($demande)
    {
        // 1. Soutien Scolaire - récupérer depuis demandes_prof
        if ($demande->idService == 1) {
            $demandeProf = DB::table('demandes_prof')
                ->where('demande_id', $demande->idDemande)
                ->first();
            
            return $demandeProf ? $demandeProf->montant_total : 0;
        }
        
        // 2. Babysitting - calculer avec prixHeure du babysitter
        if ($demande->idService == 2) {
            if (!$demande->heureDebut || !$demande->heureFin || !$demande->idIntervenant) {
                return 0;
            }
            
            try {
                // Récupérer le prix horaire du babysitter
                $babysitter = DB::table('babysitters')
                    ->where('idBabysitter', $demande->idIntervenant)
                    ->first();
                
                if (!$babysitter) {
                    return 0;
                }
                
                // Calculer le nombre d'heures
                $debut = Carbon::parse($demande->heureDebut);
                $fin = Carbon::parse($demande->heureFin);
                $heures = $debut->diffInHours($fin);
                
                // Prix = heures × prix/heure
                return $heures * $babysitter->prixHeure;
                
            } catch (\Exception $e) {
                return 0;
            }
        }
        
        // 3. Pet Keeping - récupérer depuis factures
        if ($demande->idService == 3) {
            $facture = DB::table('factures')
                ->where('idDemande', $demande->idDemande)
                ->first();
            
            return $facture ? $facture->montantTotal : 0;
        }
        
        return 0;
    }

    public function openModal($id)
    {
        // 1. Récupération de la demande de base
        $this->selectedDemande = DB::table('demandes_intervention')
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

        // 3. Calcul du prix selon le type de service
        if ($this->selectedDemande) {
            $this->selectedDemande->prix_estime = $this->calculerPrixIntervention($this->selectedDemande);
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

        // Calculer le prix pour chaque demande selon son type de service
        foreach ($demandes as $demande) {
            $demande->prix_estime = $this->calculerPrixIntervention($demande);
        }

        return view('livewire.client.mes-demandes', [
            'demandes' => $demandes,
            'stats' => $stats
        ])->layout('layouts.app');
    }
}