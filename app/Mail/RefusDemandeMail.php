<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\DemandeAccepteeMail;
// Assurez-vous d'avoir créé la classe Mail ci-dessous
use App\Mail\RefusDemandeMail; 

class PetKeeperDashboard extends Component
{
    public $user;
    public $isAvailable = true;

    // --- VARIABLES POUR LE MODAL DE REFUS ---
    public $showRefusalModal = false;
    public $selectedDemandeId = null;
    public $refusalReason = ''; 
    // ----------------------------------------

    public function mount()
    {
        // Récupération de l'utilisateur connecté (PetKeeper)
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

    // --- 1. OUVERTURE DU MODAL ---
    public function openRefusalModal($idDemande)
    {
        $this->selectedDemandeId = $idDemande;
        $this->refusalReason = ''; // Réinitialiser le champ
        $this->showRefusalModal = true;
    }

    // --- 2. FERMETURE DU MODAL ---
    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->selectedDemandeId = null;
    }

    // --- 3. CONFIRMATION DU REFUS ---
    public function confirmRefusal()
    {
        // Validation
        $this->validate([
            'refusalReason' => 'required|min:5|max:500',
        ], [
            'refusalReason.required' => 'Le motif est obligatoire pour refuser.',
            'refusalReason.min' => 'Le motif est trop court (min 5 caractères).',
        ]);

        $id = $this->selectedDemandeId;

        // Récupération des infos
        $demande = DB::table('demandes_intervention')->where('idDemande', $id)->first();
        
        if ($demande) {
            // Mise à jour BDD
            DB::table('demandes_intervention')
                ->where('idDemande', $id)
                ->update(['statut' => 'refusée']); // Ou 'refusee' selon votre enum

            // Récupération Client pour Email
            $client = DB::table('utilisateurs')->where('idUser', $demande->idClient)->first();

            // Envoi Email
            if ($client && !empty($client->email)) {
                try {
                    Mail::to($client->email)->send(new RefusDemandeMail($demande, $this->user, $client, $this->refusalReason));
                } catch (\Exception $e) {
                    // Log l'erreur si besoin, mais ne bloque pas l'interface
                }
            }

            session()->flash('success', 'Demande refusée. Le client a été notifié.');
        }

        $this->closeRefusalModal();
    }

    // --- LOGIQUE ACCEPTER (Existante) ---
    public function accepterDemande($idDemande)
    {
        $demande = DB::table('demandes_intervention')->where('idDemande', $idDemande)->first();
        if (!$demande) return;

        $client = DB::table('utilisateurs')->where('idUser', $demande->idClient)->first();
        
        // Récupération infos supplémentaires pour l'email
        $animal = DB::table('animals')->where('idDemande', $idDemande)->first();
        $demande->animal = $animal;
        $demande->prix = 300; // Votre logique de prix

        DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->update(['statut' => 'validée']);

        if ($client && !empty($client->email)) {
             Mail::to($client->email)->send(new DemandeAccepteeMail($demande, $this->user, $client));
        }

        session()->flash('success', 'Mission acceptée avec succès !');
    }

    public function render()
    {
        $intervenantId = $this->user->idUser ?? 1;

        // Récupération des demandes urgentes (En attente)
        // Note: J'ai ajouté le LEFT JOIN sur 'animals' comme demandé
        $demandesUrgentes = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animals', 'demandes_intervention.idDemande', '=', 'animals.idDemande')
            ->select(
                'demandes_intervention.*',
                'demandes_intervention.idDemande as id_demande_reelle',
                'utilisateurs.nom as nom_client', 
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.photo as photo_client',
                'utilisateurs.note as note_client',
                'utilisateurs.ville as ville_client', // Assumant que ville est dans utilisateurs ou via une autre jointure
                'animals.nom as nom_animal',
                'animals.race as race_animal'
            )
            ->where('demandes_intervention.idIntervenant', $intervenantId)
            ->where('demandes_intervention.statut', 'en_attente')
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
            ->get();

        // Calculs Stats (Simulés pour l'exemple ou réels)
        $stats = [
            'missions' => DB::table('demandes_intervention')->where('idIntervenant', $intervenantId)->where('statut', 'validée')->count(),
            'attente' => count($demandesUrgentes),
            'avg_rating' => $this->user->note ?? 4.8,
            'total_earnings' => 4500 // Exemple
        ];

        return view('livewire.pet-keeper-dashboard', [
            'demandesUrgentes' => $demandesUrgentes,
            'stats' => $stats
        ])->layout('components.layouts.app');
    }
}