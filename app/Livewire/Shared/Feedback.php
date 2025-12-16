<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Shared\Feedback as FeedbackModel;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\DemandesIntervention;
use Illuminate\Support\Facades\DB;

class Feedback extends Component
{
    // IDs
    public $demandeId;
    public $auteurId;
    public $cibleId;
    public $typeAuteur;
    public $typeService; // babysitter, tutoring, petkeeping

    // Informations de la demande
    public $demande;
    public $auteur;
    public $cible;

    // Étapes du formulaire
    public $currentStep = 1;
    public $totalSteps = 3;

    // Critères de notation (1-5 étoiles)
    public $ponctualite = 0;
    public $professionnalisme = 0;
    public $relationAvecEnfants = 0;
    public $communication = 0;
    public $proprete = 0;

    // Commentaire
    public $commentaire = '';

    // Récapitulatif
    public $showRecap = false;
    public $feedbackSubmitted = false;

    protected $rules = [
        'ponctualite' => 'required|integer|min:1|max:5',
        'professionnalisme' => 'required|integer|min:1|max:5',
        'relationAvecEnfants' => 'required|integer|min:1|max:5',
        'communication' => 'required|integer|min:1|max:5',
        'proprete' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'ponctualite.required' => 'Veuillez noter la ponctualité',
        'ponctualite.min' => 'La note doit être au minimum de 1 étoile',
        'ponctualite.max' => 'La note doit être au maximum de 5 étoiles',
        'professionnalisme.required' => 'Veuillez noter le professionnalisme',
        'relationAvecEnfants.required' => 'Veuillez noter la relation avec les enfants',
        'communication.required' => 'Veuillez noter la communication',
        'proprete.required' => 'Veuillez noter la propreté',
    ];

    public function mount($demandeId = null, $auteurId = null, $cibleId = null, $typeAuteur = 'client')
    {
        // Valider les paramètres requis
        if (!$demandeId || !$auteurId || !$cibleId) {
            session()->flash('error', 'Paramètres manquants: demandeId, auteurId et cibleId sont requis');
            return;
        }
        
        $this->demandeId = $demandeId;
        $this->auteurId = $auteurId;
        $this->cibleId = $cibleId;
        $this->typeAuteur = $typeAuteur;

        // Charger les données depuis la base
        $this->loadData();
        
        // Déterminer le type de service
        $this->determineServiceType();
    }

    private function determineServiceType()
    {
        try {
            // Récupérer l'intervenant pour déterminer son type
            $intervenant = DB::table('intervenants')
                ->where('IdIntervenant', $this->cibleId)
                ->first();
            
            if (!$intervenant) {
                session()->flash('error', 'Intervenant non trouvé');
                return;
            }
            
            // Vérifier dans chaque table spécifique pour déterminer le type
            $babysitter = DB::table('babysitters')
                ->where('idBabysitter', $intervenant->IdIntervenant)
                ->first();
            
            if ($babysitter) {
                $this->typeService = 'babysitter';
                return;
            }
            
            $professeur = DB::table('professeurs')
                ->where('intervenant_id', $intervenant->id)
                ->first();
            
            if ($professeur) {
                $this->typeService = 'tutoring';
                return;
            }
            
            $petkeeper = DB::table('petkeepers')
                ->where('idPetKeeper', $intervenant->IdIntervenant)
                ->first();
            
            if ($petkeeper) {
                $this->typeService = 'petkeeping';
                return;
            }
            
            // Si aucun type trouvé, utiliser babysitter par défaut
            $this->typeService = 'babysitter';
            
        } catch (\Exception $e) {
            \Log::error('Erreur determineServiceType: ' . $e->getMessage());
            $this->typeService = 'babysitter'; 
        }
    }

