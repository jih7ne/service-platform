<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle user/admin login
     */
    public function store(LoginRequest $request)
    {
        // 1. Validation des champs
        $data = $request->validated();
        $email = $data['email'];
        $password = $data['password'];
        $remember = $data['remember'] ?? false;

        \Log::info('Tentative de connexion', ['email' => $email]);

        // ----------------------------------------------------------------
        // CAS 1 : CONNEXION ADMIN
        // ----------------------------------------------------------------
        $admin = \App\Models\Shared\Admin::where('emailAdmin', $email)->first();
        
        if ($admin) {
            if (Hash::check($password, $admin->passwordAdmin)) {
                // Régénérer la session pour sécurité
                $request->session()->invalidate();
                $request->session()->regenerate(true);
                
                // Stocker les données de session admin
                session(['admin_id' => $admin->idAdmin]);
                session(['admin_email' => $admin->emailAdmin]);
                session(['is_admin' => true]);
                
                // Forcer la sauvegarde de la session
                session()->save();

                \Log::info('Succès connexion Admin', ['id' => $admin->idAdmin]);

                return redirect()->intended(route('admin.dashboard'));
            } else {
                \Log::warning('Échec connexion Admin : Mot de passe incorrect', ['email' => $email]);
                // On ne retourne pas tout de suite, on vérifie si c'est aussi un utilisateur
            }
        }

        // ----------------------------------------------------------------
        // CAS 2 : CONNEXION UTILISATEUR NORMAL
        // ----------------------------------------------------------------
        $user = Utilisateur::where('email', $email)->first();

        if (!$user) {
            \Log::warning('Échec connexion : Utilisateur non trouvé', ['email' => $email]);
            return back()->withErrors([
                'email' => 'Aucun compte trouvé avec cet email.',
            ])->onlyInput('email');
        }

        // Vérification mot de passe utilisateur
        if (!Hash::check($password, $user->password)) {
            \Log::warning('Échec connexion : Mot de passe utilisateur incorrect', ['user_id' => $user->id]);
            return back()->withErrors([
                'email' => 'Mot de passe incorrect.',
            ])->onlyInput('email');
        }

        // Vérification statut
        if ($user->statut !== 'actif') {
            \Log::warning('Échec connexion : Compte suspendu', ['user_id' => $user->id]);
            return back()->withErrors([
                'email' => 'Votre compte est suspendu. Veuillez contacter l\'administrateur.',
            ])->onlyInput('email');
        }

        // Connexion réussie
        Auth::login($user, $remember);
        $request->session()->regenerate();
        
        \Log::info('Succès connexion Utilisateur', ['user_id' => $user->id, 'role' => $user->role]);

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole(Utilisateur $user)
    {
        if ($user->role === 'intervenant') {
            return redirect()->intended(route('intervenant.hub'))
                ->with('success', 'Bienvenue ' . $user->prenom . ' !');
        }

        if ($user->role === 'client') {
            return redirect()->intended(route('home'))
                ->with('success', 'Bienvenue ' . $user->prenom . ' !');
        }

        // Par défaut
        return redirect()->intended(route('home'));
    }

    /**
     * Handle user logout
     */
    public function destroy()
    {
        // Nettoyage session admin
        session()->forget(['admin_id', 'admin_email', 'is_admin']);

        // Logout Auth standard
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous êtes déconnecté avec succès.');
    }
}