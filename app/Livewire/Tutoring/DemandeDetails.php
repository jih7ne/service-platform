<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReponseDemandeClient;
use App\Mail\ConfirmationActionProf;

class DemandeDetails extends Component
{
    public $demande;
    public $prenom;
    public $photo;
    public $enAttente = 0;

    public function mount($id)
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;

        // Sidebar badge
        $this->refreshPendingRequests();

        $this->demande = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->leftJoin('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
            
            // --- CORRECTION 1 : Table 'localisation' au singulier (comme dans ta BDD) ---
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            // -----------------------------------------------------------------------------
            
            ->where('demandes_intervention.idDemande', $id)
            ->where('demandes_intervention.idIntervenant', $user->idUser)
            
            ->select(
                'demandes_intervention.*',
                'utilisateurs.nom as client_nom',
                'utilisateurs.prenom as client_prenom',
                'utilisateurs.photo as client_photo',
                'utilisateurs.email as client_email',
                'utilisateurs.telephone as client_tel',
                'localisations.adresse as client_adresse',
                'localisations.ville as client_ville',
                'demandes_prof.montant_total',
                'services_prof.type_service',
                'matieres.nom_matiere',
                'niveaux.nom_niveau'
            )
            ->first();

        if (!$this->demande) {
            return redirect()->route('tutoring.requests');
        }
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

    public function accepter()
    {
        $this->traiterDemande('validée');
    }

    public function refuser()
    {
        $this->traiterDemande('refusée');
    }

    private function traiterDemande($nouveauStatut)
    {
        $prof = Auth::user();

        // 1. Mise à jour BDD
        DB::table('demandes_intervention')
            ->where('idDemande', $this->demande->idDemande)
            ->update(['statut' => $nouveauStatut]);

        // 2. Données Email (Complètes)
        $mailData = [
            'statut'       => $nouveauStatut,
            'date'         => \Carbon\Carbon::parse($this->demande->dateSouhaitee)->format('d/m/Y'),
            'heure_debut'  => substr($this->demande->heureDebut, 0, 5),
            'heure_fin'    => substr($this->demande->heureFin, 0, 5),
            'matiere'      => $this->demande->nom_matiere ?? 'Soutien Scolaire',
            'niveau'       => $this->demande->nom_niveau ?? '',
            'prix'         => $this->demande->montant_total,
            'type_service' => $this->demande->type_service,
            
            'prof_nom'     => $prof->prenom . ' ' . $prof->nom,
            'prof_email'   => $prof->email,
            'prof_tel'     => $prof->telephone,

            'client_nom'     => $this->demande->client_prenom . ' ' . $this->demande->client_nom,
            'client_email'   => $this->demande->client_email,
            'client_tel'     => $this->demande->client_tel,
            'client_adresse' => $this->demande->client_adresse ?? 'Adresse non renseignée',
            'client_ville'   => $this->demande->client_ville ?? '',
        ];

        // 3. ENVOI FORCÉ (Sans Try/Catch pour voir l'erreur)
        // Si ça plante ici, une page rouge apparaîtra avec la cause exacte.
        if ($this->demande->client_email) {
            Mail::to($this->demande->client_email)->send(new ReponseDemandeClient($mailData));
        }
        
        if ($prof->email) {
            Mail::to($prof->email)->send(new ConfirmationActionProf($mailData));
        }

        return redirect()->route('tutoring.requests')->with('success', "Tout est bon ! Emails envoyés.");
    }
    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.demande-details');
    }
}