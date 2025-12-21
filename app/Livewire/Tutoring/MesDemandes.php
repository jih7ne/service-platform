<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReponseDemandeClient;
use App\Mail\ConfirmationActionProf;
use Livewire\Attributes\Computed; // Important pour la magie

class MesDemandes extends Component
{
    public $prenom;
    public $photo;
    
    // --- VARIABLES FILTRES ---
    public $showFilters = false; 
    public $filterSort = 'recent'; 
    public $filterType = 'all';
    // -------------------------

    // Note : On retire "public $demandes" car on utilise la méthode calculée ci-dessous
   public function goToHub()
    {
        return redirect()->route('intervenant.hub');
    }
    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    // --- C'EST ICI LA MAGIE ---
    // Cette fonction se relance automatiquement à chaque action !
    #[Computed]
    public function demandes()
    {
        $user = Auth::user();
        
        $query = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_prof', 'demandes_intervention.idDemande', '=', 'demandes_prof.demande_id')
            ->leftJoin('services_prof', 'demandes_prof.service_prof_id', '=', 'services_prof.id_service')
            ->leftJoin('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->leftJoin('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            
            ->where('demandes_intervention.idIntervenant', $user->idUser)
            ->where('demandes_intervention.statut', 'en_attente'); // On ne garde que ceux en attente

        // 1. Filtre par Type
        if ($this->filterType !== 'all') {
            $query->where('services_prof.type_service', $this->filterType);
        }

        // 2. Tri
        switch ($this->filterSort) {
            case 'ancien':
                $query->orderBy('demandes_intervention.dateDemande', 'asc');
                break;
            case 'prix_croissant':
                $query->orderBy('demandes_prof.montant_total', 'asc');
                break;
            case 'prix_decroissant':
                $query->orderBy('demandes_prof.montant_total', 'desc');
                break;
            default: // 'recent'
                $query->orderBy('demandes_intervention.dateDemande', 'desc');
                break;
        }

        return $query->select(
                'demandes_intervention.idClient',
                
                'demandes_intervention.idDemande',
                'demandes_intervention.dateDemande',
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.heureDebut',
                'demandes_intervention.heureFin',
            'demandes_intervention.lieu',
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
            ->get();
    }

    public function accepter($idDemande)
    {
        $this->traiterDemande($idDemande, 'validée');
    }

    public function refuser($idDemande)
    {
        $this->traiterDemande($idDemande, 'refusée');
    }

    private function traiterDemande($idDemande, $nouveauStatut)
    {
        $prof = Auth::user();
        
        // On cherche dans la liste actuelle ($this->demandes est maintenant une propriété magique)
        $demandeInfo = $this->demandes()->firstWhere('idDemande', $idDemande);

        if (!$demandeInfo) return;

        // 1. Mise à jour BDD
        DB::table('demandes_intervention')
            ->where('idDemande', $idDemande)
            ->update(['statut' => $nouveauStatut]);

        // 2. Données Mail
        $mailData = [
            'statut'       => $nouveauStatut,
            'date'         => \Carbon\Carbon::parse($demandeInfo->dateSouhaitee)->format('d/m/Y'),
            'heure_debut'  => substr($demandeInfo->heureDebut, 0, 5),
            'heure_fin'    => substr($demandeInfo->heureFin, 0, 5),
            'matiere'      => $demandeInfo->nom_matiere ?? 'Soutien Scolaire',
            'niveau'       => $demandeInfo->nom_niveau ?? '',
            'prix'         => $demandeInfo->montant_total,
            'type_service' => $demandeInfo->type_service,
            'prof_nom'     => $prof->prenom . ' ' . $prof->nom,
            'prof_email'   => $prof->email,
            'prof_tel'     => $prof->telephone,
            'client_nom'     => $demandeInfo->client_prenom . ' ' . $demandeInfo->client_nom,
            'client_email'   => $demandeInfo->client_email,
            'client_tel'     => $demandeInfo->client_tel,
            'client_adresse' => $demandeInfo->client_adresse ?? 'Adresse non renseignée',
            'client_ville'   => $demandeInfo->client_ville ?? '',
        ];

        // 3. Envoi Emails
        if ($demandeInfo->client_email) {
            try { Mail::to($demandeInfo->client_email)->send(new ReponseDemandeClient($mailData)); } catch (\Exception $e) {}
        }
        
        if ($prof->email) {
            try { Mail::to($prof->email)->send(new ConfirmationActionProf($mailData)); } catch (\Exception $e) {}
        }

        // Pas besoin de recharger manuellement, la propriété #[Computed] le fera toute seule au prochain affichage !
        session()->flash('success', "La demande a été " . $nouveauStatut . " avec succès. Emails envoyés !");
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.mes-demandes');
    }
}