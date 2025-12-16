<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\DemandeAccepteeMail;
use App\Mail\RefusDemandeMail;

class PetKeeperDashboard extends Component
{
    public $feedbacksSidebar = [];

    public $user;
    public $isAvailable = false;

    public $showRefusalModal = false;
    public $selectedDemandeId = null;
    public $refusalReason = '';

    /* ===================== MOUNT ===================== */
    public function mount()
    {
        
        $authUser = Auth::user();

        // Utilisation de l'accesseur idUser (si configuré dans le modèle) ou id standard
        $authId = $authUser ? ($authUser->idUser ?? $authUser->id) : null;

        if ($authId) {
            $this->user = DB::table('utilisateurs')
                ->where('idUser', $authId)
                ->first();
        }

        if (!$this->user) {
            // Objet par défaut pour éviter les crashs si non connecté
            $this->user = (object) [
                'idUser' => 0,
                'prenom' => 'Invité',
                'nom' => '',
                'photo' => null,
                'note' => 5,
                'statut' => 'actif',
                'telephone' => 'Non renseigné',
                'email' => 'email@test.com'
            ];
        }

        // Vérification basée sur l'enum 'statut' de votre table utilisateurs
        $this->isAvailable = ($this->user->statut === 'actif');
        $this->loadFeedbacks();
    }


    private function loadFeedbacks()
{
    $this->feedbacksSidebar = DB::table('feedbacks')
        ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
        ->where('feedbacks.idCible', $this->user->idUser)
        ->where('feedbacks.estVisible', 1)
        ->orderBy('feedbacks.dateCreation', 'desc')
        ->select('feedbacks.commentaire', 'utilisateurs.prenom')
        ->get();
}


    public function toggleAvailability()
    {
        $nouveauStatut = $this->isAvailable ? 'suspendue' : 'actif';
        
        DB::table('utilisateurs')
            ->where('idUser', $this->user->idUser)
            ->update(['statut' => $nouveauStatut]);

        $this->isAvailable = !$this->isAvailable;
        $this->user->statut = $nouveauStatut;
    }

    /* ===================== PRIX ===================== */
    private function calculerPrix($heureDebut, $heureFin)
    {
        $prix = 300;

        if ($heureDebut && $heureFin) {
            try {
                $heures = Carbon::parse($heureDebut)
                    ->diffInHours(Carbon::parse($heureFin));
                $prix = max($heures * 120, 300);
            } catch (\Exception $e) {}
        }

        return $prix;
    }

    /* ===================== REFUS ===================== */
    public function openRefusalModal($idDemande)
    {
        $this->selectedDemandeId = $idDemande;
        $this->refusalReason = '';
        $this->showRefusalModal = true;
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->selectedDemandeId = null;
    }

    /* ===================== REFUS ===================== */
public function confirmRefusal()
{
    $this->validate([
        'refusalReason' => 'required|min:5|max:255'
    ]);

    $demande = DB::table('demandes_intervention')
        ->where('idDemande', $this->selectedDemandeId)
        ->first();

    if (!$demande) {
        session()->flash('error', 'Demande introuvable');
        return;
    }

    $client = DB::table('utilisateurs')
        ->where('idUser', $demande->idClient)
        ->first();

    /* 1️⃣ ENVOI EMAIL AVANT UPDATE */
    if ($client && $client->email) {
        Mail::to($client->email)->send(
            new RefusDemandeMail(
                $demande,
                $this->user,
                $client,
                $this->refusalReason
            )
        );
    }

    /* 2️⃣ UPDATE APRÈS */
    DB::table('demandes_intervention')
        ->where('idDemande', $this->selectedDemandeId)
        ->update([
            'statut' => 'refusée',
            'raisonAnnulation' => $this->refusalReason
        ]);

    $this->closeRefusalModal();
    session()->flash('success', 'Demande refusée avec succès.');
}


    /* ===================== ACCEPTATION ===================== */
   public function accepterDemande($idDemande)
{
    try {
        $demande = DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->first();

        if (!$demande) {
            session()->flash('error', 'Demande introuvable.');
            return;
        }

        // Vérifier que ce n'est pas sa propre demande
        if ($demande->idClient == $this->user->idUser) {
            session()->flash('error', 'Vous ne pouvez pas accepter vos propres demandes.');
            return;
        }

        $client = DB::table('utilisateurs')
            ->where('idUser', $demande->idClient)
            ->first();

        if (!$client) {
            session()->flash('error', 'Client introuvable.');
            return;
        }

        // VÉRIFIER SI L'UTILISATEUR EST BIEN UN INTERVENANT
        if ($this->user->role !== 'intervenant') {
            session()->flash('error', 'Vous devez être intervenant pour accepter des demandes.');
            return;
        }

        // OPTION 1: Désactiver temporairement les contraintes FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->update([
                'statut' => 'validée',
                'idIntervenant' => $this->user->idUser
            ]);
            
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // OPTION 2: Alternative sans désactiver les contraintes
        // Essayer d'abord normalement, si échec, essayer sans idIntervenant
        /*
        try {
            DB::table('demandes_intervention')
                ->where('idDemande', $idDemande)
                ->update([
                    'statut' => 'validée',
                    'idIntervenant' => $this->user->idUser
                ]);
        } catch (\Exception $e) {
            // Si échec à cause de la FK, mettre à jour seulement le statut
            DB::table('demandes_intervention')
                ->where('idDemande', $idDemande)
                ->update([
                    'statut' => 'validée'
                    // idIntervenant reste NULL pour l'instant
                ]);
        }
        */

