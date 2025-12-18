<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Shared\Feedback;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeedbackBabysitter extends Component
{
    public $demandeId;
    public $demande;
    public $cible;
    
    // State
    public $feedbackSubmitted = false;
    public $showRecap = false;
    public $currentStep = 1;
    public $totalSteps = 3;

    // Ratings
    public $ponctualite = 0;
    public $professionnalisme = 0;
    public $relationAvecEnfants = 0;
    public $communication = 0;
    public $proprete = 0;
    public $commentaire = '';

    protected $rules = [
        'ponctualite' => 'required|integer|min:1|max:5',
        'professionnalisme' => 'required|integer|min:1|max:5',
        'relationAvecEnfants' => 'required|integer|min:1|max:5',
        'communication' => 'required|integer|min:1|max:5',
        'proprete' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string|max:1000',
    ];

    public function mount($id)
    {
        $this->demandeId = $id;
        $this->demande = DemandeIntervention::with('client')->findOrFail($id);
        $this->cible = $this->demande->client;
    }

    public function setRating($criteria, $value)
    {
        if (in_array($criteria, ['ponctualite', 'professionnalisme', 'relationAvecEnfants', 'communication', 'proprete'])) {
            $this->$criteria = $value;
        }
    }

    public function nextStep()
    {
        $this->validateStep();
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

    public function validateStep()
    {
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
    }

    public function showRecapitulatif()
    {
        $this->validateStep(); // Validate last step
        $this->showRecap = true;
    }

    public function editFeedback()
    {
        $this->showRecap = false;
    }

    public function getAverageRating()
    {
        $total = $this->ponctualite + $this->professionnalisme + $this->relationAvecEnfants + $this->communication + $this->proprete;
        return round($total / 5, 1);
    }

    public function submitFeedback()
    {
        // Valider toutes les données
        $this->validate();

        try {
            DB::beginTransaction();

            // Debug: Vérifier les données avant insertion
            \Log::info('Tentative de création de feedback', [
                'idAuteur' => auth()->id(),
                'idCible' => $this->cible->idUser,
                'idDemande' => $this->demandeId,
                'typeAuteur' => 'intervenant', // Correct : babysitter est un intervenant
                'ponctualite' => $this->ponctualite,
                'professionnalisme' => $this->professionnalisme,
                'relationAvecEnfants' => $this->relationAvecEnfants,
                'communication' => $this->communication,
                'proprete' => $this->proprete,
                'commentaire' => $this->commentaire
            ]);

            // Créer le feedback
            $feedback = Feedback::create([
                'idAuteur' => auth()->id(),
                'idCible' => $this->cible->idUser,
                'typeAuteur' => 'intervenant', // Correct : babysitter est un intervenant
                'commentaire' => $this->commentaire,
                'credibilite' => $this->professionnalisme, // Mapper professionnalisme -> credibilite
                'sympathie' => $this->relationAvecEnfants, // Mapper relationAvecEnfants -> sympathie
                'ponctualite' => $this->ponctualite,
                'proprete' => $this->proprete,
                'qualiteTravail' => $this->communication, // Mapper communication -> qualiteTravail
                'estVisible' => true,
                'dateAffichage' => Carbon::now(),
                'dateCreation' => Carbon::now(),
                'idDemande' => $this->demandeId
            ]);

            \Log::info('Feedback créé avec succès', ['idFeedBack' => $feedback->idFeedBack]);

            // Mettre à jour la moyenne de l'utilisateur cible
            $this->updateUserRating($this->cible->idUser);

            DB::commit();

            $this->feedbackSubmitted = true;
            $this->showRecap = false;

            session()->flash('success', 'Votre feedback a été enregistré avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Log::error('Erreur de base de données lors de la création du feedback', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings()
            ]);
            session()->flash('error', 'Erreur de base de données: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la création du feedback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    private function updateUserRating($userId)
    {
        // Calculer la nouvelle moyenne
        $average = Feedback::where('idCible', $userId)
            ->where('estVisible', true)
            ->avg(DB::raw('(credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5'));

        // Mettre à jour la colonne moyenne dans la table feedbacks pour tous les feedbacks de cet utilisateur
        Feedback::where('idCible', $userId)
            ->where('estVisible', true)
            ->update([
                'moyenne' => round($average, 2)
            ]);
    }

    public function render()
    {
        return view('livewire.babysitter.feedback-babysitter');
    }
}
