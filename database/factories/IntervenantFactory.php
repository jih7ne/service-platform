<?php

namespace Database\Factories;

use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntervenantFactory extends Factory
{
    protected $model = Intervenant::class;

    public function definition(): array
    {
        // Create admin if doesn't exist
        $admin = Admin::firstOrCreate(
            ['emailAdmin' => 'admin@test.com'],
            ['passwordAdmin' => bcrypt('password')]
        );

        // Create user
        $user = Utilisateur::factory()->create([
            'role' => 'intervenant',
            'idAdmin' => $admin->idAdmin
        ]);

        return [
            'IdIntervenant' => $user->idUser,
            'statut' => 'VALIDE',
            'idAdmin' => $admin->idAdmin,
        ];
    }
}