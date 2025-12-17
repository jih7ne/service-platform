<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientDetails extends Component
{
    public $client;
    public $coursHistorique = [];
    public $feedbacks = [];
    public $prenom_prof;
    public $photo_prof;
    public $enAttente = 0;
    
    public $coursTerminesCount = 0; 

    public function mount($id)
    {
        $user = Auth::user();
        $this->prenom_prof = $user->prenom;
        $this->photo_prof = $user->photo;
        $profId = $user->idUser;

        // Pending demandes count for sidebar badge
        $this->refreshPendingRequests();

        // 1. Infos Client (Table 'localisations' avec S)
        $this->client = DB::table('utilisateurs')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('utilisateurs.idUser', $id)
            ->where('utilisateurs.role', 'client')
            ->select('utilisateurs.*', 'localisations.ville', 'localisations.adresse')
            ->first();

        if (!$this->client) {
            return redirect()->route('tutoring.requests');
        }

        // 2. Historique des cours (Reste inchangé)
        $this->coursHistorique = DB::table('demandes_intervention')
            ->join('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->join('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('demandes_intervention.idClient', $id)
            ->where('demandes_intervention.idIntervenant', $profId)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->select(
                'demandes_intervention.*', 
                'matieres.nom_matiere',
                'demandes_prof.montant_total',
                'services_prof.type_service'
            )
            ->orderBy('demandes_intervention.dateSouhaitee', 'desc')
            ->get();

        // Compteur cours terminés
        $this->coursTerminesCount = $this->coursHistorique->filter(function ($cours) {
            return \Carbon\Carbon::parse($cours->dateSouhaitee)->isPast();
        })->count();

        // 3. Feedbacks (Table 'feedbacks' avec S)
        // On récupère les avis laissés SUR ce client (idCible) par d'autres profs
        $this->feedbacks = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->where('feedbacks.idCible', $id)
            ->select('feedbacks.*', 'utilisateurs.prenom as auteur_prenom', 'utilisateurs.nom as auteur_nom')
            ->orderBy('dateCreation', 'desc')
            ->get();
    }

    public function refreshPendingRequests(): void
    {
        $user = Auth::user();
        if (!$user) { $this->enAttente = 0; return; }

        $this->enAttente = (int) DB::table('demandes_intervention')
            ->where('idIntervenant', $user->idUser)
            ->where('statut', 'en_attente')
            ->count();
    }

    public function hydrate(): void
    {
        $this->refreshPendingRequests();
    }
    
    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.client-details');
    }
}