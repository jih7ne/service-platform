<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Handle client registration
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = Utilisateur::create([
            'nom'           => $data['lastName'],
            'prenom'        => $data['firstName'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'telephone'     => $data['telephone'],
            'dateNaissance' => $data['dateNaissance'],
            'role'          => 'client',
            'statut'        => 'actif',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Compte client créé avec succès !');
    }
}
