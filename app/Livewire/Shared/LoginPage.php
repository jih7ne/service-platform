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
    public $suspendedMessage = ''; // 👈 AJOUTER CETTE LIGNE

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
        $this->validate();

        // ========================================
        // 1. VÉRIFIER SI C'EST UN ADMIN D'ABORD
        // ========================================
        $admin = Admin::where('emailAdmin', $this->email)->first();
        
        if ($admin && Hash::check($this->password, $admin->passwordAdmin)) {
            // Connexion admin réussie
            session()->regenerate();
            session()->put('admin_id', $admin->idAdmin);
            session()->put('admin_email', $admin->emailAdmin);
            session()->put('is_admin', true);
            
            session()->flash('success', 'Bienvenue Admin !');
            return redirect()->route('admin.dashboard');
        }

        // ========================================
        // 2. VÉRIFIER L'UTILISATEUR NORMAL
        // ========================================
        $user = Utilisateur::where('email', $this->email)->first();

        // DEBUG - À SUPPRIMER APRÈS
        \Log::info('User trouvé:', ['user' => $user ? $user->toArray() : 'null']);

        // Si l'utilisateur n'existe pas
        if (!$user) {
            $this->addError('email', 'Email ou mot de passe incorrect.');
            return;
        }

        // DEBUG - À SUPPRIMER APRÈS
        \Log::info('Vérification mot de passe:', [
            'hash_check' => Hash::check($this->password, $user->password),
            'password_input' => $this->password,
            'password_hash' => $user->password
        ]);

        // Vérifier le mot de passe
        if (!Hash::check($this->password, $user->password)) {
            $this->addError('email', 'Email ou mot de passe incorrect.');
            return;
        }

        // DEBUG - À SUPPRIMER APRÈS
        \Log::info('Statut utilisateur:', ['statut' => $user->statut]);

        // Vérifier le statut
        if ($user->statut !== 'actif') {
            \Log::info('Compte suspendu détecté!');
            $this->suspendedMessage = 'Votre compte est suspendu. Veuillez consulter votre email pour connaître la raison de la désactivation.';
            return;
        }

        // ========================================
        // 3. TOUT EST OK - CONNECTER L'UTILISATEUR
        // ========================================
        Auth::login($user);
        session()->regenerate();

        // --- LOGIQUE DE REDIRECTION UTILISATEUR ---
        if ($user->role === 'intervenant') {
            session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');
            return redirect()->route('intervenant.hub');
        }

        if ($user->role === 'client') {
            return redirect('/');
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