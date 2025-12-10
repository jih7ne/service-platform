<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegisterClientPage extends Component
{
    // Propriétés du formulaire
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $password = '';
    public $telephone = '';
    public $dateNaissance = '';

    // Règles de validation
    protected function rules()
    {
        return [
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|min:2|max:50',
            'email' => 'required|email|unique:utilisateur,email',
            'password' => 'required|min:8',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
        ];
    }

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
        'telephone.required' => 'Le numéro de téléphone est requis',
        'telephone.min' => 'Le numéro de téléphone est invalide',
        'telephone.max' => 'Le numéro de téléphone est invalide',
        'dateNaissance.required' => 'La date de naissance est requise',
        'dateNaissance.date' => 'La date de naissance est invalide',
        'dateNaissance.before' => 'La date de naissance doit être dans le passé',
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
            DB::beginTransaction();

            // ✅ Récupérer ou créer un admin par défaut
            $admin = Admin::first();
            
            if (!$admin) {
                // Si aucun admin n'existe, en créer un par défaut
                $admin = Admin::create([
                    'emailAdmin' => 'admin@helpora.com',
                    'passwordAdmin' => Hash::make('admin123456')
                ]);
            }

            // ✅ Créer l'utilisateur avec idAdmin
            $user = Utilisateur::create([
                'nom' => $validatedData['lastName'],
                'prenom' => $validatedData['firstName'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'telephone' => $validatedData['telephone'],
                'dateNaissance' => $validatedData['dateNaissance'],
                'role' => 'client',
                'statut' => 'actif',
                'note' => 0,
                'nbrAvis' => 0,
                'idAdmin' => $admin->idAdmin  // ✅ Ajout de idAdmin
            ]);

            DB::commit();

            // Connecter automatiquement l'utilisateur
            Auth::login($user);

            // Message de succès
            session()->flash('success', 'Compte client créé avec succès !');

            // Rediriger vers la page d'accueil
            return redirect('/');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // En cas d'erreur
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
            
            // Log l'erreur pour le débogage
            Log::error('Erreur création compte client: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register-client-page');
    }
}