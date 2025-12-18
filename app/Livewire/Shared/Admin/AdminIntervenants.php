<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IntervenantAccepte;
use App\Mail\IntervenantRefuse;

class AdminIntervenants extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $statusFilter = 'tous';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Requête basée sur offres_services
        $query = DB::table('offres_services')
            ->join('intervenants', 'offres_services.idintervenant', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->join('services', 'offres_services.idService', '=', 'services.idService')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->select(
                'offres_services.idintervenant',
                'offres_services.idService',
                'offres_services.statut as offre_statut',
                'intervenants.created_at',
                'intervenants.id',
                'intervenants.IdIntervenant',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'localisations.ville',
                'localisations.adresse',
                'services.nomService'
            );

        // Filtre de recherche
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.email', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('localisations.ville', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('services.nomService', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filtre de statut sur offres_services
        if ($this->statusFilter !== 'tous') {
            $statusMap = [
                'en_attente' => 'EN_ATTENTE',
                'valide' => 'ACTIVE',
                'refuse' => 'ARCHIVED'
            ];
            $query->where('offres_services.statut', $statusMap[$this->statusFilter]);
        }

        $intervenants = $query->orderBy('intervenants.created_at', 'desc')->paginate(10);

        // Charger les données spécifiques pour chaque offre
        foreach ($intervenants as $intervenant) {
            $this->loadOffreTypeData($intervenant);
            // Mapper le statut
            $intervenant->statut = $intervenant->offre_statut;
        }

        // Statistiques basées sur offres_services
        $stats = [
            'total' => DB::table('offres_services')->count(),
            'en_attente' => DB::table('offres_services')->where('statut', 'EN_ATTENTE')->count(),
            'valides' => DB::table('offres_services')->where('statut', 'ACTIVE')->count(),
            'refuses' => DB::table('offres_services')->where('statut', 'ARCHIVED')->count(),
        ];

        return view('livewire.shared.admin.admin-intervenants', [
            'intervenants' => $intervenants,
            'stats' => $stats
        ]);
    }

    private function loadOffreTypeData($intervenant)
    {
        $serviceName = strtolower($intervenant->nomService);
        
        if ($serviceName === 'soutien scolaire') {
            $intervenant->service_type = 'Soutien scolaire';
            $intervenant->service_icon = '📚';
            
            $professeur = DB::table('professeurs')
                ->where('intervenant_id', $intervenant->IdIntervenant)
                ->first();
            
            if ($professeur) {
                $matiere = DB::table('services_prof')
                    ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                    ->where('services_prof.professeur_id', $professeur->id_professeur)
                    ->select('matieres.nom_matiere', 'services_prof.type_service')
                    ->first();
                
                $intervenant->service_details = $matiere ? $matiere->nom_matiere . ' - ' . $matiere->type_service : 'Cours de soutien scolaire';
            }
        } elseif ($serviceName === 'babysitting') {
            $intervenant->service_type = 'Babysitting';
            $intervenant->service_icon = '👶';
            
            $babysitter = DB::table('babysitters')
                ->where('idBabysitter', $intervenant->IdIntervenant)
                ->first();
            
            $intervenant->service_details = $babysitter ? 'Garde d\'enfants - ' . $babysitter->prixHeure . ' DH/h' : 'Garde d\'enfants';
        } elseif ($serviceName === 'pet keeping') {
            $intervenant->service_type = 'Garde d\'animaux';
            $intervenant->service_icon = '🐾';
            
            $petkeeper = DB::table('petkeepers')
                ->where('idPetKeeper', $intervenant->IdIntervenant)
                ->first();
            
            $intervenant->service_details = $petkeeper ? 'Spécialité: ' . ($petkeeper->specialite ?? 'Non spécifié') : 'Garde d\'animaux';
        } else {
            $intervenant->service_type = $intervenant->nomService;
            $intervenant->service_icon = '💼';
            $intervenant->service_details = 'Service disponible';
        }
    }
}