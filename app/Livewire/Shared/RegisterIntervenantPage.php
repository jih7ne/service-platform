<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class RegisterIntervenantPage extends Component
{
    // Propriétés
    public $accountType = 'intervenant';
    public $serviceType = '';

    // Règles de validation
    protected $rules = [
        'serviceType' => 'required|in:professeur,babysitter,petkeeper',
    ];

    // Messages de validation
    protected $messages = [
        'serviceType.required' => 'Veuillez sélectionner un type de service',
        'serviceType.in' => 'Le type de service sélectionné n\'est pas valide',
    ];

    // Quand le type de compte change
    public function updatedAccountType($value)
    {
        if ($value === 'client') {
            return redirect('/inscriptionClient');
        }
    }

    // NOUVELLE MÉTHODE : Quand le type de service change
    public function updatedServiceType($value)
    {
        // Si babysitter est sélectionné, rediriger immédiatement
        if ($value === 'babysitter') {
            return redirect('/inscriptionBabysitter');
        }
    }

    // Méthode d'inscription
    public function register()
    {
        // Si le compte est client, rediriger
        if ($this->accountType === 'client') {
            return redirect('/inscriptionClient');
        }

    // Valider le type de service
    $this->validate();

        // Redirection selon le type de service
        switch ($this->serviceType) {
            case 'babysitter':
                return redirect('/inscriptionBabysitter');
            
            case 'professeur':
                // Rediriger vers le formulaire professeur
                session(['serviceType' => 'professeur']);
                return redirect('/inscriptionIntervenant/formulaire');
            
            case 'petkeeper':
                // Rediriger vers le formulaire petkeeper
                session(['serviceType' => 'petkeeper']);
                return redirect('/inscriptionIntervenant/formulaire');
            
            default:
                return redirect('/inscriptionIntervenant/formulaire');
        }
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register-intervenant-page');
    }
}