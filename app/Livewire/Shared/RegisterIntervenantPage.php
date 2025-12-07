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

    // Méthode d'inscription
    public function register()
    {
        // Si le compte est client, rediriger
        if ($this->accountType === 'client') {
            return redirect('/inscriptionClient');
        }

        // Valider le type de service
        $this->validate();

        // Rediriger vers la page de formulaire avec le type de service
        // Vous pouvez passer le serviceType en session ou en paramètre
        session(['serviceType' => $this->serviceType]);
        
        return redirect('/inscriptionIntervenant/formulaire');
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register-intervenant-page');
    }
}