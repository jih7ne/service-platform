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

    public function mount()
    {
        // 1. AUTHENTIFICATION
        $authUser = Auth::user();

        if ($authUser) {
            $this->user = DB::table('utilisateurs')->where('email', $authUser->email)->first();
        } else {
            // MODE TEST : On force l'ID 10
            $this->user = DB::table('utilisateurs')->where('idUser', 10)->first();
            
            if (!$this->user) {
                $this->user = (object) ['idUser' => 10, 'prenom' => 'Hassan', 'nom' => 'Test', 'role' => 'intervenant'];
            }
        }

        $this->chargerMissions();
    }

    public function chargerMissions()
    {
        $query = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
            ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
            ->select(
                'demandes_intervention.*',
                'demandes_intervention.idDemande as id_demande_reelle',
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.nom as nom_client',
                'utilisateurs.photo as photo_client',
                'animals.nomAnimal',
                'animals.race'
            )
            ->where('demandes_intervention.idIntervenant', $this->user->idUser);

        // LISTE 1 : En attente / Validée / En cours
        $this->missions_a_venir = (clone $query)
            ->whereIn('demandes_intervention.statut', ['en_attente', 'validée', 'en_cours'])
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
            ->get();

        // LISTE 2 : Terminée / Refusée
        $this->missions_terminees = (clone $query)
            ->whereIn('demandes_intervention.statut', ['terminée', 'refusée', 'annulée'])
            ->orderBy('demandes_intervention.dateSouhaitee', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-missions');
    }
}