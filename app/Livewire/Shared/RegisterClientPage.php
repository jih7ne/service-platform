<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use App\Models\Shared\Localisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterClientPage extends Component
{
    use WithFileUploads;

    // Propriétés du formulaire
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $password = '';
    public $telephone = '';
    public $dateNaissance = '';
    public $photo_profil = null;

    // Propriétés de localisation
    public $latitude = null;
    public $longitude = null;
    public $ville = '';
    public $adresse = '';
    public $auto_localisation = false;

    // Écouter les événements Livewire
    protected $listeners = ['setLocation'];

    // Règles de validation
    protected function rules()
    {
        $rules = [
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|min:2|max:50',
            'email' => [
                'required',
                'email',
                'unique:utilisateurs,email',
                function ($attribute, $value, $fail) {
                    // Vérifier si l'email est valide avec un service externe
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('L\'adresse email n\'est pas valide.');
                        return;
                    }
                    
                    // Vérifier si le domaine a des enregistrements MX
                    $domain = substr(strrchr($value, "@"), 1);
                    if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
                        $fail('Le domaine de cet email n\'existe pas ou n\'accepte pas les emails.');
                        return;
                    }
                }
            ],
            'password' => 'required|min:8',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
            'photo_profil' => 'nullable|image|max:5120',
        ];

        // L'adresse n'est requise que si la géolocalisation automatique n'est pas activée
        if (!$this->auto_localisation) {
            $rules['adresse'] = 'required|string|max:500';
        }

        return $rules;
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
        'photo_profil.image' => 'Le fichier doit être une image',
        'photo_profil.max' => 'L\'image ne peut pas dépasser 5MB',
        'adresse.required' => 'L\'adresse est requise',
    ];

    // Validation en temps réel
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Méthode appelée lorsque la case de géolocalisation automatique est cochée/décochée
     */
    public function updatedAutoLocalisation($value)
    {
        if ($value) {
            // Réinitialiser les valeurs de localisation
            $this->ville = '';
            $this->latitude = null;
            $this->longitude = null;
            
            // Déclencher l'événement JavaScript pour obtenir la position
            $this->dispatch('getLocation');
        } else {
            // Si l'utilisateur décoche, on réinitialise tout
            $this->ville = '';
            $this->latitude = null;
            $this->longitude = null;
        }
    }

    /**
     * Méthode appelée depuis JavaScript après obtention de la géolocalisation
     * 
     * @param float $latitude
     * @param float $longitude
     * @param string $city
     */
    public function setLocation($latitude, $longitude, $city)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ville = $city;
        
        Log::info('Localisation définie', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'ville' => $city
        ]);
    }

    /**
     * Méthode d'inscription principale
     */
    public function register()
    {
        // Valider les données
        $validatedData = $this->validate();

        try {
            DB::beginTransaction();

            // 1. Upload photo profil
            $photoPath = null;
            if ($this->photo_profil) {
                Log::info('Tentative upload photo', [
                    'original_name' => $this->photo_profil->getClientOriginalName(),
                    'size' => $this->photo_profil->getSize(),
                    'mime_type' => $this->photo_profil->getMimeType()
                ]);
                
                try {
                    $photoPath = $this->photo_profil->store('images', 'public');
                    Log::info('Photo uploadée avec succès', ['path' => $photoPath]);
                } catch (\Exception $e) {
                    Log::error('Erreur upload photo: ' . $e->getMessage());
                    $photoPath = null;
                }
            } else {
                Log::info('Aucune photo fournie');
            }

            // 2. Récupérer ou créer un admin par défaut
            $admin = Admin::first();
            
            if (!$admin) {
                $admin = Admin::create([
                    'emailAdmin' => 'admin@helpora.com',
                    'passwordAdmin' => Hash::make('admin123456')
                ]);
            }

            // 3. Créer l'utilisateur avec photo
            $userData = [
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
                'photo' => $photoPath,
                'idAdmin' => $admin->idAdmin
            ];
            
            Log::info('Tentative création utilisateur', ['data' => $userData]);
            
            $user = Utilisateur::create($userData);
            
            Log::info('Utilisateur créé avec succès', [
                'user_id' => $user->idUser,
                'email' => $user->email,
                'photo_path' => $user->photo
            ]);

            // 4. Créer la localisation
            Log::info('Tentative création localisation', [
                'user_id' => $user->idUser,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'ville' => $this->ville,
                'adresse' => $this->adresse,
                'auto_localisation' => $this->auto_localisation
            ]);

            // Créer la localisation - TOUJOURS créer un enregistrement même avec des données minimales
            $locationData = [
                'idUser' => $user->idUser,
                'latitude' => $this->latitude ?? 0,
                'longitude' => $this->longitude ?? 0,
                'ville' => $this->ville ?? 'Non spécifiée',
                'adresse' => $this->adresse ?? 'Adresse non spécifiée',
            ];
            
            Log::info('Données de localisation à insérer', $locationData);
            
            try {
                $location = Localisation::create($locationData);
                
                Log::info('Localisation créée avec succès', [
                    'location_id' => $location->idLocalisation,
                    'user_id' => $user->idUser,
                    'data' => $locationData
                ]);
            } catch (\Exception $e) {
                Log::error('Erreur création localisation: ' . $e->getMessage(), [
                    'error_trace' => $e->getTraceAsString(),
                    'data' => $locationData
                ]);
                // Continuer même si la localisation échoue
            }

            DB::commit();

            // Log pour debug
            Log::info('Inscription client réussie', [
                'user_id' => $user->idUser,
                'email' => $user->email,
                'localisation' => [
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'ville' => $this->ville,
                    'adresse' => $this->adresse
                ]
            ]);

            Auth::login($user);
            session()->flash('success', 'Compte client créé avec succès !');
            return redirect('/');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur création compte client', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.register-client-page');
    }
}