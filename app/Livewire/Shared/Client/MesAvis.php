<?php

namespace App\Livewire\Shared\Client;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shared\Reclamation;

class MesAvis extends Component
{
    use WithFileUploads;

    public $user;
    public $showReclamationModal = false;
    public $selectedFeedbackId = null;
    public $sujet = '';
    public $description = '';
    public $priorite = 'moyenne';
    public $preuves = [];

    public $searchTerm = '';
    public $filterService = '';
    public $filterNote = '';

    protected $rules = [
        'sujet' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'priorite' => 'required|in:faible,moyenne,urgente',
        'preuves.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
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

    public function openReclamationModal($feedbackId)
    {
        $this->selectedFeedbackId = $feedbackId;
        $this->sujet = '';
        $this->description = '';
        $this->priorite = 'moyenne';
        $this->preuves = [];
        $this->showReclamationModal = true;
    }

    public function closeReclamationModal()
    {
        $this->showReclamationModal = false;
        $this->selectedFeedbackId = null;
        $this->reset(['sujet', 'description', 'priorite', 'preuves']);
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

        } catch (\Exception $e) {
            Log::error('Erreur création réclamation: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la création de la réclamation.');
        }
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

        $avis = $query->orderBy('feedbacks.dateCreation', 'desc')->get();

        // Vérifier si chaque avis a déjà une réclamation
        foreach ($avis as $avis_item) {
            $avis_item->has_reclamation = DB::table('reclamantions')
                ->where('idFeedback', $avis_item->idFeedBack)
                ->where('idAuteur', $this->user->idUser)
                ->exists();
        }

        // Get available services for filter
        $services = DB::table('feedbacks')
            ->join('demandes_intervention', 'feedbacks.idDemande', '=', 'demandes_intervention.idDemande')
            ->join('services', 'demandes_intervention.idService', '=', 'services.idService')
            ->where('feedbacks.idCible', $this->user->idUser)
            ->select('services.nomService')
            ->distinct()
            ->pluck('nomService');

        // Statistiques
        $stats = [
            'total_avis' => $avis->count(),
            'avis_positifs' => $avis->where('note_moyenne', '>=', 4)->count(),
            'avis_negatifs' => $avis->where('note_moyenne', '<', 3)->count(),
        ];

        return view('livewire.shared.client.mes-avis', [
            'avis' => $avis,
            'stats' => $stats,
            'services' => $services
        ]);
    }
}
