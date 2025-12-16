<?php

namespace App\Livewire\PetKeeping;

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
    // 1. Gestion de l'utilisateur (Mode Force si non connecté)
    $authUser = \Illuminate\Support\Facades\Auth::user();

    if ($authUser) {
        $this->user = \Illuminate\Support\Facades\DB::table('utilisateurs')
            ->where('email', $authUser->email)
            ->first();
    } else {
        $this->user = \Illuminate\Support\Facades\DB::table('utilisateurs')
            ->where('role', 'intervenant')
            ->first();
            
        if (!$this->user) {
             $this->user = (object) ['idUser' => 0, 'prenom' => 'Test', 'role' => 'intervenant'];
        }
    }

    // 2. Chargement de la mission (AVEC LA CORRECTION)
    $this->demande = \Illuminate\Support\Facades\DB::table('demandes_intervention')
        ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
        // J'ajoute les animaux au cas où la page en a besoin
        ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
        ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
        ->select(
            'demandes_intervention.*',
            'demandes_intervention.idDemande as id_demande_reelle', // <--- C'EST CETTE LIGNE QUI MANQUAIT
            'utilisateurs.prenom as prenom_client',
            'utilisateurs.nom as nom_client',
            'utilisateurs.photo as photo_client',
            'utilisateurs.telephone as telephone_client',
            'animals.nomAnimal',
            'animals.race'
        )
        ->where('demandes_intervention.idDemande', $id)
        ->first();

    // 3. Vérifications finales
    if (!$this->demande) {
        session()->flash('error', 'Mission introuvable');
        return redirect('/'); 
    }
    
    $this->prix_estime = 300; 
}

    private function calculerPrix($debut, $fin)
    {
        if (!$debut || !$fin) return 300;
        try {
            return max(Carbon::parse($debut)->diffInHours(Carbon::parse($fin)) * 120, 300);
        } catch (\Exception $e) {
            return 300;
        }
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-mission-details');
    }
}