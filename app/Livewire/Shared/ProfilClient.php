<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Utilisateur;

class ProfilClient extends Component
{
    use WithFileUploads;

    // Informations utilisateur
    public $nom = '';
    public $prenom = '';
    public $email = '';
    public $telephone = '';
    public $dateNaissance = '';
    public $photo;
    public $newPhoto;

    // Changement de mot de passe
    public $currentPassword = '';
    public $newPassword = '';
    public $newPasswordConfirmation = '';

    // États
    public $editMode = false;
    public $showPasswordForm = false;

    // Règles de validation pour le profil
    protected function rulesProfile()
    {
        $userId = Auth::id();
        
        return [
            'nom' => 'required|min:2|max:50',
            'prenom' => 'required|min:2|max:50',
            'email' => 'required|email|unique:utilisateurs,email,' . $userId . ',idUser',
            'telephone' => 'required|min:10|max:20',
            'dateNaissance' => 'required|date|before:today',
            'newPhoto' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    // Règles de validation pour le mot de passe
    protected function rulesPassword()
    {
        return [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|same:newPasswordConfirmation',
            'newPasswordConfirmation' => 'required',
        ];
    }

    // Messages de validation personnalisés
    protected $messages = [
        'nom.required' => 'Le nom est requis',
        'nom.min' => 'Le nom doit contenir au moins 2 caractères',
        'nom.max' => 'Le nom ne peut pas dépasser 50 caractères',
        'prenom.required' => 'Le prénom est requis',
        'prenom.min' => 'Le prénom doit contenir au moins 2 caractères',
        'prenom.max' => 'Le prénom ne peut pas dépasser 50 caractères',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email doit être valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'telephone.required' => 'Le numéro de téléphone est requis',
        'telephone.min' => 'Le numéro de téléphone est invalide',
        'telephone.max' => 'Le numéro de téléphone est invalide',
        'dateNaissance.required' => 'La date de naissance est requise',
        'dateNaissance.date' => 'La date de naissance est invalide',
        'dateNaissance.before' => 'La date de naissance doit être dans le passé',
        'newPhoto.image' => 'Le fichier doit être une image',
        'newPhoto.max' => 'L\'image ne doit pas dépasser 2 MB',
        'currentPassword.required' => 'Le mot de passe actuel est requis',
        'newPassword.required' => 'Le nouveau mot de passe est requis',
        'newPassword.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
        'newPassword.same' => 'Les mots de passe ne correspondent pas',
        'newPasswordConfirmation.required' => 'La confirmation du mot de passe est requise',
    ];

    // Charger les données de l'utilisateur
    public function mount()
    {
        $user = Auth::user();
        
        $this->nom = $user->nom;
        $this->prenom = $user->prenom;
        $this->email = $user->email;
        $this->telephone = $user->telephone;
        $this->dateNaissance = $user->dateNaissance ? $user->dateNaissance->format('Y-m-d') : '';
        $this->photo = $user->photo;
    }

    // Basculer le mode édition
    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
        
        if (!$this->editMode) {
            // Réinitialiser les données si on annule
            $this->mount();
            $this->newPhoto = null;
        }
    }

    // Mettre à jour le profil
    public function updateProfile()
    {
        // Valider les données
        $validatedData = $this->validate($this->rulesProfile(), $this->messages);

        try {
            DB::beginTransaction();

            $user = Utilisateur::find(Auth::id());

            // Gérer l'upload de la photo
            if ($this->newPhoto) {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                
                // Sauvegarder la nouvelle photo
                $photoPath = $this->newPhoto->store('photos', 'public');
                $user->photo = $photoPath;
            }

            // Mettre à jour les champs
            $user->nom = $validatedData['nom'];
            $user->prenom = $validatedData['prenom'];
            $user->email = $validatedData['email'];
            $user->telephone = $validatedData['telephone'];
            $user->dateNaissance = $validatedData['dateNaissance'];
            
            // Sauvegarder
            $user->save();

            DB::commit();

            $this->photo = $user->photo;
            $this->editMode = false;
            $this->newPhoto = null;

            session()->flash('success', 'Profil mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
            
            Log::error('Erreur mise à jour profil: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    // Mettre à jour le mot de passe
    public function updatePassword()
    {
        // Valider les données
        $validatedData = $this->validate($this->rulesPassword(), $this->messages);

        try {
            $user = Utilisateur::find(Auth::id());

            // Vérifier le mot de passe actuel
            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', 'Le mot de passe actuel est incorrect.');
                return;
            }

            DB::beginTransaction();

            // Mettre à jour le mot de passe
            $user->password = Hash::make($this->newPassword);
            $user->save();

            DB::commit();

            // Réinitialiser les champs
            $this->currentPassword = '';
            $this->newPassword = '';
            $this->newPasswordConfirmation = '';
            $this->showPasswordForm = false;

            session()->flash('success', 'Mot de passe modifié avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
            
            Log::error('Erreur changement mot de passe: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    // Supprimer la photo
    public function deletePhoto()
    {
        try {
            DB::beginTransaction();

            $user = Utilisateur::find(Auth::id());

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
                $user->photo = null;
                $user->save();
                $this->photo = null;
            }

            DB::commit();

            session()->flash('success', 'Photo supprimée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());
            
            Log::error('Erreur suppression photo: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    // Méthode de rendu
    public function render()
    {
        return view('livewire.shared.profil-client');
    }
}