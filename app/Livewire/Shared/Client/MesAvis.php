<?php

namespace App\Livewire\Shared\Client;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shared\Reclamation;

class MesAvis extends Component
{
    use WithFileUploads, WithPagination;

    public $user;
    
    // Modal Réclamation
    public $showReclamationModal = false;
    public $selectedFeedbackId = null;
    public $sujet = '';
    public $description = '';
    public $priorite = 'moyenne';
    public $preuves = [];

    // Modal Détails Avis
    public $showAvisModal = false;
    public $selectedAvis = null;

    // Filtres
    public $searchTerm = '';
    public $filterService = '';
    public $filterNote = '';

    protected $rules = [
        'sujet' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'priorite' => 'required|in:faible,moyenne,haute',
        'preuves.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240'
    ];

    protected $messages = [
        'sujet.required' => 'Le sujet est obligatoire',
        'sujet.min' => 'Le sujet doit contenir au moins 5 caractères',
        'description.required' => 'La description est obligatoire',
        'description.min' => 'La description doit contenir au moins 10 caractères',
        'priorite.required' => 'Veuillez sélectionner une priorité',
        'preuves.*.max' => 'Chaque fichier ne doit pas dépasser 10 MB'
    ];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('register')->with('message', 'Veuillez vous inscrire ou vous connecter pour accéder à vos avis.');
        }

        if (Auth::user()->role !== 'client') {
            return redirect('/')->with('error', 'Cette page est réservée aux clients uniquement.');
        }

        $authUser = Auth::user();
        $authId = $authUser ? ($authUser->idUser ?? $authUser->id) : null;

        if ($authId) {
            $this->user = DB::table('utilisateurs')
                ->where('idUser', $authId)
                ->first();
        }

        if (!$this->user) {
            $this->user = (object) [
                'idUser' => 0,
                'prenom' => 'Invité',
                'nom' => '',
                'photo' => null,
                'email' => 'email@test.com'
            ];
        }
    }

    // Gestion du modal Détails Avis
    public function openAvisModal($feedbackId)
    {
        $this->selectedAvis = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'utilisateurs.photo as auteur_photo',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idFeedBack', $feedbackId)
            ->first();

        if ($this->selectedAvis) {
            // Vérifier si une réclamation existe
            $this->selectedAvis->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $feedbackId)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
                
            $this->showAvisModal = true;
        }
    }

    public function closeAvisModal()
    {
        $this->showAvisModal = false;
        $this->selectedAvis = null;
    }

    public function openReclamationModalFromDetails()
    {
        if ($this->selectedAvis) {
            $this->selectedFeedbackId = $this->selectedAvis->idFeedBack;
            $this->closeAvisModal();
            $this->openReclamationModal($this->selectedFeedbackId);
        }
    }

    // Gestion du modal Réclamation
    public function openReclamationModal($feedbackId)
    {
        $this->selectedFeedbackId = $feedbackId;
        $this->reset(['sujet', 'description', 'priorite', 'preuves']);
        $this->showReclamationModal = true;
    }

    public function closeReclamationModal()
    {
        $this->showReclamationModal = false;
        $this->selectedFeedbackId = null;
        $this->reset(['sujet', 'description', 'priorite', 'preuves']);
        $this->resetValidation();
    }

    public function removePreuve($index)
    {
        array_splice($this->preuves, $index, 1);
    }

    public function createReclamation()
    {
        $this->validate();

        try {
            // Récupérer le feedback concerné
            $feedback = DB::table('feedbacks')
                ->where('idFeedBack', $this->selectedFeedbackId)
                ->first();

            if (!$feedback) {
                session()->flash('error', 'Avis introuvable.');
                return;
            }

            // Vérifier si une réclamation existe déjà
            $existingReclamation = DB::table('reclamantions')
                ->where('idFeedback', $this->selectedFeedbackId)
                ->where('idAuteur', $this->user->idUser)
                ->exists();

            if ($existingReclamation) {
                session()->flash('error', 'Vous avez déjà créé une réclamation pour cet avis.');
                $this->closeReclamationModal();
                return;
            }

            // Gérer l'upload des preuves
            $preuvesPath = null;
            if (!empty($this->preuves)) {
                $paths = [];
                foreach ($this->preuves as $file) {
                    $paths[] = $file->store('reclamations', 'public');
                }
                $preuvesPath = json_encode($paths);
            }

            // Créer la réclamation
            DB::table('reclamantions')->insert([
                'idCible' => $feedback->idAuteur,
                'idAuteur' => $this->user->idUser,
                'idFeedback' => $this->selectedFeedbackId,
                'statut' => 'en_attente',
                'preuves' => $preuvesPath,
                'sujet' => $this->sujet,
                'description' => $this->description,
                'priorite' => $this->priorite,
                'dateCreation' => now()
            ]);

            session()->flash('success', 'Réclamation envoyée avec succès !');
            $this->closeReclamationModal();
            
            // Rafraîchir la page pour mettre à jour les données
            $this->dispatch('reclamation-created');

        } catch (\Exception $e) {
            \Log::error('Erreur création réclamation: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Une erreur est survenue lors de la création de la réclamation: ' . $e->getMessage());
        }
    }

    // Réinitialiser la pagination lors du changement de filtres
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingFilterService()
    {
        $this->resetPage();
    }

    public function updatingFilterNote()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.nom as auteur_nom',
                'utilisateurs.photo as auteur_photo',
                'services.nomService as nom_service',
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->where('feedbacks.estVisible', 1);

        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('feedbacks.commentaire', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply service filter
        if (!empty($this->filterService)) {
            $query->where('services.nomService', $this->filterService);
        }

        // Apply note filter
        if (!empty($this->filterNote)) {
            if ($this->filterNote === 'positive') {
                $query->havingRaw('note_moyenne >= 4');
            } elseif ($this->filterNote === 'negative') {
                $query->havingRaw('note_moyenne < 3');
            }
        }

        $avisQuery = $query->orderBy('feedbacks.dateCreation', 'desc');
        
        // Paginer les résultats
        $avis = $avisQuery->paginate(10);

        // Vérifier si chaque avis a déjà une réclamation
        foreach ($avis as $avis_item) {
            $avis_item->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $avis_item->idFeedBack)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
        }

        // Get all avis for stats (without pagination)
        $allAvis = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->leftJoin('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->select(
                DB::raw('ROUND((feedbacks.credibilite + feedbacks.sympathie + feedbacks.ponctualite + feedbacks.proprete + feedbacks.qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.typeAuteur', 'intervenant')
            ->where('feedbacks.estVisible', 1)
            ->get();

        // Statistiques
        $stats = [
            'total_avis' => $allAvis->count(),
            'avis_positifs' => $allAvis->where('note_moyenne', '>=', 4)->count(),
            'avis_negatifs' => $allAvis->where('note_moyenne', '<', 3)->count(),
        ];

        return view('livewire.shared.mes-avis', [
            'avis' => $avis,
            'stats' => $stats
        ]);
    }
}
