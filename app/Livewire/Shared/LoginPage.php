<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Shared\Admin;
use App\Models\Shared\Utilisateur;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;
    public $suspendedMessage = '';
    public $recaptchaToken = '';

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

    private function verifyRecaptcha($token)
    {
        $secret = config('services.recaptcha.secret_key');
        
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        $result = $response->json();
        
        return $result['success'] ?? false;
    }

    public function login()
    {
        $this->validate();

        // Verify reCAPTCHA
        if (empty($this->recaptchaToken)) {
            $this->addError('recaptcha', 'Veuillez compléter le reCAPTCHA.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        if (!$this->verifyRecaptcha($this->recaptchaToken)) {
            $this->addError('recaptcha', 'Vérification reCAPTCHA échouée. Veuillez réessayer.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        // Vérifier si c'est un admin d'abord
        $admin = Admin::where('emailAdmin', $this->email)->first();
        
        if ($admin && Hash::check($this->password, $admin->passwordAdmin)) {
            session()->regenerate();
            session()->put('admin_id', $admin->idAdmin);
            session()->put('admin_email', $admin->emailAdmin);
            session()->put('is_admin', true);
            
            session()->flash('success', 'Bienvenue Admin !');
            return redirect()->route('admin.dashboard');
        }

        // Vérifier l'utilisateur normal
        $user = Utilisateur::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Email ou mot de passe incorrect.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->addError('email', 'Email ou mot de passe incorrect.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        if ($user->statut !== 'actif') {
            $this->suspendedMessage = 'Votre compte est suspendu. Veuillez consulter votre email pour connaître la raison de la désactivation.';
            $this->dispatch('reset-recaptcha');
            return;
        }

        // Connecter l'utilisateur
        Auth::login($user, $this->remember);
        session()->regenerate();

        // Logique de redirection utilisateur
        if ($user->role === 'intervenant') {
            session()->flash('success', 'Bienvenue ' . $user->prenom . ' !');

            $intervenant = \App\Models\Shared\Intervenant::where('IdIntervenant', $user->idUser)->first();

            if ($intervenant) {
                $services = $intervenant->services; 
                $count = $services->count();

                if ($count > 1 || $count === 0) {
                    return redirect()->route('intervenant.hub');
                }
                
                if ($count === 1) {
                    $serviceName = strtolower($services->first()->nomService);

                    if (str_contains($serviceName, 'soutien') || str_contains($serviceName, 'scolaire')) {
                        return redirect()->route('tutoring.dashboard');
                    }
                    
                    if (str_contains($serviceName, 'baby')) {
                        return redirect()->route('intervenant.hub');
                    }

                    if (str_contains($serviceName, 'pet')) {
                        return redirect()->route('intervenant.hub');
                    }
                }
            }
            
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