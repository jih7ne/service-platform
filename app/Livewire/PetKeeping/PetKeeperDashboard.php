<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\DemandeAccepteeMail;
use App\Mail\RefusDemandeMail; // N'oubliez pas d'importer le Mail de refus

class PetKeeperDashboard extends Component
{
    public $user;
    public $isAvailable = true;

    // --- VARIABLES POUR LE REFUS (AJOUTÉ) ---
    public $showRefusalModal = false;
    public $selectedDemandeId = null;
    public $refusalReason = ''; 
    // ----------------------------------------

    public function mount()
    {
        $this->user = DB::table('utilisateurs')->where('idUser', 1)->first();

        if (!$this->user) {
            $authUser = Auth::user();
            if ($authUser) {
                $this->user = DB::table('utilisateurs')
                    ->where('idUser', $authUser->idUser ?? $authUser->id)
                    ->first();
            }
        }
    }

    public function toggleAvailability()
    {
        $this->isAvailable = !$this->isAvailable;
    }

    // --- FONCTION UTILITAIRE POUR CALCULER LE PRIX (AJOUTÉ) ---
    private function calculerPrix($heureDebut, $heureFin) {
        $prix = 300; // Prix de base
        if($heureDebut && $heureFin) {
            try {
                $start = Carbon::parse($heureDebut);
                $end = Carbon::parse($heureFin);
                $hours = $start->diffInHours($end);
                // Votre logique : 120dh/h, minimum 300dh
                $prix = max($hours * 120, 300); 
            } catch (\Exception $e) {}
        }
        return $prix;
    }

    // --- GESTION DU REFUS (AJOUTÉ) ---
    public function openRefusalModal($idDemande) {
        $this->selectedDemandeId = $idDemande;
        $this->refusalReason = ''; 
        $this->showRefusalModal = true;
    }

    public function closeRefusalModal() {
        $this->showRefusalModal = false;
        $this->selectedDemandeId = null;
    }

    public function confirmRefusal() {
        $this->validate(['refusalReason' => 'required|min:5|max:255']);
        
        // Update BDD
        DB::table('demandes_intervention')
            ->where('idDemande', $this->selectedDemandeId)
            ->update([
                'statut' => 'refusée',
                'raisonAnnulation' => $this->refusalReason
            ]);
            
        // Envoi Mail
        $demande = DB::table('demandes_intervention')->where('idDemande', $this->selectedDemandeId)->first();
        if($demande) {
            $client = DB::table('utilisateurs')->where('idUser', $demande->idClient)->first();
            if ($client && !empty($client->email)) {
                try {
                    Mail::to($client->email)->send(new RefusDemandeMail($demande, $this->user, $client, $this->refusalReason));
                } catch (\Exception $e) {}
            }
        }

        $this->closeRefusalModal();
        session()->flash('success', 'Demande refusée avec motif.');
    }

    /**
     * Fonction pour accepter (VOTRE CODE + Utilisation du calcul de prix)
     */
    public function accepterDemande($idDemande)
    {
        $demande = DB::table('demandes_intervention')->where('idDemande', $idDemande)->first();

        if (!$demande) {
            session()->flash('error', "Erreur : Demande introuvable.");
            return;
        }

        $client = DB::table('utilisateurs')->where('idUser', $demande->idClient)->first();

        if (!$client) {
            session()->flash('error', "Erreur : Client introuvable.");
            return;
        }

        DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->update(['statut' => 'validée']);

        // Récupération Animal
        $animal = DB::table('animals')->where('idDemande', $idDemande)->first();
        $demande->animal = $animal; 

        // Utilisation de la fonction centralisée
        $demande->prix = $this->calculerPrix($demande->heureDebut, $demande->heureFin);

        if (!empty($client->email)) {
            Mail::to($client->email)->send(new DemandeAccepteeMail($demande, $this->user, $client));
            session()->flash('success', 'Validée ! Email envoyé à ' . $client->prenom);
        } else {
            // Log l'erreur au lieu de dd() pour ne pas casser la prod
            session()->flash('error', "Email manquant pour le client ID " . $client->idUser);
        }
    }

    public function render()
    {
        $intervenantId = $this->user->idUser ?? 1;
        
        $demandesUrgentes = [];
        $missionsAVenir = [];
        $nbMissions = 0;
        $nbAttente = 0;
        $avisRecents = [];

        // --- 1. DEMANDES URGENTES ---
        try {
            $demandesUrgentes = DB::table('demandes_intervention')
                ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
                ->leftJoin('animals', 'demandes_intervention.idDemande', '=', 'animals.idDemande') // Ajout jointure animal
                ->select(
                    'demandes_intervention.*',
                    'demandes_intervention.idDemande as id_demande_reelle',
                    'utilisateurs.nom as nom_client', 
                    'utilisateurs.prenom as prenom_client',
                    'utilisateurs.note as note_client',
                    'utilisateurs.photo as photo_client',
                    'utilisateurs.ville as ville_client', // Ajout ville
                    'animals.nom as nom_animal', // Ajout animal
                    'animals.race as race_animal'
                )
                ->where('demandes_intervention.idIntervenant', $intervenantId)
                ->where('demandes_intervention.statut', 'en_attente')
                ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
                ->get();
            
            // CALCUL DU PRIX POUR L'AFFICHAGE AVANT CLICK
            foreach($demandesUrgentes as $d) {
                $d->prix_estime = $this->calculerPrix($d->heureDebut, $d->heureFin);
            }

        } catch (\Exception $e) {
            session()->flash('error', "Erreur SQL (Urgentes) : " . $e->getMessage());
        }

        // --- 2. MISSIONS À VENIR ---
        try {
            $missionsAVenir = DB::table('demandes_intervention')
                ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
                ->select(
                    'demandes_intervention.*',
                    'utilisateurs.nom as nom_client',
                    'utilisateurs.prenom as prenom_client'
                )
                ->where('demandes_intervention.idIntervenant', $intervenantId)
                ->where('demandes_intervention.statut', 'validée')
                ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
                ->limit(4)
                ->get();
                
            // Calcul prix aussi pour missions à venir
            foreach($missionsAVenir as $m) {
                $m->prix_estime = $this->calculerPrix($m->heureDebut, $m->heureFin);
            }

        } catch (\Exception $e) { }

        // --- 3. COMPTEURS ---
        try {
            $nbAttente = DB::table('demandes_intervention')
                ->where('idIntervenant', $intervenantId)
                ->where('statut', 'en_attente')->count();

            $nbMissions = DB::table('demandes_intervention')
                ->where('idIntervenant', $intervenantId)
                ->where('statut', 'validée')->count();
        } catch (\Exception $e) { }

        // --- 4. AVIS ---
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('feedbacks')) {
                $avisRecents = DB::table('feedbacks')->where('idCible', $intervenantId)->limit(3)->get();
            }
        } catch (\Exception $e) { }

        $stats = [
            'missions' => $nbMissions,
            'attente' => $nbAttente,
            'note' => $this->user->note ?? 4.8,
            'revenu' => 4800 // Tu peux aussi calculer ça dynamiquement si tu veux
        ];

        return view('livewire.pet-keeping.pet-keeper-dashboard', [
            'stats' => $stats,
            'demandesUrgentes' => $demandesUrgentes,
            'missionsAVenir' => $missionsAVenir,
            'avisRecents' => $avisRecents
        ]);
    }
}
