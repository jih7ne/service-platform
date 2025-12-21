<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class MesClients extends Component
{
    public $enAttente = 0;
    public $prenom;
    public $photo;
    
    // Filtres
    public $search = '';
    public $filterStatus = 'all'; // 'all', 'en_cours', 'terminé'
   public function goToHub()
    {
        return redirect()->route('intervenant.hub');
    }
    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;

        // Sidebar badge count
        $this->refreshPendingRequests();
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

    // --- CALCUL DES STATS GLOBALES ---
    #[Computed]
    public function stats()
    {
        $userId = Auth::id();
        $maintenant = now(); // La date et l'heure actuelles

        // 1. REQUÊTE DE BASE (Tout ce qui est validé ou terminé)
        $baseQuery = DB::table('demandes_intervention')
            ->join('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée']);

        // 2. REQUÊTE "PASSÉ" (Uniquement les cours déjà terminés dans le temps)
        $coursTerminesQuery = $baseQuery->clone()
            ->where(function ($query) use ($maintenant) {
                // Soit la date est avant aujourd'hui
                $query->where('demandes_intervention.dateSouhaitee', '<', $maintenant->toDateString())
                // Soit c'est aujourd'hui, mais l'heure de fin est passée
                      ->orWhere(function ($q) use ($maintenant) {
                          $q->where('demandes_intervention.dateSouhaitee', '=', $maintenant->toDateString())
                            ->where('demandes_intervention.heureFin', '<', $maintenant->toTimeString());
                      });
            });

        // --- CALCULS ---

        // A. Total Clients (On compte tous ceux qui ont réservé, même futur)
        $totalClients = $baseQuery->clone()->distinct('idClient')->count('idClient');

        // B. Cours Donnés (Seulement ceux passés)
        $totalCours = $coursTerminesQuery->count();

        // C. Heures Enseignées (Seulement celles passées)
        $heures = $coursTerminesQuery->get()->sum(function($d) {
            $debut = \Carbon\Carbon::parse($d->heureDebut);
            $fin = \Carbon\Carbon::parse($d->heureFin);
            
            // Calcul en minutes divisé par 60 pour éviter les "-1h" ou les arrondis bizarres
            // Ex: 1h30 deviendra 1.5
            return $fin->diffInMinutes($debut) / 60;
        });

        // D. Revenus (On affiche tout le prévisionnel validé, c'est plus motivant)
        // Si tu veux seulement l'argent "encaissé", utilise $coursTerminesQuery à la place.
        $revenus = $baseQuery->clone()->sum('demandes_prof.montant_total');

        return [
            'clients' => $totalClients,
            'cours' => $totalCours,
            'heures' => round($heures, 1), // On arrondit à 1 décimale (ex: 12.5h)
            'revenus' => $revenus
        ];
    }
    // --- LISTE DES CLIENTS ---
    #[Computed]
    public function clients()
    {
        $userId = Auth::id();

        $query = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->leftJoin('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
            
            ->where('demandes_intervention.idIntervenant', $userId)
            // On ne veut que les clients avec qui on a travaillé
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée']);

        // Recherche par nom
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('utilisateurs.nom', 'like', '%'.$this->search.'%')
                  ->orWhere('utilisateurs.prenom', 'like', '%'.$this->search.'%');
            });
        }

        // Filtre Statut (En cours = validée / Terminé = terminée)
        if ($this->filterStatus === 'en_cours') {
            $query->where('demandes_intervention.statut', 'validée');
        } elseif ($this->filterStatus === 'terminé') {
            $query->where('demandes_intervention.statut', 'terminée');
        }

        // On groupe par client pour ne pas avoir 10 fois le même client
        // Et on sélectionne la DERNIÈRE demande pour afficher les infos récentes
        return $query->select(
                'utilisateurs.idUser as client_id',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                'demandes_intervention.dateSouhaitee', // Prochaine séance ou dernière
                'demandes_intervention.statut',
                'matieres.nom_matiere',
                'niveaux.nom_niveau',
                'demandes_prof.montant_total'
            )
            ->orderBy('demandes_intervention.dateSouhaitee', 'desc')
            ->get()
            ->unique('client_id'); // Astuce pour ne garder qu'une carte par client
    }

    public function setFilter($filter)
    {
        $this->filterStatus = $filter;
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.mes-clients');
    }
}