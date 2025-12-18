<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

class MesReclamations extends Component
{
    use WithPagination;

    // Filtres
    public $search = '';
    public $filtreStatut = '';
    public $filtreService = '';

    // Modal
    public $selectedReclamation = null;
    public $showModal = false;

    // Pour le select de filtre
    public $servicesList = [];

    public function mount()
    {
        $this->servicesList = DB::table('services')->get();
    }

    // Reset pagination quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFiltreStatut() { $this->resetPage(); }
    public function updatedFiltreService() { $this->resetPage(); }

    public function openModal($id)
    {
        $this->selectedReclamation = DB::table('reclamantions')
            ->leftJoin('utilisateurs as cible', 'reclamantions.idCible', '=', 'cible.idUser')
            ->leftJoin('feedbacks', 'reclamantions.idFeedback', '=', 'feedbacks.idFeedBack')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'reclamantions.*',
                'cible.prenom as prenom_cible',
                'cible.nom as nom_cible',
                'cible.photo as photo_cible',
                'feedbacks.commentaire',
                'feedbacks.credibilite',
                'feedbacks.sympathie',
                'feedbacks.ponctualite',
                'feedbacks.proprete',
                'feedbacks.qualiteTravail',
                'services.nomService'
            )
            ->where('reclamantions.idReclamation', $id)
            ->first();

        // Calculer la note moyenne si le feedback existe
        if ($this->selectedReclamation && $this->selectedReclamation->credibilite) {
            $notes = [
                $this->selectedReclamation->credibilite,
                $this->selectedReclamation->sympathie,
                $this->selectedReclamation->ponctualite,
                $this->selectedReclamation->proprete,
                $this->selectedReclamation->qualiteTravail
            ];
            $notesValides = array_filter($notes, fn($n) => $n !== null);
            $this->selectedReclamation->note = count($notesValides) > 0 
                ? round(array_sum($notesValides) / count($notesValides), 1) 
                : 0;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReclamation = null;
    }

    public function render()
    {
        // Récupération sécurisée de l'ID utilisateur
        $user = Auth::user();
        $userId = $user ? DB::table('utilisateurs')
            ->where('email', $user->email)
            ->value('idUser') : null;

        if (!$userId) {
            return view('livewire.client.mes-reclamations', [
                'reclamations' => collect(),
                'stats' => ['total' => 0, 'resolues' => 0, 'attente' => 0]
            ])->layout('layouts.app');
        }

        // Statistiques
        $stats = [
            'total' => DB::table('reclamantions')->where('idAuteur', $userId)->count(),
            'resolues' => DB::table('reclamantions')->where('idAuteur', $userId)->where('statut', 'resolue')->count(),
            'attente' => DB::table('reclamantions')->where('idAuteur', $userId)->where('statut', 'en_attente')->count(),
        ];

        // Requête principale
        $query = DB::table('reclamantions')
            ->leftJoin('utilisateurs as cible', 'reclamantions.idCible', '=', 'cible.idUser')
            ->leftJoin('feedbacks', 'reclamantions.idFeedback', '=', 'feedbacks.idFeedBack')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'reclamantions.*',
                'cible.prenom as prenom_cible',
                'cible.nom as nom_cible',
                'services.nomService'
            )
            ->where('reclamantions.idAuteur', $userId);

        // Filtres
        if ($this->search) {
            $query->where(function($q) {
                $q->where('reclamantions.sujet', 'like', "%{$this->search}%")
                  ->orWhere('services.nomService', 'like', "%{$this->search}%");
            });
        }
        if ($this->filtreStatut) {
            $query->where('reclamantions.statut', $this->filtreStatut);
        }
        if ($this->filtreService) {
            $query->where('demandes_intervention.idService', $this->filtreService);
        }

        // Pagination
        $reclamations = $query->orderBy('reclamantions.dateCreation', 'desc')->paginate(5);

        return view('livewire.client.mes-reclamations', [
            'reclamations' => $reclamations,
            'stats' => $stats
        ])->layout('layouts.app');
    }
}