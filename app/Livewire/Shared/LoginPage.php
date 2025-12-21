<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Shared\Admin;
use App\Models\Shared\Utilisateur;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $showPassword = false;
    public $suspendedMessage = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
    ];

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login()
    {
        // Validation simple sans validate() pour éviter les erreurs
        if (empty($this->email) || empty($this->password)) {
            session()->flash('error', 'Email et mot de passe sont requis.');
            return;
        }

        // Vérifier si c'est un admin
        $admin = Admin::where('emailAdmin', $this->email)->first();
        
        if ($admin && Hash::check($this->password, $admin->passwordAdmin)) {
            session()->regenerate();
            session()->put('admin_id', $admin->idAdmin);
            session()->put('admin_email', $admin->emailAdmin);
            session()->put('is_admin', true);
            
            // Debug pour confirmer la connexion
            \Log::info('LoginPage: Connexion admin réussie', [
                'admin_id' => $admin->idAdmin,
                'admin_email' => $admin->emailAdmin,
                'session_complete' => session()->all()
            ]);
            
            session()->flash('success', 'Bienvenue Admin !');
            
            // Sauvegarder la session explicitement
            session()->save();
            
            // Dispatch l'événement pour la redirection
            $this->dispatch('redirect-admin', url: route('admin.dashboard'));
        }

        // Vérifier l'utilisateur normal
        $user = Utilisateur::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            session()->flash('error', 'Email ou mot de passe incorrect.');
            return;
        }

        if ($user->statut !== 'actif') {
            $this->suspendedMessage = 'Votre compte est suspendu.';
            return;
        }

        // Connecter l'utilisateur
        Auth::login($user);
        session()->regenerate();
        session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');

        // Redirection simple
        if ($user->role === 'intervenant') {
            return redirect('/intervenant/hub');
        }
        
        return redirect('/');
    }

    public function navigateToRegister()
    {
        return redirect('/inscriptionClient');
    }

    public function navigateToHome()
    {
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.shared.login-page');
    }
}