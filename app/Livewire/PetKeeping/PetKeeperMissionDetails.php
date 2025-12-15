<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PetKeeperMissionDetails extends Component
{
    public $demande;
    public $user;
    public $prix_estime;

    public function mount($id)
{
    /* ================= AUTH ================= */
    $authUser = Auth::user();

    if (!$authUser) {
        return redirect()->route('login');
    }

    /* ================= UTILISATEUR METIER ================= */
    $this->user = DB::table('utilisateurs')
        ->where('email', $authUser->email)
        ->where('role', 'intervenant')
        ->first();

    if (!$this->user) {
        abort(403, 'Accès réservé aux PetKeepers');
    }

    /* ================= DEMANDE ================= */
    $this->demande = DB::table('demandes_intervention')
        ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
        ->leftJoin('animals', 'demandes_intervention.idClient', '=', 'animals.idClient')
       ->select(
    'demandes_intervention.*',
    'demandes_intervention.idDemande as id_demande_reelle',

    // Client
    'utilisateurs.nom as nom_client',
    'utilisateurs.prenom as prenom_client',
    'utilisateurs.photo as photo_client'
)

        ->where('demandes_intervention.idDemande', $id)
        ->first();

    if (!$this->demande) {
        abort(404, 'Mission introuvable');
    }
}

    private function calculerPrix($debut, $fin)
    {
        if (!$debut || !$fin) return 300;
        return max(Carbon::parse($debut)->diffInHours(Carbon::parse($fin)) * 120, 300);
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-mission-details');
    }
}
