<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use App\Models\SoutienScolaire\Matiere;
use App\Models\SoutienScolaire\Niveau;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfessorsList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $selectedVille = '';
    public $selectedNote = '';
    public $selectedMatiere = '';
    public $selectedNiveau = '';
    public $sortBy = 'note';
    public $sortDirection = 'desc';
    public $showMap = false;

    protected $paginationTheme = 'tailwind';

    public function updatingSearchTerm() { 
        $this->resetPage(); 
    }
    
    public function updatingSelectedVille() { 
        $this->resetPage(); 
    }
    
    public function updatingSelectedNote() { 
        $this->resetPage(); 
    }
    
    public function updatingSelectedMatiere() { 
        $this->resetPage(); 
    }
    
    public function updatingSelectedNiveau() { 
        $this->resetPage(); 
    }

    public function sortByField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
        $this->resetPage();
    }

    public function toggleMap()
    {
        $this->showMap = !$this->showMap;
        Log::info('🔄 Toggle map', ['showMap' => $this->showMap]);
    }

    private function getProfesseursQuery()
    {
        $query = DB::table('professeurs')
            ->join('intervenants', 'professeurs.intervenant_id', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->leftJoin(
                DB::raw('(SELECT professeur_id, MIN(prix_par_heure) as min_prix 
                          FROM services_prof 
                          WHERE status = "actif" 
                          GROUP BY professeur_id) as prix_services'),
                'professeurs.id_professeur', '=', 'prix_services.professeur_id'
            )
            ->select(
                'professeurs.id_professeur',
                'professeurs.surnom',
                'professeurs.biographie',
                'professeurs.diplome',
                'professeurs.niveau_etudes',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'utilisateurs.note',
                'utilisateurs.nbrAvis',
                'localisations.ville',
                'localisations.adresse',
                'localisations.latitude',
                'localisations.longitude',
                DB::raw('COALESCE(prix_services.min_prix, 0) as min_prix')
            )
            ->where('intervenants.statut', 'VALIDE');

        // RECHERCHE
        if (!empty($this->searchTerm)) {
            $search = trim($this->searchTerm);
            
            $query->where(function($q) use ($search) {
                $q->where('professeurs.surnom', 'like', "%{$search}%")
                  ->orWhere('professeurs.biographie', 'like', "%{$search}%")
                  ->orWhere('utilisateurs.nom', 'like', "%{$search}%")
                  ->orWhere('utilisateurs.prenom', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(utilisateurs.prenom, ' ', utilisateurs.nom) like ?", ["%{$search}%"]);
                
                if (is_numeric($search) && $search >= 0 && $search <= 5) {
                    $q->orWhere('utilisateurs.note', '>=', $search);
                }

                if (is_numeric($search)) {
                    $q->orWhereRaw('COALESCE(prix_services.min_prix, 0) <= ?', [$search]);
                }

                $q->orWhereExists(function($subQuery) use ($search) {
                    $subQuery->select(DB::raw(1))
                        ->from('services_prof')
                        ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                        ->whereRaw('services_prof.professeur_id = professeurs.id_professeur')
                        ->where('matieres.nom_matiere', 'like', "%{$search}%")
                        ->where('services_prof.status', 'actif');
                });

                $q->orWhereExists(function($subQuery) use ($search) {
                    $subQuery->select(DB::raw(1))
                        ->from('services_prof')
                        ->join('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
                        ->whereRaw('services_prof.professeur_id = professeurs.id_professeur')
                        ->where('niveaux.nom_niveau', 'like', "%{$search}%")
                        ->where('services_prof.status', 'actif');
                });
            });
        }

        // FILTRE VILLE
        if (!empty($this->selectedVille)) {
            $query->where('localisations.ville', $this->selectedVille);
        }

        // FILTRE NOTE
        if (!empty($this->selectedNote)) {
            $query->where('utilisateurs.note', '>=', $this->selectedNote);
        }

        // FILTRE MATIERE
        if (!empty($this->selectedMatiere)) {
            $query->whereExists(function($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('services_prof')
                    ->whereRaw('services_prof.professeur_id = professeurs.id_professeur')
                    ->where('services_prof.matiere_id', $this->selectedMatiere)
                    ->where('services_prof.status', 'actif');
            });
        }

        // FILTRE NIVEAU
        if (!empty($this->selectedNiveau)) {
            $query->whereExists(function($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('services_prof')
                    ->whereRaw('services_prof.professeur_id = professeurs.id_professeur')
                    ->where('services_prof.niveau_id', $this->selectedNiveau)
                    ->where('services_prof.status', 'actif');
            });
        }

        // TRI
        switch ($this->sortBy) {
            case 'note':
                $query->orderBy('utilisateurs.note', $this->sortDirection);
                break;
            case 'nom':
                $query->orderBy('utilisateurs.nom', $this->sortDirection);
                break;
            case 'prix':
                $query->orderBy('min_prix', $this->sortDirection);
                break;
            default:
                $query->orderBy('utilisateurs.note', 'desc');
        }

        return $query;
    }

    private function enrichWithServices($professeurs)
    {
        return $professeurs->map(function($profData) {
            $services = DB::table('services_prof')
                ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                ->join('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
                ->where('services_prof.professeur_id', $profData->id_professeur)
                ->where('services_prof.status', 'actif')
                ->select(
                    'services_prof.*',
                    'matieres.nom_matiere',
                    'niveaux.nom_niveau'
                )
                ->get();

            $profData->services = $services;
            return $profData;
        });
    }

    private function prepareMapData($professeurs)
    {
        $filtered = $professeurs->filter(function($prof) {
            return !empty($prof->latitude) && !empty($prof->longitude);
        });

        Log::info('📍 Professeurs avec coordonnées', [
            'total' => $professeurs->count(),
            'avec_coords' => $filtered->count()
        ]);

        return $filtered->map(function($prof) {
            return [
                'id_professeur' => $prof->id_professeur,
                'surnom' => $prof->surnom,
                'nom' => $prof->nom,
                'prenom' => $prof->prenom,
                'photo' => $prof->photo,
                'note' => (float) $prof->note,
                'nbrAvis' => (int) $prof->nbrAvis,
                'ville' => $prof->ville,
                'latitude' => (float) $prof->latitude,
                'longitude' => (float) $prof->longitude,
                'min_prix' => (float) $prof->min_prix,
                'services' => $prof->services->map(function($service) {
                    return [
                        'nom_matiere' => $service->nom_matiere ?? 'N/A',
                        'nom_niveau' => $service->nom_niveau ?? 'N/A'
                    ];
                })->toArray()
            ];
        })->values()->toArray();
    }

    public function render()
    {
        Log::info('🎨 render()', ['showMap' => $this->showMap]);

        // Récupérer TOUS les professeurs enrichis
        $query = $this->getProfesseursQuery();
        $allProfesseurs = $this->enrichWithServices($query->get());

        // Pagination pour la vue liste
        $perPage = 12;
        $currentPage = $this->getPage();
        $total = $allProfesseurs->count();
        
        $currentPageItems = $allProfesseurs->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $professeursPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Préparer les données carte
        $professeursMap = $this->prepareMapData($allProfesseurs);

        // Récupération des filtres
        $villes = DB::table('localisations')
            ->select('ville')
            ->distinct()
            ->whereNotNull('ville')
            ->where('ville', '!=', '')
            ->orderBy('ville')
            ->pluck('ville');

        $matieres = Matiere::orderBy('nom_matiere')->get();
        $niveaux = Niveau::orderBy('id_niveau')->get();

        Log::info('✅ render() terminé', [
            'total' => $total,
            'carte_profs' => count($professeursMap)
        ]);

        return view('livewire.tutoring.professors-list', [
            'professeurs' => $professeursPaginated,
            'professeursMap' => $professeursMap,
            'matieres' => $matieres,
            'niveaux' => $niveaux,
            'villes' => $villes
        ]);
    }

    public function resetFilters()
    {
        $this->searchTerm = '';
        $this->selectedVille = '';
        $this->selectedNote = '';
        $this->selectedMatiere = '';
        $this->selectedNiveau = '';
        $this->sortBy = 'note';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }
}