<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Reclamation;

class PetKeeperAvisPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $user_id;
    public $user;

    //  Filters
    public $search = '';
    public $minRating = null;
    public $sortDirection = 'desc';

    //Reclamation

    public $showRefusalModal = false;
    public $selectedDemandeId = null;
    public $refusalReason = '';
    public $showReclamationModal = false;
    public $showCommentsOnClientModel = false;
    public $reclamationCibleId = null;
    public $reclamationFeedbackId = null;

    public $sujet;
    public $description;
    public $priorite = 'moyenne';
    public $preuves;

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMinRating()
    {
        $this->resetPage();
    }

    public function updatingSortDirection()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (!Auth::check() || Auth::user()->role !== 'intervenant') {
            return redirect()->route('login');
        }

        $this->user = Auth::user();
        $this->user_id = Auth::user()->idUser ?? Auth::id();
    }

    private function baseFeedbackQuery()
    {
        // Calculate average rating from all criteria
        return DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                // Calculate average rating from all criteria
                DB::raw('ROUND((
                    COALESCE(credibilite, 0) + 
                    COALESCE(sympathie, 0) + 
                    COALESCE(ponctualite, 0) + 
                    COALESCE(proprete, 0) + 
                    COALESCE(qualiteTravail, 0)
                ) / 5.0, 1) as note_moyenne'),
                // Count how many criteria are filled (not null)
                DB::raw('(
                    (CASE WHEN credibilite IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN sympathie IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN ponctualite IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN proprete IS NOT NULL THEN 1 ELSE 0 END) +
                    (CASE WHEN qualiteTravail IS NOT NULL THEN 1 ELSE 0 END)
                ) as criteria_count')
            )
            ->where('feedbacks.estVisible', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('utilisateurs.prenom', 'like', "%{$this->search}%")
                      ->orWhere('feedbacks.commentaire', 'like', "%{$this->search}%");
                });
            })
            ->when($this->minRating, function ($query) {
                $query->having('note_moyenne', '>=', $this->minRating);
            })
            ->orderBy('feedbacks.dateCreation', $this->sortDirection);
    }

    private function feedBacksOnMeQuery()
    {
        return $this->baseFeedbackQuery()
            ->where('feedbacks.idCible', $this->user_id);
    }

    private function feedBacksOnClientsQuery()
    {
        return $this->baseFeedbackQuery()
            ->where('feedbacks.idAuteur', $this->user_id);
    }


    //Reclamation
    public function openReclamationModal($idFeedback)
    {
        $this->reclamationFeedbackId = $idFeedback;
        

        $avis = DB::table('feedbacks')
            ->where('idFeedBack', $idFeedback)
            ->first();

        if (!$avis) {
            session()->flash('error', 'Avis introuvable.');
            return;
        }

        $this->reclamationFeedbackId  = $idFeedback;
        $this->reclamationCibleId = $avis->idAuteur;

        $this->reset([
            'sujet',
            'description',
            'priorite',
            'preuves',
        ]);

        $this->priorite = 'moyenne';
        $this->showReclamationModal = true;
    }

    public function closeReclamationModal()
    {
        $this->reset([
            'showReclamationModal',
            'reclamationFeedbackId',
            'reclamationCibleId',
            'sujet',
            'description',
            'priorite',
            'preuves',
        ]);
    }


    public function submitReclamation()
    {
        $this->validate([
            'sujet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:faible,moyenne,urgente',
            'preuves' => 'nullable|file|max:2048',
        ]);

        $preuvePath = null;

        if ($this->preuves) {
            $preuvePath = $this->preuves->store('reclamations', 'public');
        }

        Reclamation::create([
            'idAuteur'    => $this->user->idUser,
            'idCible'     => $this->reclamationCibleId,
            'idFeedback'  => $this->reclamationFeedbackId,
            'sujet'       => $this->sujet,
            'description' => $this->description,
            'priorite'    => $this->priorite,
            'preuves'     => $preuvePath,
            'statut'      => 'en_attente',
        ]);

        $this->closeReclamationModal();

        session()->flash('success', 'Réclamation envoyée avec succès.');
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-avis-page', [
            'feedBacksOnPetKeeper' => $this->feedBacksOnMeQuery()
                ->paginate(5, ['*'], 'mePage'),

            'feedBacksOnClient' => $this->feedBacksOnClientsQuery()
                ->paginate(5, ['*'], 'clientPage'),
        ]);
    }
}