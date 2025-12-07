<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterClientPage extends Component
{
    // Propriétés du formulaire
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $password = '';

    // Règles de validation
    protected $rules = [
        'firstName' => 'required|min:2|max:50',
        'lastName' => 'required|min:2|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ];

    // Messages de validation personnalisés
    protected $messages = [
        'firstName.required' => 'Le prénom est requis',
        'firstName.min' => 'Le prénom doit contenir au moins 2 caractères',
        'firstName.max' => 'Le prénom ne peut pas dépasser 50 caractères',
        'lastName.required' => 'Le nom est requis',
        'lastName.min' => 'Le nom doit contenir au moins 2 caractères',
        'lastName.max' => 'Le nom ne peut pas dépasser 50 caractères',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
    ];

    // Validation en temps réel
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Méthode d'inscription
    public function register()
    {
        // Valider les données
        $validatedData = $this->validate();

        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $validatedData['firstName'] . ' ' . $validatedData['lastName'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Connecter automatiquement l'utilisateur
            Auth::login($user);

            // Message de succès
            session()->flash('success', 'Compte client créé avec succès !');

            // Rediriger vers la page d'accueil
            return redirect('/');

        } catch (\Exception $e) {
            // En cas d'erreur
            session()->flash('error', 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.');
            
            // Log l'erreur pour le débogage
            Log::error('Erreur création compte client: ' . $e->getMessage());
        }
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register-client-page');
    }
}