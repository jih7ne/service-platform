<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class Register extends Component
{
   


    public $accountType = 'client'; // 'client' ou 'intervenant'
    public $step = 1; // Étape du formulaire

    // Données du formulaire
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $address = '';
    public $terms = false;

    public function selectAccountType($type)
    {
        $this->accountType = $type;
    }

    public function continueToForm()
    {
        if (!$this->accountType) {
            session()->flash('error', 'Veuillez sélectionner un type de compte');
            return;
        }

        $this->step = 2;
    }

    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Le nom est requis',
            'name.min' => 'Le nom doit contenir au moins 3 caractères',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation',
        ]);

        // Créer l'utilisateur ici
        // User::create([...])

        session()->flash('success', 'Compte créé avec succès !');
        return redirect()->route('login');
    }

    public function navigateToLogin()
    {
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.shared.register');
    }
}
