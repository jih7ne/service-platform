<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Service;
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
        // Base sur intervenants pour inclure ceux sans entrée dans offres_services (ex: Babysitting)
        $query = DB::table('intervenants')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('offres_services as os', 'os.idintervenant', '=', 'intervenants.IdIntervenant')
            ->leftJoin('services', 'os.idService', '=', 'services.idService')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->leftJoin('babysitters', 'babysitters.idBabysitter', '=', 'intervenants.IdIntervenant')
            ->leftJoin('petkeepers', 'petkeepers.idPetKeeper', '=', 'intervenants.IdIntervenant')
            ->select(
                'intervenants.IdIntervenant',
                'intervenants.created_at',
                'intervenants.id',
                'intervenants.statut as intervenant_statut',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'localisations.ville',
                'localisations.adresse',
                'os.idintervenant',
                'os.idService',
                'os.statut as offre_statut',
                DB::raw("COALESCE(services.nomService, CASE WHEN babysitters.idBabysitter IS NOT NULL THEN 'Babysitting' WHEN petkeepers.idPetKeeper IS NOT NULL THEN 'Pet Keeping' ELSE 'Service' END) as nomService")
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

        // Filtre de statut sur statut combiné (offre ou intervenant)
        if ($this->statusFilter !== 'tous') {
            $statusMap = [
                'en_attente' => 'EN_ATTENTE',
                'valide' => 'ACTIVE',
                'refuse' => 'ARCHIVED'
            ];
            $query->where(DB::raw('COALESCE(os.statut, intervenants.statut)'), $statusMap[$this->statusFilter]);
        }

        $intervenants = $query
            ->orderBy('intervenants.created_at', 'desc')
            ->paginate(10);

        // Charger les données spécifiques pour chaque offre
        foreach ($intervenants as $intervenant) {
            $this->loadOffreTypeData($intervenant);
            // Mapper le statut combiné (offre si dispo sinon intervenant)
            $intervenant->statut = $intervenant->offre_statut ?? $intervenant->intervenant_statut;
            // Injecter un idService résolu si absent (pour activer le lien détails)
            if (empty($intervenant->idService) && isset($intervenant->derivedServiceId)) {
                $intervenant->idService = $intervenant->derivedServiceId;
            }
        }

        // Statistiques basées sur le statut combiné
        $baseStatsQuery = DB::table('intervenants')
            ->leftJoin('offres_services as os', 'os.idintervenant', '=', 'intervenants.IdIntervenant');

        $stats = [
            'total' => (clone $baseStatsQuery)->count(),
            'en_attente' => (clone $baseStatsQuery)->where(DB::raw('COALESCE(os.statut, intervenants.statut)'), 'EN_ATTENTE')->count(),
            'valides' => (clone $baseStatsQuery)->where(DB::raw('COALESCE(os.statut, intervenants.statut)'), 'ACTIVE')->count(),
            'refuses' => (clone $baseStatsQuery)->where(DB::raw('COALESCE(os.statut, intervenants.statut)'), 'ARCHIVED')->count(),
        ];

        return view('livewire.shared.admin.admin-intervenants', [
            'intervenants' => $intervenants,
            'stats' => $stats
        ]);
    }

    private function loadOffreTypeData($intervenant)
    {
        $serviceName = strtolower($intervenant->nomService ?? '');
        
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
            $intervenant->derivedServiceId = $intervenant->derivedServiceId ?? Service::where('nomService', 'Soutien Scolaire')->value('idService');
        } elseif ($serviceName === 'babysitting') {
            $intervenant->service_type = 'Babysitting';
            $intervenant->service_icon = '👶';
            
            $babysitter = DB::table('babysitters')
                ->where('idBabysitter', $intervenant->IdIntervenant)
                ->first();
            
            $intervenant->service_details = $babysitter ? 'Garde d\'enfants - ' . $babysitter->prixHeure . ' DH/h' : 'Garde d\'enfants';
            $intervenant->derivedServiceId = $intervenant->derivedServiceId ?? Service::where('nomService', 'Babysitting')->value('idService');
        } elseif ($serviceName === 'pet keeping') {
            $intervenant->service_type = 'Garde d\'animaux';
            $intervenant->service_icon = '🐾';
            
            $petkeeper = DB::table('petkeepers')
                ->where('idPetKeeper', $intervenant->IdIntervenant)
                ->first();
            
            $intervenant->service_details = $petkeeper ? 'Spécialité: ' . ($petkeeper->specialite ?? 'Non spécifié') : 'Garde d\'animaux';
            $intervenant->derivedServiceId = $intervenant->derivedServiceId ?? Service::where('nomService', 'Pet Keeping')->value('idService');
        } else {
            $intervenant->service_type = $intervenant->nomService;
            $intervenant->service_icon = '💼';
            $intervenant->service_details = 'Service disponible';
        }

        // Fallback statut si aucune offre liée
        if (!isset($intervenant->statut)) {
            $intervenant->statut = $intervenant->intervenant_statut;
        }
    }
}