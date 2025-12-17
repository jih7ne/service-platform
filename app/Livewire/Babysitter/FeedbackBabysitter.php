<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\DemandeIntervention;

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
        // Here you would save the feedback to the database
        // For example:
        // Feedback::create([
        //     'demande_id' => $this->demandeId,
        //     'auteur_id' => auth()->id(),
        //     'cible_id' => $this->cible->id,
        //     'note' => $this->getAverageRating(),
        //     'details' => json_encode([
        //         'ponctualite' => $this->ponctualite,
        //         // ...
        //     ]),
        //     'commentaire' => $this->commentaire
        // ]);

        $this->feedbackSubmitted = true;
        $this->showRecap = false;
    }

    public function render()
    {
        return view('livewire.babysitter.feedback-babysitter');
    }
}
