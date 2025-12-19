<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Shared\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/connexion');

        $response->assertOk();
        $response->assertSeeLivewire('shared.login-page');
    }

    /** @test */
    public function user_can_view_register_page()
    {
        $response = $this->get('/inscription');

        $response->assertOk();
        $response->assertSeeLivewire('shared.register');
    }

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/tutoring/dashboard');

        $response->assertRedirect('/connexion');
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $user = Utilisateur::create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '0612345678',
            'statut' => 'actif',
            'role' => 'intervenant',
            'dateNaissance' => '1990-01-01'
        ]);

        $response = $this->actingAs($user)->get('/tutoring/dashboard');

        $response->assertOk();
    }

    /** @test */
    public function authenticated_user_can_access_profile()
    {
        $user = Utilisateur::create([
            'nom' => 'Smith',
            'prenom' => 'Jane',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '0698765432',
            'statut' => 'actif',
            'role' => 'client',
            'dateNaissance' => '1995-05-15'
        ]);

        $response = $this->actingAs($user)->get('/profil');

        $response->assertOk();
    }

    /** @test */
    public function user_data_is_stored_correctly()
    {
        $user = Utilisateur::create([
            'nom' => 'Martin',
            'prenom' => 'Paul',
            'email' => 'paul@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '0611223344',
            'statut' => 'actif',
            'role' => 'client',
            'dateNaissance' => '1988-03-20'
        ]);

        $this->assertDatabaseHas('utilisateurs', [
            'email' => 'paul@example.com',
            'nom' => 'Martin',
            'prenom' => 'Paul',
            'role' => 'client'
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function user_can_have_different_roles()
    {
        $client = Utilisateur::create([
            'nom' => 'Client',
            'prenom' => 'Test',
            'email' => 'client@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '0601020304',
            'statut' => 'actif',
            'role' => 'client',
            'dateNaissance' => '1990-01-01'
        ]);

        $intervenant = Utilisateur::create([
            'nom' => 'Intervenant',
            'prenom' => 'Test',
            'email' => 'intervenant@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '0605060708',
            'statut' => 'actif',
            'role' => 'intervenant',
            'dateNaissance' => '1985-06-15'
        ]);

        $this->assertEquals('client', $client->role);
        $this->assertEquals('intervenant', $intervenant->role);
    }
}