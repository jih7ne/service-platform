<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;

class PetKeeperMissions extends Component
{
    public $missions;

    public function mount()
    {
        // $authUser = Auth::user();
        // if (!$authUser) {
        //     return redirect()->route('login');
        // }
        if (!session()->has('idUser')) {
    return redirect('/connexion');
}

$this->user = DB::table('utilisateurs')
    ->where('idUser', session('idUser'))
    ->where('role', 'intervenant')
    ->first();

if (!$this->user) {
    abort(403, 'Accès réservé aux PetKeepers');
}


        $user = DB::table('utilisateurs')
            ->where('email', $authUser->email)
            ->where('role', 'intervenant')
            ->first();

        if (!$user) {
            abort(403);
        }

        $this->missions = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->where('idIntervenant', $user->idUser)
            ->orderBy('dateSouhaitee', 'desc')
            ->select(
                'demandes_intervention.*',
                'utilisateurs.nom as nom_client',
                'utilisateurs.prenom as prenom_client'
            )
            ->get();
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-missions');
    }
}
