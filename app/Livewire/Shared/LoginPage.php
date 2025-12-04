<?php

namespace App\Livewire\Shared;

use Livewire\Component;




class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
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

    public function fillBabysitterCredentials()
    {
        $this->email = 'babysitter@helpora.com';
        $this->password = 'baby123';
        $this->remember = false;
    }

    public function fillClientCredentials()
    {
        $this->email = 'client@helpora.com';
        $this->password = 'client123';
        $this->remember = false;
    }

    public function login()
    {
        $this->validate();

        // Test credentials pour babysitter
        if ($this->email === 'babysitter@helpora.com' && $this->password === 'baby123') {
            session()->flash('success', 'Connexion réussie en tant que babysitter !');
            return redirect()->route('babysitter.dashboard');
        }

        // Test credentials pour client
        if ($this->email === 'client@helpora.com' && $this->password === 'client123') {
            session()->flash('success', 'Connexion réussie en tant que client !');
            return redirect()->route('home');
        }

        // Authentification normale
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Email ou mot de passe incorrect.');
    }

    public function navigateToRegister()
    {
        return redirect()->route('register');
    }

    public function navigateToForgotPassword()
    {
        return redirect()->route('password.request');
    }

    public function navigateToHome()
    {
        return redirect()->route('home');
    }

    
    public function render()
    {
        return view('livewire.shared.login-page');
    }

}