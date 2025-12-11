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
    
    // NOUVEAU : Variable pour bloquer l'affichage
    public $isPending = false; 

    // KPI & Listes
    public $coursActifs = 0;
    public $totalGagne = 0;
    public $enAttente = 0;
    public $demandesRecentes = [];
    public $disponibilites = [];
public $coursAVenir = [];       // Pour la liste de droite
    public $dispoAujourdhui = false; // Pour le badge du header

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

        $moyenne = DB::table('feedbacks')
            ->where('idCible', $userId)
            ->avg('qualiteTravail'); // On fait la moyenne de la colonne qualité

        // On formate : Si pas de note, on met "N/A", sinon on arrondit à 1 décimale (ex: 4.8)
        $this->note = $moyenne ? number_format($moyenne, 1) : '-';

        // 1. KPI (Statistiques)
        $this->coursActifs = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)->where('statut', 'validée')->count();

        $this->enAttente = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)->where('statut', 'en_attente')->count();

        $this->totalGagne = DB::table('demandes_intervention')
            ->join('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->sum('demandes_prof.montant_total');

        // 2. LOGIQUE "DERNIÈRES DEMANDES" (Au lieu de "Urgentes")
        // On prend les 2 plus récentes en attente
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

        // 3. LOGIQUE "COURS À VENIR" (Sidebar Droite)
        // On prend les cours VALIDÉS dont la date est >= aujourd'hui
        $this->coursAVenir = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('demandes_intervention.idIntervenant', $userId)
            ->where('demandes_intervention.statut', 'validée') // Seuls les cours validés
            ->whereDate('demandes_intervention.dateSouhaitee', '>=', now()) // Futurs ou Aujourd'hui
            ->select(
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.heureDebut',
                'demandes_intervention.heureFin',
                'utilisateurs.nom as client_nom',
                'utilisateurs.prenom as client_prenom',
                'matieres.nom_matiere',
                'demandes_prof.montant_total'
            )
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc') // Le plus proche d'abord
            ->orderBy('demandes_intervention.heureDebut', 'asc')
            ->take(3)
            ->get();

        // 4. LOGIQUE "DISPONIBLE AUJOURD'HUI" (Header)
        // On regarde quel jour on est (Lundi, Mardi...)
        // Note: Carbon renvoie 'Monday', 'Tuesday'... Il faut que ta BDD stocke 'Lundi', 'Mardi' ou gérer la traduction.
        // Ici je suppose que ta BDD stocke 'Lundi', 'Mardi'.
        $joursTraduction = [
            'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'
        ];
        $jourActuel = $joursTraduction[now()->format('l')]; // 'l' donne le jour en anglais

        // On vérifie si une ligne existe dans 'disponibilite' pour ce jour et cet intervenant
        $this->dispoAujourdhui = DB::table('disponibilites')
            ->where('idIntervenant', $intervenant->id) // ID table intervenant
            ->where('jourSemaine', $jourActuel)
            ->exists();
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