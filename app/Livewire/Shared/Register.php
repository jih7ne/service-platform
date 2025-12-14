<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class Register extends Component
{
    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register');
    }

    /**
     * Rediriger vers la page d'inscription babysitter
     */
    public function redirectToBabysitterRegistration()
    {
        return redirect()->route('inscription.babysitter');
    }
    
    /**
     * Rediriger vers la page d'inscription intervenant
     */
    public function redirectToIntervenantRegistration()
    {
        return redirect()->to('/inscriptionIntervenant');
    }
}