<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Intervenant;

class Dashboard extends Component
{
    public $prenom;
    public $nom;
    public $photo;
    public $note = 0;
    
    // Variable pour bloquer l'affichage
    public $isPending = false; 

    // KPI & Listes
    public $coursActifs = 0;
    public $totalGagne = 0;
    public $enAttente = 0;
    public $demandesRecentes = [];
    public $coursAVenir = [];

    public function mount()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $this->prenom = $user->prenom;
        $this->nom = $user->nom;
        $this->photo = $user->photo;

        $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();
        if (!$intervenant) return;

        // Sécurité statut
        if ($intervenant->statut !== 'VALIDE' && $intervenant->statut !== 'actif') {
            $this->isPending = true;
            return;
        }

        $userId = $user->idUser;

        // Note moyenne
        $moyenne = DB::table('feedbacks')
    ->where('idCible', $userId)  
    ->avg('moyenne');            

$this->note = $moyenne ? number_format($moyenne, 1) : '-';

        // 1. KPI (Statistiques)
        $professeurId = DB::table('professeurs')
            ->where('intervenant_id', $userId)
            ->value('id_professeur');

        $this->coursActifs = $professeurId
            ? DB::table('services_prof')
                ->where('professeur_id', $professeurId)
                ->where('status', 'actif')
                ->count()
            : 0;

        $this->enAttente = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)
            ->where('statut', 'en_attente')
            ->count();

        $this->totalGagne = DB::table('demandes_intervention')
            ->join('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->sum('demandes_prof.montant_total');

        // 2. Dernières demandes reçues
        $this->demandesRecentes = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->where('demandes_intervention.statut', 'en_attente')
            ->select(
                'demandes_intervention.*',
                'utilisateurs.nom as client_nom', 
                'utilisateurs.prenom as client_prenom',
                'utilisateurs.photo as client_photo',
                'demandes_prof.montant_total',
                'matieres.nom_matiere',
                'services_prof.type_service'
            )
            ->orderBy('demandes_intervention.dateDemande', 'desc')
            ->take(2)
            ->get();

        // 3. Cours à venir
        $this->coursAVenir = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->where('demandes_intervention.statut', 'validée')
            ->whereDate('demandes_intervention.dateSouhaitee', '>=', now())
            ->select(
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.heureDebut',
                'demandes_intervention.heureFin',
                'utilisateurs.nom as client_nom',
                'utilisateurs.prenom as client_prenom',
                'matieres.nom_matiere',
                'demandes_prof.montant_total'
            )
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
            ->orderBy('demandes_intervention.heureDebut', 'asc')
            ->take(3)
            ->get();
    }

    // Fonction pour permettre à l'utilisateur bloqué de sortir
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.dashboard');
    }
}