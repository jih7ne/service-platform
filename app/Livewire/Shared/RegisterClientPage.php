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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\Client\VerificationCodeClientEmail;

class RegisterClientPage extends Component
{
    use WithFileUploads;

    // Stepper pour la vérification
    public $currentStep = 1; // 1 = infos, 1.5 = vérification, 2 = finalisation
    public $codeVerified = false;
    
    // Vérification email
    public $verificationCode = '';
    public $generatedCode = '';

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
        $rules = [];
        
        if ($this->currentStep == 1) {
            $rules = [
                'firstName' => 'required|min:2|max:50',
                'lastName' => 'required|min:2|max:50',
                'email' => [
                    'required',
                    'email',
                    'unique:utilisateurs,email',
                    function ($attribute, $value, $fail) {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail('L\'adresse email n\'est pas valide.');
                            return;
                        }
                        
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
            ];
        } elseif ($this->currentStep == 1.5) {
            $rules = [
                'verificationCode' => 'required|size:10',
            ];
        } elseif ($this->currentStep == 2) {
            $rules = [
                'photo_profil' => 'nullable|image|max:5120',
            ];
            
            if (!$this->auto_localisation) {
                $rules['adresse'] = 'required|string|max:500';
            }
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
        'verificationCode.required' => 'Le code de vérification est obligatoire',
        'verificationCode.size' => 'Le code doit contenir exactement 10 caractères',
    ];

    // Validation en temps réel
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Envoyer le code de vérification par email
     */
    public function sendVerificationCode()
    {
        // Valider les champs de l'étape 1
        $this->validate([
            'firstName' => 'required|min:2|max:50',
            'lastName' => 'required|min:2|max:50',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
        ]);
        
        // Générer le code de vérification
        $this->generatedCode = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        
        // Stocker le code dans le cache pour 10 minutes
        Cache::put('verification_code_' . $this->email, $this->generatedCode, now()->addMinutes(10));
        
        // Envoyer l'email avec le code
        try {
            Mail::to($this->email)->send(new VerificationCodeClientEmail(
                $this->generatedCode,
                $this->firstName,
                $this->lastName
            ));
            
            // Passer à l'étape de vérification
            $this->currentStep = 1.5;
            session()->flash('success', 'Un code de vérification a été envoyé à votre email.');
            
        } catch (\Exception $e) {
            Log::error('Erreur envoi email vérification: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    /**
     * Vérifier le code saisi par l'utilisateur
     */
    public function verifyCode()
    {
        $this->validate([
            'verificationCode' => 'required|size:10',
        ]);

        $storedCode = Cache::get('verification_code_' . $this->email);
        
        if (!$storedCode) {
            session()->flash('error', 'Le code a expiré. Veuillez demander un nouveau code.');
            return;
        }

        if ($this->verificationCode !== $storedCode) {
            session()->flash('error', 'Code de vérification incorrect.');
            return;
        }

        $this->codeVerified = true;
        Cache::forget('verification_code_' . $this->email);
        $this->currentStep = 2;
        session()->flash('success', 'Email vérifié avec succès !');
    }

    /**
     * Renvoyer le code de vérification
     */
    public function resendCode()
    {
        $this->sendVerificationCode();
    }

    /**
     * Revenir à l'étape précédente
     */
    public function previousStep()
    {
        if ($this->currentStep == 1.5) {
            $this->currentStep = 1;
        } elseif ($this->currentStep == 2) {
            $this->currentStep = 1.5;
        }
    }

    /**
     * Méthode appelée lorsque la case de géolocalisation automatique est cochée/décochée
     */
    public function updatedAutoLocalisation($value)
    {
        if ($value) {
            $this->ville = '';
            $this->latitude = null;
            $this->longitude = null;
            $this->dispatch('getLocation');
        } else {
            $this->ville = '';
            $this->latitude = null;
            $this->longitude = null;
        }
    }

    /**
     * Méthode appelée depuis JavaScript après obtention de la géolocalisation
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
        // Vérifier que l'email a été vérifié
        if (!$this->codeVerified) {
            session()->flash('error', 'Veuillez d\'abord vérifier votre email.');
            return;
        }

        // Valider les données de l'étape finale
        $this->validate();

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
            }

            // 2. Récupérer ou créer un admin par défaut
            $admin = Admin::first();
            
            if (!$admin) {
                $admin = Admin::create([
                    'emailAdmin' => 'admin@helpora.com',
                    'passwordAdmin' => Hash::make('admin123456')
                ]);
            }

            // 3. Créer l'utilisateur
            $userData = [
                'nom' => $this->lastName,
                'prenom' => $this->firstName,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telephone' => $this->telephone,
                'dateNaissance' => $this->dateNaissance,
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
            }

            DB::commit();

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

    public function render()
    {
        return view('livewire.shared.register-client-page');
    }
}