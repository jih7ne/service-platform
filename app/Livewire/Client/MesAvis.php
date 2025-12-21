<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MesAvis extends Component
{
    use WithPagination, WithFileUploads;

    // Filtres
    public $searchTerm = '';
    public $filterService = '';
    public $filterNote = '';

    // Modal Avis
    public $selectedAvis = null;
    public $showAvisModal = false;

    // Modal Réclamation
    public $showReclamationModal = false;
    public $selectedFeedbackId = null;
    public $sujet = '';
    public $description = '';
    public $priorite = 'moyenne';
    public $preuves = [];

    // User
    public $user;

    // Règles de validation pour la réclamation
    protected $rules = [
        'sujet' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'priorite' => 'required|in:faible,moyenne,haute',
        'preuves.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240'
    ];

    public function mount()
    {
        $this->loadUser();
    }

    private function loadUser()
    {
        $authUser = Auth::user();
        $authId = $authUser ? ($authUser->idUser ?? $authUser->id) : null;

        if ($authId) {
            $this->user = DB::table('utilisateurs')
                ->where('idUser', $authId)
                ->first();
        }

        if (!$this->user) {
            abort(403, 'Accès non autorisé');
        }
    }

    // Reset pagination quand on filtre
    public function updatedSearchTerm() { $this->resetPage(); }
    public function updatedFilterService() { $this->resetPage(); }
    public function updatedFilterNote() { $this->resetPage(); }

    // Modal Avis
    public function openAvisModal($id)
    {
        $this->selectedAvis = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idFeedBack', $id)
            ->first();

        if ($this->selectedAvis) {
            $this->selectedAvis->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $id)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
        }

        $this->showAvisModal = true;
    }

    public function closeAvisModal()
    {
        $this->showAvisModal = false;
        $this->selectedAvis = null;
    }

    // Modal Réclamation
    public function openReclamationModal($feedbackId)
    {
        $this->selectedFeedbackId = $feedbackId;
        $this->showReclamationModal = true;
    }

    public function openReclamationModalFromDetails()
    {
        if ($this->selectedAvis) {
            $this->selectedFeedbackId = $this->selectedAvis->idFeedBack;
            $this->showAvisModal = false;
            $this->showReclamationModal = true;
        }
    }

    public function closeReclamationModal()
    {
        $this->showReclamationModal = false;
        $this->selectedFeedbackId = null;
        $this->reset(['sujet', 'description', 'priorite', 'preuves']);
    }

    // Créer réclamation
    public function createReclamation()
    {
        $this->validate();

        try {
            // Vérifier si réclamation existe déjà
            $existingReclamation = DB::table('reclamantions')
                ->where('idFeedback', $this->selectedFeedbackId)
                ->where('idAuteur', $this->user->idUser)
                ->exists();

            if ($existingReclamation) {
                session()->flash('error', 'Une réclamation existe déjà pour cet avis.');
                return;
            }

            // Gérer l'upload des preuves
            $preuvesPath = null;
            if (!empty($this->preuves)) {
                $paths = [];
                foreach ($this->preuves as $file) {
                    $paths[] = $file->store('reclamations/preuves', 'public');
                }
                $preuvesPath = json_encode($paths);
            }

            // Créer la réclamation
            DB::table('reclamantions')->insert([
                'idCible' => DB::table('feedbacks')
                    ->where('idFeedBack', $this->selectedFeedbackId)
                    ->value('idAuteur'),
                'idAuteur' => $this->user->idUser,
                'idFeedback' => $this->selectedFeedbackId,
                'statut' => 'en_attente',
                'preuves' => $preuvesPath,
                'sujet' => $this->sujet,
                'description' => $this->description,
                'priorite' => $this->priorite,
                'dateCreation' => now(),
                'dateMiseAJour' => now()
            ]);

            session()->flash('success', 'Réclamation envoyée avec succès !');
            $this->closeReclamationModal();

        } catch (\Exception $e) {
            \Log::error('Erreur création réclamation: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function removePreuve($index)
    {
        unset($this->preuves[$index]);
        $this->preuves = array_values($this->preuves);
    }

    // Calcul des statistiques
    private function getStats()
    {
        $query = $this->getBaseQuery();

        $allAvis = $query->get();

        return [
            'total_avis' => $allAvis->count(),
            'avis_positifs' => $allAvis->where('note_moyenne', '>=', 4)->count(),
            'avis_negatifs' => $allAvis->where('note_moyenne', '<', 3)->count(),
        ];
    }

    private function getBaseQuery()
    {
        $query = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->where('feedbacks.estVisible', 1);

        // Filtre recherche
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('feedbacks.commentaire', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('services.nomService', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filtre service
        if (!empty($this->filterService)) {
            $query->where('services.nomService', $this->filterService);
        }

        // Filtre note
        if (!empty($this->filterNote)) {
            if ($this->filterNote === 'positive') {
                $query->havingRaw('note_moyenne >= 4');
            } elseif ($this->filterNote === 'negative') {
                $query->havingRaw('note_moyenne < 3');
            }
        }

        return $query;
    }

    public function render()
    {
        $query = $this->getBaseQuery();
        $avis = $query->orderBy('feedbacks.dateCreation', 'desc')->paginate(5);

        // Vérifier si chaque avis a déjà une réclamation
        foreach ($avis as $avis_item) {
            $avis_item->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $avis_item->idFeedBack)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
        }

        // Services disponibles pour le filtre
        $services = DB::table('feedbacks')
            ->join('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->join('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->select('services.nomService')
            ->distinct()
            ->pluck('nomService');

        $stats = $this->getStats();

        return view('livewire.client.mes-avis', [
            'avis' => $avis,
            'stats' => $stats,
            'services' => $services
        ])->layout('layouts.app');
    }
}