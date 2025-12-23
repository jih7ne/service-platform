<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReponseDemandeClient;
use App\Mail\ConfirmationActionProf;
use Livewire\Attributes\Computed; 

class MesDemandes extends Component
{
    
    // --- VARIABLES FILTRES ---
    public $showFilters = false; 
    public $filterSort = 'recent'; 
    public $filterType = 'all';
    
    // --- VARIABLES ONGLETS ---
    public $selectedTab = 'en_attente';
    public $showAdvancedFilters = false;
    public $datePeriod = 'all';
    public $cityFilter = '';
    public $filterMatiere = 'all';
    
    // --- DEBUG VARIABLES ---
    public $debugInfo = [];

    public function mount()
    {
        $this->collectDebugInfo();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function setTab($tab)
    {
        $this->selectedTab = $tab;
        \Log::info('Tab changed to: ' . $tab);
        $this->collectDebugInfo();
    }

    public function collectDebugInfo()
    {
        $userId = Auth::id();
        
        $allDemandes = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)
            ->get(['idDemande', 'statut', 'dateDemande', 'idClient', 'idService']);
            
        $byStatus = [];
        foreach($allDemandes as $demande) {
            $status = $demande->statut;
            if(!isset($byStatus[$status])) {
                $byStatus[$status] = 0;
            }
            $byStatus[$status]++;
        }
        
        $services = DB::table('services')->get(['idService', 'nomService']);
        $tutoringService = DB::table('services')->where('nomService', 'Soutien Scolaire')->first();
        
        $this->debugInfo = [
            'current_tab' => $this->selectedTab,
            'total_demandes' => $allDemandes->count(),
            'by_status' => $byStatus,
            'all_demandes' => $allDemandes->toArray(),
            'services' => $services->toArray(),
            'tutoring_service_id' => $tutoringService ? $tutoringService->idService : null,
            'tutoring_service_name' => $tutoringService ? $tutoringService->nomService : 'Non trouvé'
        ];
        
        \Log::info('Debug Info: ' . json_encode($this->debugInfo));
    }

    public function supprimerDemandesTest()
    {
        $userId = Auth::id();
        
        $demandes = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)
            ->get(['idDemande', 'statut']);
            
        \Log::info('Suppression des demandes de test - ' . $demandes->count() . ' demandes trouvées');
        
        foreach($demandes as $demande) {
            \Log::info('Suppression demande ID: ' . $demande->idDemande . ' (statut: ' . $demande->statut . ')');
            
            DB::table('demandes_prof')->where('demande_id', $demande->idDemande)->delete();
            DB::table('demandes_intervention')->where('idDemande', $demande->idDemande)->delete();
        }
        
        \Log::info('Suppression terminée');
        $this->collectDebugInfo();
        
        session()->flash('success', 'Toutes les demandes de test ont été supprimées');
    }

    public function toggleAdvancedFilters()
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function getStatsProperty()
    {
        $userId = Auth::id();
        
        $enAttente = DB::table('demandes_intervention')->where('idIntervenant', $userId)->where('statut', 'en_attente')->where('idService', 1)->count();
        $validee = DB::table('demandes_intervention')->where('idIntervenant', $userId)->where('statut', 'validée')->where('idService', 1)->count();
        $archive = DB::table('demandes_intervention')->where('idIntervenant', $userId)->whereIn('statut', ['validée', 'terminée', 'completed', 'refusée', 'annulée'])->where('idService', 1)->count();
        
        \Log::info('Stats (Soutien Scolaire only) - En attente: ' . $enAttente . ', Validée: ' . $validee . ', Archive: ' . $archive);
        
        return [
            [
                'label' => 'En attente',
                'value' => $enAttente,
                'color' => '#1E40AF',
                'bgColor' => '#EFF6FF'
            ],
            [
                'label' => 'Validées',
                'value' => $validee,
                'color' => '#10B981',
                'bgColor' => '#D1FAE5'
            ],
            [
                'label' => 'Historique',
                'value' => $archive,
                'color' => '#6B7280',
                'bgColor' => '#F3F4F6'
            ]
        ];
    }

    // --- MÉTHODE CALCULÉE AVEC FILTRES ---
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
            ->where('demandes_intervention.idService', 1); // Soutien Scolaire uniquement

        // Filtrer selon l'onglet sélectionné
        switch ($this->selectedTab) {
            case 'en_attente':
                $query->where('demandes_intervention.statut', 'en_attente');
                break;
            case 'validee':
                $query->where('demandes_intervention.statut', 'validée');
                break;
            case 'archive':
                $query->whereIn('demandes_intervention.statut', ['validée', 'terminée', 'completed', 'refusée', 'annulée']);
                break;
            default:
                $query->where('demandes_intervention.statut', 'en_attente');
                break;
        }

        // --- FILTRES AVANCÉS ---
        
        // Filtre par matière
        if ($this->filterMatiere !== 'all') {
            $query->where('matieres.nom_matiere', $this->filterMatiere);
        }

        // Filtre par ville
        if (!empty($this->cityFilter)) {
            $query->where('localisations.ville', 'like', '%' . $this->cityFilter . '%');
        }

        // Filtre par période de date
        if ($this->datePeriod !== 'all') {
            switch ($this->datePeriod) {
                case 'today':
                    $query->whereDate('demandes_intervention.dateSouhaitee', now()->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('demandes_intervention.dateSouhaitee', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('demandes_intervention.dateSouhaitee', now()->month)
                          ->whereYear('demandes_intervention.dateSouhaitee', now()->year);
                    break;
            }
        }

        // --- TRI ---
        switch ($this->filterSort) {
            case 'recent':
                $query->orderBy('demandes_intervention.dateDemande', 'desc');
                break;
            case 'ancien':
                $query->orderBy('demandes_intervention.dateDemande', 'asc');
                break;
            case 'date_proche':
                $query->orderBy('demandes_intervention.dateSouhaitee', 'asc');
                break;
            case 'prix_haut':
                $query->orderBy('demandes_prof.montant_total', 'desc');
                break;
            case 'prix_bas':
                $query->orderBy('demandes_prof.montant_total', 'asc');
                break;
        }

        $results = $query->select(
                'demandes_intervention.idClient',
                'demandes_intervention.idDemande',
                'demandes_intervention.dateDemande',
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.heureDebut',
                'demandes_intervention.heureFin',
                'demandes_intervention.statut',
                'demandes_intervention.idService',
                'utilisateurs.nom as client_nom',
                'utilisateurs.prenom as client_prenom',
                'utilisateurs.photo as client_photo',
                'utilisateurs.email as client_email',
                'utilisateurs.telephone as client_tel',
                'demandes_prof.montant_total',
                'matieres.nom_matiere',
                'niveaux.nom_niveau',
                'localisations.adresse as client_adresse',
                'localisations.ville as client_ville'
            )
            ->get();

        \Log::info('Tab: ' . $this->selectedTab . ' - Found ' . $results->count() . ' demandes');
        
        return $results;
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
            'type_service' => 'Soutien Scolaire',
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

        session()->flash('success', "La demande a été " . $nouveauStatut . " avec succès. Emails envoyés !");
    }

    public function render()
    {
        return view('livewire.tutoring.mes-demandes');
    }
}