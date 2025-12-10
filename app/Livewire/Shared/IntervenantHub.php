<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Intervenant;

class IntervenantHub extends Component
{
    public $services = [];
    public $prenom;
    

    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;

        
        $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();

        if ($intervenant) {
            // On charge les services associés
            $this->services = $intervenant->services;
        }
    }

    public function logout()
    {
        Auth::logout(); // Déconnecte l'utilisateur
        session()->invalidate(); // Détruit la session (sécurité)
        session()->regenerateToken(); // Régénère le token CSRF

        return redirect('/'); // Redirige vers l'accueil
    }

    public function render()
    {
        return view('livewire.shared.intervenant-hub');
    }
}