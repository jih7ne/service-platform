<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google authentication page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Vérifier si l'utilisateur existe déjà
            $user = Utilisateur::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // L'utilisateur existe, connectez-le
                Auth::login($user);
                
                return $this->redirectBasedOnRole($user);
            }

            // Créer un nouveau compte client
            $user = Utilisateur::create([
                'nom' => $googleUser->user['family_name'] ?? 'Nom',
                'prenom' => $googleUser->user['given_name'] ?? $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(24)), // Mot de passe aléatoire
                'telephone' => null, // À compléter par l'utilisateur plus tard
                'dateNaissance' => null, // À compléter par l'utilisateur plus tard
                'role' => 'client',
                'statut' => 'actif',
                'photo' => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(), // Optionnel : stocker l'ID Google
            ]);

            Auth::login($user);

            return redirect('/')
                ->with('success', 'Bienvenue ' . $user->prenom . ' ! Compte créé avec Google.');

        } catch (\Exception $e) {
            return redirect('/connexion')
                ->with('error', 'Erreur lors de la connexion avec Google : ' . $e->getMessage());
        }
    }

    /**
     * Redirect based on user role
     */
    protected function redirectBasedOnRole(Utilisateur $user)
{
    if ($user->role === 'intervenant') {
        return redirect('/')
            ->with('success', 'Bienvenue ' . $user->prenom . ' !');
    }

    if ($user->role === 'client') {
        return redirect('/')
            ->with('success', 'Bienvenue ' . $user->prenom . ' !');
    }

    return redirect('/')
        ->with('success', 'Connexion réussie !');
}
}