<?php

namespace Database\Factories;

use App\Models\Shared\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'telephone' => fake()->phoneNumber(),
            'dateNaissance' => fake()->date('Y-m-d', '-18 years'),
            'role' => 'client',
            'statut' => 'actif',
            'note' => 0,
            'nbrAvis' => 0,
        ];
    }
}