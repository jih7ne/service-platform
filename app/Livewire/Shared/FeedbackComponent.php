<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Shared\Feedback as FeedbackModel;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\DemandesIntervention;
use Illuminate\Support\Facades\DB;

class FeedbackComponent extends Component
{
    // IDs
    public $demandeId;
    public $auteurId;
    public $cibleId;
    public $typeAuteur;
    public $typeService; // babysitter, tutoring, petkeeping
    public $serviceId; // ID du service associé

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

    public function mount($idService = null, $demandeId = null, $auteurId = null, $cibleId = null, $typeAuteur = 'client')
    {
        // Debug logs
        \Log::info('Feedback mount - Parameters: ', [
            'idService' => $idService,
            'demandeId' => $demandeId,
            'auteurId' => $auteurId,
            'cibleId' => $cibleId,
            'typeAuteur' => $typeAuteur
        ]);
        
        // Valider les paramètres requis
        if (!$idService || !$demandeId || !$auteurId || !$cibleId) {
            session()->flash('error', 'Paramètres manquants: idService, demandeId, auteurId et cibleId sont requis');
            return;
        }
        
        $this->serviceId = $idService;
        $this->demandeId = $demandeId;
        $this->auteurId = $auteurId;
        $this->cibleId = $cibleId;
        $this->typeAuteur = $typeAuteur;
        
        // Déterminer le type de service AVANT de charger les données
        $this->determineServiceType();
        
        $this->loadData();
        
        \Log::info('Feedback mount - Service type detected: ' . $this->typeService);
    }

    private function determineServiceType()
    {
        try {
            // Utiliser l'ID service pour déterminer le type
            $service = DB::table('services')
                ->where('idService', $this->serviceId)
                ->first();
            
            if (!$service) {
                session()->flash('error', 'Service non trouvé avec ID: ' . $this->serviceId);
                return;
            }
            
            // Déterminer le type selon le nom du service
            switch ($service->nomService) {
                case 'Soutien Scolaire':
                    $this->typeService = 'tutoring';
                    break;
                case 'Babysitting':
                    $this->typeService = 'babysitter';
                    break;
                case 'Garde d\'Animaux':
                case 'Pet Keeping':
                    $this->typeService = 'petkeeping';
                    break;
                default:
                    $this->typeService = 'petkeeping'; // Valeur par défaut
                    break;
            }
            
        } catch (\Exception $e) {
            \Log::error('Erreur determineServiceType: ' . $e->getMessage());
            $this->typeService = 'babysitter'; // Valeur par défaut
        }
    }

    private function loadData()
    {
        try {
            // Charger la demande depuis demandes_intervention pour tous les services
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

            // Vérifier si la demande existe
            $demandeExists = DB::table('demandes_intervention')->where('idDemande', $this->demandeId)->exists();
            $idDemandeToUse = $demandeExists ? $this->demandeId : null;

            // Calculer la note moyenne
            $noteMoyenne = ($this->ponctualite + $this->professionnalisme + 
                           $this->relationAvecEnfants + $this->communication + 
                           $this->proprete) / 5;

            // Créer le feedback
            \Log::info('Creating feedback with data:', [
                'idAuteur' => $this->auteurId,
                'idCible' => $this->cibleId,
                'typeAuteur' => $this->typeAuteur,
                'noteMoyenne' => $noteMoyenne,
                'noteMoyenneType' => gettype($noteMoyenne),
                'idDemande' => $idDemandeToUse,
                'idService' => $this->serviceId
            ]);
            
            $feedbackData = [
                'idAuteur' => $this->auteurId,
                'idCible' => $this->cibleId,
                'typeAuteur' => $this->typeAuteur,
                'commentaire' => $this->commentaire,
                'credibilite' => $this->professionnalisme,
                'sympathie' => $this->relationAvecEnfants,
                'ponctualite' => $this->ponctualite,
                'proprete' => $this->proprete,
                'qualiteTravail' => $this->communication,
                'moyenne' => $noteMoyenne,
                'estVisible' => true,
                'dateCreation' => now(),
                'idDemande' => $idDemandeToUse,
                'idService' => $this->serviceId,
            ];
            
            \Log::info('Feedback data before create:', [
                'data' => $feedbackData,
                'moyenneValue' => $feedbackData['moyenne'],
                'moyenneType' => gettype($feedbackData['moyenne'])
            ]);
            
            $feedback = FeedbackModel::create($feedbackData);
            
            \Log::info('Feedback created successfully:', [
                'idFeedBack' => $feedback->idFeedBack,
                'storedMoyenne' => $feedback->moyenne,
                'storedMoyenneType' => gettype($feedback->moyenne),
                'allData' => $feedback->toArray()
            ]);
            
            // FORCER LA MISE À JOUR DE LA MOYENNE avec SQL direct
            $updateResult = DB::table('feedbacks')
                ->where('idFeedBack', $feedback->idFeedBack)
                ->update(['moyenne' => $noteMoyenne]);
            
            \Log::info('Forced moyenne update:', [
                'feedbackId' => $feedback->idFeedBack,
                'noteMoyenne' => $noteMoyenne,
                'updateResult' => $updateResult
            ]);
            
            // Vérification immédiate dans la base
            $checkFeedback = FeedbackModel::find($feedback->idFeedBack);
            \Log::info('Verification from database after forced update:', [
                'dbMoyenne' => $checkFeedback->moyenne,
                'dbMoyenneType' => gettype($checkFeedback->moyenne)
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
        // Récupérer tous les feedbacks existants pour cet utilisateur
        $existingFeedbacks = FeedbackModel::where('idCible', $userId)->get();
        
        // Utiliser directement la colonne moyenne de chaque feedback
        $totalExistingSum = 0;
        $existingCount = 0;
        
        foreach ($existingFeedbacks as $feedback) {
            // Utiliser la moyenne déjà stockée dans la base
            $totalExistingSum += $feedback->moyenne;
            $existingCount++;
        }
        
        // Ajouter le nouveau feedback
        $totalRatings = $existingCount + 1;
        $newAverage = ($totalExistingSum + $newRating) / $totalRatings;
        
        // Mettre à jour l'utilisateur avec la nouvelle moyenne et le nombre d'avis
        $updated = Utilisateur::where('idUser', $userId)->update([
            'note' => round($newAverage, 2), // Arrondir à 2 décimales pour plus de précision
            'nbrAvis' => $totalRatings
        ]);
        
        // Log pour débogage
        \Log::info('User rating updated using stored moyennes', [
            'userId' => $userId,
            'existingCount' => $existingCount,
            'totalExistingSum' => $totalExistingSum,
            'newRating' => $newRating,
            'newAverage' => $newAverage,
            'totalRatings' => $totalRatings,
            'updated' => $updated
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
                return view('livewire.pet-keeping.feedback-petkeeping');
            case 'babysitter':
                return view('livewire.babysitter.feedback-babysitter');
            default:
                // Cas par défaut si le type n'est pas reconnu
                return view('livewire.babysitter.feedback-babysitter');
        }
    }
}