<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeAccepteeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Ajout pour la gestion des dates

class PetKeeperDashboard extends Component
{
    public $user;
    public $isAvailable = true;

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

    /**
     * Fonction pour accepter la demande et envoyer l'email
     */
    public function accepterDemande($idDemande)
    {
        // 1. Récupérer la demande
        $demande = DB::table('demandes_intervention')->where('idDemande', $idDemande)->first();

        if (!$demande) {
            session()->flash('error', "Erreur : Demande introuvable (ID: $idDemande).");
            return;
        }

        // 2. Récupérer le Client
        $client = DB::table('utilisateurs')->where('idUser', $demande->idClient)->first();

        if (!$client) {
            session()->flash('error', "Erreur : Client introuvable.");
            return;
        }

        // 3. Mise à jour du statut
        DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->update(['statut' => 'validée']);

        // --- PRÉPARATION DES DONNÉES (Animal & Prix) ---
        
        // A. Récupération de l'animal (Table 'animals')
        $animal = DB::table('animals')->where('idDemande', $idDemande)->first();
        $demande->animal = $animal; 

        // B. Calcul du prix
        $prix = 300; 
        if($demande->heureDebut && $demande->heureFin) {
            try {
                $start = Carbon::parse($demande->heureDebut);
                $end = Carbon::parse($demande->heureFin);
                $hours = $start->diffInHours($end);
                $prix = max($hours * 120, 300); 
            } catch (\Exception $e) {}
        }
        $demande->prix = $prix;

        // --- 4. ENVOI DE L'EMAIL (MODE DEBUG) ---
        // Voici la partie que tu as demandée :
        
        if (!empty($client->email)) {
            // PAS de try/catch ici. 
            // Si l'envoi échoue, Laravel affichera un écran rouge avec l'erreur exacte.
            Mail::to($client->email)->send(new DemandeAccepteeMail($demande, $this->user, $client));
            
            session()->flash('message', 'Validée ! Email envoyé à ' . $client->prenom);
        } else {
            // Si on arrive ici, l'écran deviendra noir avec ce message :
            dd("ERREUR CRITIQUE : Le champ 'email' est vide pour l'utilisateur ID " . $client->idUser);
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
                ->select(
                    'demandes_intervention.*',
                    'demandes_intervention.idDemande as id_demande_reelle',
                    'utilisateurs.nom as nom_client', 
                    'utilisateurs.prenom as prenom_client',
                    'utilisateurs.note as note_client',
                    'utilisateurs.photo as photo_client'
                )
                ->where('demandes_intervention.idIntervenant', $intervenantId)
                ->where('demandes_intervention.statut', 'en_attente')
                ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
                ->limit(3)
                ->get();
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
        } catch (\Exception $e) {
            // Ignorer
        }

        // --- 3. COMPTEURS ---
        try {
            $nbAttente = DB::table('demandes_intervention')
                ->where('idIntervenant', $intervenantId)
                ->where('statut', 'en_attente')->count();

            $nbMissions = DB::table('demandes_intervention')
                ->where('idIntervenant', $intervenantId)
                ->where('statut', 'validée')->count();
        } catch (\Exception $e) {
            // Ignorer
        }

        // --- 4. AVIS ---
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('feedbacks')) {
                $avisRecents = DB::table('feedbacks')
                    ->where('idCible', $intervenantId)
                    ->limit(3)
                    ->get();
            }
        } catch (\Exception $e) {
            // Ignorer
        }

        $stats = [
            'missions' => $nbMissions,
            'attente' => $nbAttente,
            'note' => $this->user->note ?? 4.8,
            'revenu' => 4800
        ];

        return view('livewire.pet-keeper-dashboard', [
            'stats' => $stats,
            'demandesUrgentes' => $demandesUrgentes,
            'missionsAVenir' => $missionsAVenir,
            'avisRecents' => $avisRecents
        ])->layout('components.layouts.app');
    }
}