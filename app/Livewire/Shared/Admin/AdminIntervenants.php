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
                DB::raw("CASE WHEN babysitters.idBabysitter IS NOT NULL THEN 'Babysitting' WHEN petkeepers.idPetKeeper IS NOT NULL THEN 'Pet Keeping' WHEN services.nomService IS NOT NULL THEN services.nomService ELSE 'Service' END as nomService")
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

        // Filtre de statut basé STRICTEMENT sur le statut de l'intervenant en base
        if ($this->statusFilter !== 'tous') {
            $validStatuses = ['ACTIVE', 'VALIDE', 'VALIDÉ'];
            $refusedStatuses = ['ARCHIVED', 'REFUSE', 'REFUSÉ'];

            if ($this->statusFilter === 'en_attente') {
                $query->where('intervenants.statut', 'EN_ATTENTE');
            } elseif ($this->statusFilter === 'valide') {
                $query->whereIn('intervenants.statut', $validStatuses);
            } elseif ($this->statusFilter === 'refuse') {
                $query->whereIn('intervenants.statut', $refusedStatuses);
            }
        }

        $intervenants = $query
            ->orderBy('intervenants.created_at', 'desc')
            ->paginate(10);

        // Charger les données spécifiques pour chaque offre
        foreach ($intervenants as $intervenant) {
            $this->loadOffreTypeData($intervenant);
            // Afficher exactement l'état en base de l'intervenant (normalisé)
            $intervenant->statut = $this->normalizeStatus($intervenant->intervenant_statut ?? null);
            // Injecter un idService résolu si absent (pour activer le lien détails)
            if (empty($intervenant->idService) && isset($intervenant->derivedServiceId)) {
                $intervenant->idService = $intervenant->derivedServiceId;
            }
        }

        // Statistiques basées sur le statut combiné
        $baseStatsQuery = DB::table('intervenants')
            ->leftJoin('offres_services as os', 'os.idintervenant', '=', 'intervenants.IdIntervenant');

        $validStatuses = ['ACTIVE', 'VALIDE', 'VALIDÉ'];
        $refusedStatuses = ['ARCHIVED', 'REFUSE', 'REFUSÉ'];
        $stats = [
            'total' => (clone $baseStatsQuery)->count(),
            'en_attente' => (clone $baseStatsQuery)->where('intervenants.statut', 'EN_ATTENTE')->count(),
            'valides' => (clone $baseStatsQuery)->whereIn('intervenants.statut', $validStatuses)->count(),
            'refuses' => (clone $baseStatsQuery)->whereIn('intervenants.statut', $refusedStatuses)->count(),
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

    private function normalizeStatus($status)
    {
        if (!$status) return null;
        $status = strtoupper($status);
        if (in_array($status, ['ACTIVE', 'VALIDE', 'VALIDÉ'])) return 'VALIDE';
        if (in_array($status, ['ARCHIVED', 'REFUSE', 'REFUSÉ'])) return 'REFUSE';
        if (in_array($status, ['EN_ATTENTE'])) return 'EN_ATTENTE';
        return $status; // fallback
    }
}