<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AvisPage extends Component
{
    use WithFileUploads;
    public $babysitter;
    public $feedbacks = [];
    public $filterRating = 'all';
    public $filterDate = 'all';
    public $filterStatus = 'all';
    public $searchTerm = '';

    // Modal properties
    public $showClaimModal = false;
    public $selectedFeedbackId = null;
    public $claimSubject = '';
    public $claimDescription = '';
    public $claimProof = null;

    public function mount()
    {
        // Charger les données du babysitter pour la sidebar
        $user = Auth::user();
        $this->babysitter = $user->intervenant->babysitter ?? null;
        
        $this->loadFeedbacks();
    }

    public function loadFeedbacks()
    {
        $query = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->where('feedbacks.idCible', Auth::id())
            ->where('feedbacks.typeAuteur', 'client')
            ->where('feedbacks.estVisible', true)
            ->select(
                'feedbacks.*',
                'utilisateurs.nom as client_nom',
                'utilisateurs.prenom as client_prenom',
                'utilisateurs.photo as client_photo',
                'demandes_intervention.dateSouhaitee',
                'demandes_intervention.statut as demande_statut'
            );

        // Filtre par note (moyenne des critères)
        if ($this->filterRating !== 'all') {
            $query->havingRaw('(credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5 = ?', [$this->filterRating]);
        }

        // Filtre par date
        if ($this->filterDate === 'recent') {
            $query->orderBy('feedbacks.dateCreation', 'desc');
        } elseif ($this->filterDate === 'old') {
            $query->orderBy('feedbacks.dateCreation', 'asc');
        } else {
            $query->orderBy('feedbacks.dateCreation', 'desc');
        }

        // Filtre par statut (réclamé ou non)
        if ($this->filterStatus === 'claimed') {
            $query->whereExists(function($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('reclamantions')
                    ->whereColumn('reclamantions.idFeedback', 'feedbacks.idFeedBack');
            });
        } elseif ($this->filterStatus === 'not_claimed') {
            $query->whereNotExists(function($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('reclamantions')
                    ->whereColumn('reclamantions.idFeedback', 'feedbacks.idFeedBack');
            });
        }

        // Recherche
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('feedbacks.commentaire', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $this->feedbacks = $query->get()->filter(function($feedback) {
            return $this->canDisplayFeedback($feedback);
        });
    }

    private function canDisplayFeedback($feedback)
    {
        // Si pas de demande associée, on autorise l'affichage (compatibilité)
        if (!$feedback->idDemande) {
            return true;
        }

        // Condition 1: Les deux feedbacks (client et intervenant) existent
        $intervenantFeedbackExists = DB::table('feedbacks')
            ->where('idDemande', $feedback->idDemande)
            ->where('typeAuteur', 'intervenant')
            ->where('idCible', $feedback->idAuteur) // L'intervenant a noté le client
            ->exists();

        if ($intervenantFeedbackExists) {
            return true;
        }

        // Condition 2: Une semaine s'est écoulée depuis la fin de l'intervention
        // On considère que la date souhaitée est la date de fin de l'intervention
        if ($feedback->dateSouhaitee) {
            $oneWeekLater = \Carbon\Carbon::parse($feedback->dateSouhaitee)->addWeek();
            $now = \Carbon\Carbon::now();
            
            return $now->greaterThanOrEqualTo($oneWeekLater);
        }

        // Si aucune condition n'est remplie, on n'affiche pas
        return false;
    }

    public function updatedFilterRating()
    {
        $this->loadFeedbacks();
    }

    public function updatedFilterDate()
    {
        $this->loadFeedbacks();
    }

    public function updatedFilterStatus()
    {
        $this->loadFeedbacks();
    }

    public function updatedSearchTerm()
    {
        $this->loadFeedbacks();
    }

    public function claimFeedback($feedbackId)
    {
        // Debug: vérifier que la méthode est appelée
        \Log::info('claimFeedback appelée', ['feedbackId' => $feedbackId]);
        
        // Vérifier que le feedback appartient bien à l'intervenant connecté
        $feedback = DB::table('feedbacks')
            ->where('idFeedBack', $feedbackId)
            ->where('idCible', Auth::id())
            ->first();

        if ($feedback) {
            // Vérifier si déjà réclamé
            $alreadyClaimed = DB::table('reclamantions')
                ->where('idFeedback', $feedbackId)
                ->exists();

            if ($alreadyClaimed) {
                session()->flash('error', 'Cet avis a déjà été réclamé.');
                return;
            }

            $this->selectedFeedbackId = $feedbackId;
            $this->showClaimModal = true;
            $this->reset(['claimSubject', 'claimDescription', 'claimProof']);
            
            // Debug
            \Log::info('Modal devrait s\'ouvrir', ['showClaimModal' => $this->showClaimModal]);
        } else {
            session()->flash('error', 'Feedback non trouvé ou vous n\'avez pas l\'autorisation.');
        }
    }

    public function submitClaim()
    {
        $this->validate([
            'claimSubject' => 'required|string|max:255',
            'claimDescription' => 'required|string|min:10',
            'claimProof' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,zip'
        ], [
            'claimSubject.required' => 'Le sujet est obligatoire.',
            'claimDescription.required' => 'La description est obligatoire.',
            'claimDescription.min' => 'La description doit contenir au moins 10 caractères.',
            'claimProof.max' => 'Le fichier ne doit pas dépasser 10MB.',
            'claimProof.mimes' => 'Le format du fichier n\'est pas autorisé.'
        ]);

        if ($this->selectedFeedbackId) {
            $feedback = DB::table('feedbacks')
                ->where('idFeedBack', $this->selectedFeedbackId)
                ->where('idCible', Auth::id())
                ->first();

            if ($feedback) {
                try {
                    // Gérer le fichier de preuve
                    $proofPath = null;
                    if ($this->claimProof) {
                        $proofPath = $this->claimProof->store('reclamations', 'public');
                    }

                    // Insérer dans la table des réclamations
                    DB::table('reclamantions')->insert([
                        'idFeedback' => $this->selectedFeedbackId,
                        'idAuteur' => Auth::id(),
                        'idCible' => $feedback->idAuteur,
                        'sujet' => $this->claimSubject,
                        'description' => $this->claimDescription,
                        'preuves' => $proofPath,
                        'statut' => 'en_attente',
                        'priorite' => 'moyenne',
                        'dateCreation' => now()
                    ]);

                    $this->showClaimModal = false;
                    $this->reset(['selectedFeedbackId', 'claimSubject', 'claimDescription', 'claimProof']);
                    $this->loadFeedbacks();
                    
                    session()->flash('success', 'Réclamation soumise avec succès');
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la soumission de la réclamation', ['error' => $e->getMessage()]);
                    session()->flash('error', 'Une erreur est survenue lors de la soumission de votre réclamation.');
                }
            }
        }
    }

    public function closeClaimModal()
    {
        $this->showClaimModal = false;
        $this->reset(['selectedFeedbackId', 'claimSubject', 'claimDescription', 'claimProof']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.babysitter.avis-page'); // Correction du chemin de la vue
    }
}