    private function loadData()
    {
        try {
            // Charger la demande depuis la base de données
            $this->demande = DemandesIntervention::find($this->demandeId);
            
            if (!$this->demande) {
                session()->flash('error', 'Demande introuvable');
                return;
            }

            // Charger l'auteur depuis la base de données
            $this->auteur = Utilisateur::find($this->auteurId);
            
            if (!$this->auteur) {
                session()->flash('error', 'Auteur introuvable');
                return;
            }

            // Charger la cible depuis la base de données
            $this->cible = Utilisateur::find($this->cibleId);
            
            if (!$this->cible) {
                session()->flash('error', 'Destinataire introuvable');
                return;
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement des données: ' . $e->getMessage());
            \Log::error('Load data error: ' . $e->getMessage());
        }
    }

    public function setRating($criteria, $value)
    {
        $this->$criteria = $value;
    }

    public function nextStep()
    {
        // Validation selon l'étape
        if ($this->currentStep === 1) {
            $this->validate([
                'ponctualite' => 'required|integer|min:1|max:5',
                'professionnalisme' => 'required|integer|min:1|max:5',
                'relationAvecEnfants' => 'required|integer|min:1|max:5',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'communication' => 'required|integer|min:1|max:5',
                'proprete' => 'required|integer|min:1|max:5',
            ]);
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function showRecapitulatif()
    {
        $this->validate();
        $this->showRecap = true;
    }

    public function editFeedback()
    {
        $this->showRecap = false;
        $this->currentStep = 1;
    }

    public function submitFeedback()
    {
        // Debug simple
        \Log::info('SUBMIT FEEDBACK CALLED!!!');
        
        $this->validate();

        try {
            DB::beginTransaction();

            // Calculer la note moyenne
            $noteMoyenne = ($this->ponctualite + $this->professionnalisme + 
                           $this->relationAvecEnfants + $this->communication + 
                           $this->proprete) / 5;

            // Créer le feedback
            $feedback = FeedbackModel::create([
                'idAuteur' => $this->auteurId,
                'idCible' => $this->cibleId,
                'typeAuteur' => $this->typeAuteur,
                'commentaire' => $this->commentaire,
                'credibilite' => $this->professionnalisme,
                'sympathie' => $this->relationAvecEnfants,
                'ponctualite' => $this->ponctualite,
                'proprete' => $this->proprete,
                'qualiteTravail' => $this->communication,
                'estVisible' => true,
                'dateCreation' => now(),
                'idDemande' => $this->demandeId,
            ]);

            // Mettre à jour la note de l'utilisateur cible
            $this->updateUserRating($this->cibleId, $noteMoyenne);

            DB::commit();

            $this->feedbackSubmitted = true;
            
            session()->flash('success', 'Votre évaluation a été soumise avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
            
            // Log l'erreur pour debug
            \Log::error('Feedback submission error: ' . $e->getMessage());
        }
    }

    private function updateUserRating($userId, $newRating)
    {
        // Récupérer tous les feedbacks pour cet utilisateur
        $feedbacks = FeedbackModel::where('idCible', $userId)->get();
        
        $totalRatings = $feedbacks->count() + 1; // +1 pour le nouveau feedback
        
        // Calculer la nouvelle note moyenne
        $currentSum = $feedbacks->sum(function($feedback) {
            return ($feedback->credibilite + $feedback->sympathie + 
                    $feedback->ponctualite + $feedback->proprete + 
                    $feedback->qualiteTravail) / 5;
        });
        
        $newAverage = ($currentSum + $newRating) / $totalRatings;

        // Mettre à jour l'utilisateur
        Utilisateur::where('idUser', $userId)->update([
            'note' => round($newAverage, 1),
            'nbrAvis' => $totalRatings
        ]);
    }

    public function getAverageRating()
    {
        if ($this->ponctualite === 0) return 0;
        
        return round(($this->ponctualite + $this->professionnalisme + 
                     $this->relationAvecEnfants + $this->communication + 
                     $this->proprete) / 5, 1);
    }

    public $testDebug = '';

    public function updatedTestDebug($value)
    {
        \Log::info('Debug button clicked! Value: ' . $value);
    }

    public function render()
    {
        // Retourner la vue selon le type de service
        switch ($this->typeService) {
            case 'tutoring':
                return view('livewire.tutoring.feedback-tutoring');
            case 'petkeeping':
                return view('livewire.petkeeping.feedback-petkeeping');
            case 'babysitter':
            default:
                return view('livewire.babysitter.feedback-babysitter');
        }
    }
}