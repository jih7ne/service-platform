<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Shared\Admin;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $showPassword = false;

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
        // 2. SINON, VÉRIFIER LES UTILISATEURS NORMAUX
        // ========================================
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            $user = Auth::user();

            if ($user->statut !== 'actif') {
                Auth::logout();
                $this->addError('email', 'Votre compte est suspendu.');
                return;
            }

            // --- LOGIQUE DE REDIRECTION UTILISATEUR ---
            if ($user->role === 'intervenant') {
                session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');

                // 1. On récupère l'intervenant
                $intervenant = \App\Models\Shared\Intervenant::where('IdIntervenant', $user->idUser)->first();

                if ($intervenant) {
                    // 2. On compte ses services
                    $services = $intervenant->services; 
                    $count = $services->count();

                    // CAS 1 : Plusieurs services (ou aucun) -> On envoie vers le HUB
                    if ($count > 1 || $count === 0) {
                        return redirect()->route('intervenant.hub');
                    }
                    
                    // CAS 2 : Exactement UN service -> Redirection DIRECTE
                    if ($count === 1) {
                        // On récupère le nom du service en minuscule pour comparer
                        $serviceName = strtolower($services->first()->nomService);

                        // Si c'est du soutien scolaire
                        if (str_contains($serviceName, 'soutien') || str_contains($serviceName, 'scolaire')) {
                            return redirect()->route('tutoring.dashboard');
                        }
                        
                        // Si c'est du babysitting
                        if (str_contains($serviceName, 'baby')) {
                             // return redirect()->route('babysitter.dashboard'); // (Pas encore prêt)
                             return redirect()->route('intervenant.hub'); // En attendant, on envoie au hub
                        }

                        // Si c'est du pet keeping
                        if (str_contains($serviceName, 'pet')) {
                             // return redirect()->route('petkeeping.dashboard'); // (Pas encore prêt)
                             return redirect()->route('intervenant.hub'); // En attendant, on envoie au hub
                        }
                    }
                }
                
                // Sécurité : si on est perdu, on va au Hub
                return redirect()->route('intervenant.hub');
            }

            if ($user->role === 'client') {
                return redirect('/');
            }

            return redirect('/');
        }

        $this->addError('email', 'Email ou mot de passe incorrect.');
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