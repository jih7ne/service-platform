<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle user login
     */
    public function store(LoginRequest $request)
    {
        $data = $request->validated();

        $user = Utilisateur::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Les identifiants fournis sont incorrects.',
            ])->onlyInput('email');
        }

        if ($user->statut !== 'actif') {
            return back()->withErrors([
                'email' => 'Votre compte est suspendu. Veuillez contacter l\'administrateur.',
            ])->onlyInput('email');
        }

        Auth::login($user, $data['remember'] ?? false);

        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole(Utilisateur $user)
    {
        if ($user->role === 'intervenant') {
            return redirect()->route('babysitter.dashboard')
                ->with('success', 'Bienvenue ' . $user->prenom . ' !');
        }

        if ($user->role === 'client') {
            return redirect()->route('home')
                ->with('success', 'Bienvenue ' . $user->prenom . ' !');
        }

        // Par défaut
        return redirect()->route('home')
            ->with('success', 'Connexion réussie !');
    }

    /**
     * Handle user logout
     */
    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous êtes déconnecté avec succès.');
    }
}