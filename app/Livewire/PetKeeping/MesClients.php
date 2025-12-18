<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class MesClients extends Component
{
    public $prenom;
    public $photo;

    // Filters
    public $search = '';
    public $filterStatus = 'all';
    public $viewMode = 'table';

    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;
    }

    /* =========================
        COMPUTED: TOTAL CLIENTS
       ========================= */
    #[Computed]
    public function totalClients()
    {
        return DB::table('demandes_intervention')
            ->where('idIntervenant', Auth::id())
            ->whereIn('statut', ['validée', 'terminée'])
            ->distinct('idClient')
            ->count('idClient');
    }

    /* =========================
        COMPUTED: TOTAL REVENUE
       ========================= */
    #[Computed]
    public function totalRevenue()
    {
        return DB::table('demandes_intervention')
            ->join('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
            ->where('idIntervenant', Auth::id())
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->sum('factures.montantTotal');
    }

    /* =========================
        COMPUTED: CLIENT LIST
       ========================= */
    #[Computed]
    public function clients()
    {
        $query = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
            ->leftJoin('animals', 'animals.idAnimale', '=', 'animal_demande.idAnimal')
            ->leftJoin('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
            ->where('demandes_intervention.idIntervenant', Auth::id())
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée']);

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('utilisateurs.nom', 'like', "%{$this->search}%")
                  ->orWhere('utilisateurs.prenom', 'like', "%{$this->search}%");
            });
        }

        // Status filter
        if ($this->filterStatus === 'en_cours') {
            $query->where('demandes_intervention.statut', 'validée');
        } elseif ($this->filterStatus === 'terminé') {
            $query->where('demandes_intervention.statut', 'terminée');
        }

        return $query
            ->select(
                'utilisateurs.idUser as client_id',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.statut',
                'factures.montantTotal'
            )
            ->distinct('utilisateurs.idUser')
            ->orderByDesc('demandes_intervention.dateSouhaitee')
            ->get();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    /* =========================
        UI ACTIONS
       ========================= */
    public function setFilter($filter)
    {
        $this->filterStatus = $filter;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.pet-keeping.mes-clients');
    }
}
