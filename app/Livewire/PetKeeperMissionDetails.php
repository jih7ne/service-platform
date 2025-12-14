<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PetKeeperMissionDetails extends Component
{
    public $demande;
    public $user;
    public $prix_estime;

    public function mount($id)
    {
        // 1. Récupérer l'utilisateur connecté (PetKeeper)
        $authUser = Auth::user();
        $this->user = DB::table('utilisateurs')
            ->where('idUser', $authUser->idUser ?? $authUser->id)
            ->first();

        // 2. Récupérer la demande spécifique + Client + Animal
        $this->demande = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animals', 'demandes_intervention.idDemande', '=', 'animals.idDemande')
            ->select(
                'demandes_intervention.*',
                'demandes_intervention.idDemande as id_demande_reelle',
                'utilisateurs.nom as nom_client', 
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.photo as photo_client',
                'utilisateurs.email as email_client',
                'utilisateurs.telephone as tel_client',
                'utilisateurs.ville as ville_client',
                'utilisateurs.adresse as adresse_client',
                'animals.nom as nom_animal',
                'animals.race as race_animal',
                'animals.age as age_animal',
                'animals.details as details_animal' // Supposant une colonne détails/notes
            )
            ->where('demandes_intervention.idDemande', $id)
            ->where('demandes_intervention.idIntervenant', $this->user->idUser)
            ->first();

        if (!$this->demande) {
            abort(404, 'Mission introuvable');
        }

        // 3. Calculer le prix
        $this->prix_estime = $this->calculerPrix($this->demande->heureDebut, $this->demande->heureFin);
    }

    private function calculerPrix($debut, $fin)
    {
        if(!$debut || !$fin) return 300;
        try {
            $h = Carbon::parse($debut)->diffInHours(Carbon::parse($fin));
            return max($h * 120, 300);
        } catch (\Exception $e) { return 300; }
    }

    // Vous pouvez ajouter ici les fonctions accepter() et refuser() 
    // identiques à celles du Dashboard pour agir directement depuis cette page.

    public function render()
    {
        return view('livewire.pet-keeper-mission-details')->layout('components.layouts.app');
    }
}