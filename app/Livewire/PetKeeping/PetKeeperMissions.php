<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetKeeperMissions extends Component
{
    public $user;
    public $missions_a_venir = [];
    public $missions_terminees = [];
    public $user_id;

    public $search = '';
    public $statusFilter = '';
    public $availableStatuses = [
        '' => 'Tous les statuts',
        'en_attente' => 'En attente',
        'validée' => 'Validée',
        'en_cours' => 'En cours',
        'terminée' => 'Terminée',
        'refusée' => 'Refusée',
        'annulée' => 'Annulée'
    ];
    
    public function mount()
    {
        $authUser = Auth::user();
        $this->user_id = Auth::id();

        if ($authUser) {
            $this->user = DB::table('utilisateurs')->where('email', $authUser->email)->first();
        } else {
            $this->user = DB::table('utilisateurs')->where('idUser', 10)->first();
            
            if (!$this->user) {
                $this->user = (object) ['idUser' => 10, 'prenom' => 'Hassan', 'nom' => 'Test', 'role' => 'intervenant'];
            }
        }

        $this->chargerMissions();
    }

    public function updatedSearch()
    {
        $this->chargerMissions();
    }

    public function updatedStatusFilter()
    {
        $this->chargerMissions();
    }

    public function chargerMissions()
    {
        $query = DB::table('demandes_intervention')
                ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
                ->join('petkeeping', 'demandes_intervention.idService', '=', 'petkeeping.idPetKeeping')
                ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
                ->leftJoin('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
                ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
                ->select(
                    'demandes_intervention.*',
                    'demandes_intervention.idDemande as id_demande_reelle',
                    'utilisateurs.nom as nom_client',
                    'utilisateurs.prenom as prenom_client',
                    'utilisateurs.note as note_client',
                    'utilisateurs.photo as photo_client',
                    'demandes_intervention.lieu as ville_client',
                    'animals.nomAnimal as nom_animal',
                    'animals.age',
                    'animals.espece',
                    'animals.race as race_animal',
                    'animals.statutVaccination',
                    'animals.note_comportementale',
                    'factures.numFacture as numFac',
                    'factures.montantTotal'
                )
            ->where('demandes_intervention.idIntervenant', $this->user->idUser);

        // Apply search filter
        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function($q) use ($term) {
                $q->where('utilisateurs.nom', 'like', $term)
                  ->orWhere('utilisateurs.prenom', 'like', $term)
                  ->orWhere('animals.nomAnimal', 'like', $term)
                  ->orWhere('demandes_intervention.lieu', 'like', $term)
                  ->orWhere('demandes_intervention.statut', 'like', $term);
            });
        }

        // Apply status filter
        if (!empty($this->statusFilter)) {
            $query->where('demandes_intervention.statut', $this->statusFilter);
        } else {
            // If no status filter is selected, split into two lists as before
            // LISTE 1 : En attente / Validée / En cours
            $this->missions_a_venir = (clone $query)
                ->whereIn('demandes_intervention.statut', ['en_attente', 'validée', 'en_cours'])
                ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
                ->get();

            // LISTE 2 : Terminée / Refusée / Annulée
            $this->missions_terminees = (clone $query)
                ->whereIn('demandes_intervention.statut', ['terminée', 'refusée', 'annulée'])
                ->orderBy('demandes_intervention.dateSouhaitee', 'desc')
                ->get();
            
            return;
        }

        
        $allMissions = $query->orderBy('demandes_intervention.dateSouhaitee', 'desc')->get();
        
        
        $this->missions_a_venir = $allMissions->filter(function($mission) {
            return in_array($mission->statut, ['en_attente', 'validée', 'en_cours']);
        })->values();
        
        $this->missions_terminees = $allMissions->filter(function($mission) {
            return in_array($mission->statut, ['terminée', 'refusée', 'annulée']);
        })->values();
    }

    public function parseCreneauxGrouped($json)
    {
        if (!$json) return [];
        
        try {
            $creneaux = json_decode($json, true) ?? [];
            
            $grouped = [];
            foreach ($creneaux as $creneau) {
                $date = $creneau['date'] ?? null;
                if ($date) {
                    if (!isset($grouped[$date])) {
                        $grouped[$date] = [];
                    }
                    $grouped[$date][] = [
                        'heureDebut' => $creneau['heureDebut'] ?? '',
                        'heureFin' => $creneau['heureFin'] ?? ''
                    ];
                }
            }
            
            return $grouped;
        } catch (\Exception $e) {
            return [];
        }
    }
    
    public function groupAnimalsByDemande($demandes)
    {
        $grouped = [];
        
        foreach ($demandes as $demande) {
            $idDemande = $demande->idDemande;
            
            if (!isset($grouped[$idDemande])) {
                $grouped[$idDemande] = [
                    'demande' => $demande,
                    'animals' => [],
                    'creneaux' => $this->parseCreneauxGrouped($demande->note_speciales ?? '[]')
                ];
            }
            
            if ($demande->nom_animal) {
                $grouped[$idDemande]['animals'][] = [
                    'nom' => $demande->nom_animal,
                    'race' => $demande->race_animal,
                    'age' => $demande->age,
                    'espece' => $demande->espece,
                    'statutVaccination' => $demande->statutVaccination,
                    'note_comportementale' => $demande->note_comportementale
                ];
            }
        }
        
        return array_values($grouped);
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-missions');
    }
}