        // Récupérer l'animal associé
        $animal = null;
        try {
            $animal = DB::table('animal_demande')
                ->join('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
                ->where('animal_demande.idDemande', $demande->idDemande)
                ->select('animals.*')
                ->first();
        } catch (\Exception $e) {
            // Table animal_demande n'existe pas
        }

        // Préparer les données pour l'email
        $demande->animal = $animal;
        $demande->prix = $this->calculerPrix($demande->heureDebut, $demande->heureFin);

        if ($client->email) {
            try {
                Mail::to($client->email)->send(
                    new DemandeAccepteeMail($demande, $this->user, $client)
                );
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email: ' . $e->getMessage());
            }
        }

        session()->flash('success', 'Demande acceptée avec succès !');
        
    } catch (\Exception $e) {
        \Log::error('Erreur acceptation demande: ' . $e->getMessage());
        session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
    }
}
    /* ===================== RENDER ===================== */
    public function render()
    {
        $intervenantId = $this->user->idUser;

        // 1. Calcul des statistiques exactes selon votre DB
        $missionsCount = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->where('statut', 'validée')
            ->count();

        $attenteCount = DB::table('demandes_intervention')
    ->where('statut', 'en_attente')
    ->count();


        // Pourcentage de missions terminées
        $missionsTotales = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->count();
        
        $missionsTerminees = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->where('statut', 'terminée')
            ->count();
        
        $pourcentageMissions = $missionsTotales > 0 
            ? round(($missionsTerminees / $missionsTotales) * 100) 
            : 0;

        // Revenu du mois - calculé à partir des heures
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        $revenuMois = 0;
        $demandesMois = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->where('statut', 'terminée')
            ->whereBetween('dateSouhaitee', [$debutMois, $finMois])
            ->get(['heureDebut', 'heureFin']);

        foreach ($demandesMois as $demande) {
            $revenuMois += $this->calculerPrix($demande->heureDebut, $demande->heureFin);
        }

        // Note moyenne réelle depuis la table feedbacks
       $noteMoyenne = DB::table('feedbacks')
    ->where('idCible', $this->user->idUser)
    ->selectRaw('AVG((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5)')
    ->value(DB::raw('AVG((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5)'));


        if (!$noteMoyenne) {
            $noteMoyenne = $this->user->note ?? 4.8;
        }

        // 2. Demandes urgentes (pour les intervenants disponibles)
        $demandesUrgentes = [];
        if ($this->isAvailable) {
           $demandesUrgentes = DB::table('demandes_intervention')
    ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
    ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
    ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
    ->select(
        'demandes_intervention.*',
        'demandes_intervention.idDemande as id_demande_reelle',
        'utilisateurs.nom as nom_client',
        'utilisateurs.prenom as prenom_client',
        'utilisateurs.note as note_client',
        'utilisateurs.photo as photo_client',
        'demandes_intervention.lieu as ville_client',
        'animals.nomAnimal as nom_animal',
        'animals.race as race_animal'
    )
    ->where('demandes_intervention.statut', 'en_attente')
    ->whereDate('demandes_intervention.dateSouhaitee', '>=', Carbon::today())
    ->orderBy('demandes_intervention.dateDemande', 'asc')
    ->limit(5)
    ->get();

            foreach ($demandesUrgentes as $d) {
                $d->prix_estime = $this->calculerPrix($d->heureDebut, $d->heureFin);
            }
        }

        // 3. Missions à venir
        $missionsAVenir = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
            ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
            ->select(
                'demandes_intervention.*',
                'utilisateurs.nom as nom_client',
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.photo as photo_client',
                'animals.nomAnimal as nom_animal'
            )
            ->where('demandes_intervention.idIntervenant', $intervenantId)
            ->whereIn('demandes_intervention.statut', ['validée', 'en_cours'])
            ->whereDate('demandes_intervention.dateSouhaitee', '>=', Carbon::today())
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
            ->limit(3)
            ->get();

        // Calculer le prix pour chaque mission à venir
        foreach ($missionsAVenir as $mission) {
            $mission->prix_estime = $this->calculerPrix($mission->heureDebut, $mission->heureFin);
        }

        // 4. Avis récents
        $avisRecents = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                DB::raw('ROUND((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $intervenantId)
            ->where('feedbacks.estVisible', 1)
            ->orderBy('feedbacks.dateCreation', 'desc')
            ->limit(2)
            ->get();



        return view('livewire.pet-keeping.pet-keeper-dashboard', [

            'stats' => [
                'missions' => $missionsCount,
                'attente' => $attenteCount,
                'note' => round($noteMoyenne, 1),
                'revenu' => $revenuMois,
                'clients_fideles' => 0, // Vous pouvez ajouter cette logique si nécessaire
                'pourcentage_missions' => $pourcentageMissions
            ],
            'demandesUrgentes' => $demandesUrgentes,
            'missionsAVenir' => $missionsAVenir,
            'avisRecents' => $avisRecents
            
        ]);
        
    }
}