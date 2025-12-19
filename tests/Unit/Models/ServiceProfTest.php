<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SoutienScolaire\ServiceProf;
use App\Models\SoutienScolaire\Professeur;
use App\Models\SoutienScolaire\Matiere;
use App\Models\SoutienScolaire\Niveau;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ServiceProfTest extends TestCase
{
    use RefreshDatabase;

    private function createProfesseur(): Professeur
    {
        $user = Utilisateur::create([
            'nom' => 'Prof',
            'prenom' => 'Test',
            'email' => 'prof' . rand(1000, 9999) . '@example.com',
            'password' => Hash::make('password123'),
            'telephone' => '06' . rand(10000000, 99999999),
            'statut' => 'actif',
            'role' => 'intervenant',
            'dateNaissance' => '1985-01-01'
        ]);

        $intervenant = Intervenant::create([
            'IdIntervenant' => $user->idUser,
        ]);

        return Professeur::create([
            'CIN' => 'CIN' . rand(100000, 999999),
            'surnom' => 'Prof' . rand(1, 999),
            'biographie' => 'Biographie test',
            'niveau_etudes' => 'Master',
            'intervenant_id' => $intervenant->IdIntervenant
        ]);
    }

    private function createMatiere(): Matiere
    {
        return Matiere::create([
            'nom_matiere' => 'Matière ' . rand(1, 999),
            'description' => 'Description matière'
        ]);
    }

    private function createNiveau(): Niveau
    {
        return Niveau::create([
            'nom_niveau' => 'Niveau ' . rand(1, 999),
            'description' => 'Description niveau'
        ]);
    }

    /** @test */
    public function it_can_be_created_with_all_fields()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Cours de Mathématiques',
            'description' => 'Cours particulier de maths',
            'prix_par_heure' => 150.00,
            'status' => 'actif',
            'type_service' => 'enligne', // Valeur valide pour ton ENUM
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertDatabaseHas('services_prof', [
            'titre' => 'Cours de Mathématiques',
            'prix_par_heure' => 150.00,
            'professeur_id' => $professeur->id_professeur
        ]);
    }

    /** @test */
    public function it_belongs_to_a_professeur()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Cours de Physique',
            'prix_par_heure' => 120.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertInstanceOf(Professeur::class, $service->professeur);
        $this->assertEquals($professeur->id_professeur, $service->professeur->id_professeur);
    }

    /** @test */
    public function it_belongs_to_a_matiere()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Cours de Chimie',
            'prix_par_heure' => 130.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertInstanceOf(Matiere::class, $service->matiere);
        $this->assertEquals($matiere->id_matiere, $service->matiere->id_matiere);
    }

    /** @test */
    public function it_belongs_to_a_niveau()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Cours niveau Collège',
            'prix_par_heure' => 100.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertInstanceOf(Niveau::class, $service->niveau);
        $this->assertEquals($niveau->id_niveau, $service->niveau->id_niveau);
    }

    /** @test */
    public function it_can_update_prix_par_heure()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Cours à mettre à jour',
            'prix_par_heure' => 100.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $service->update(['prix_par_heure' => 200.00]);

        $this->assertEquals(200.00, $service->fresh()->prix_par_heure);
    }

    /** @test */
    public function it_stores_prix_as_float()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Test Prix Float',
            'prix_par_heure' => 155.50,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertIsFloat($service->prix_par_heure);
        $this->assertEquals(155.50, $service->prix_par_heure);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $professeur = $this->createProfesseur();
        $matiere = $this->createMatiere();
        $niveau = $this->createNiveau();

        $service = ServiceProf::create([
            'titre' => 'Service à supprimer',
            'prix_par_heure' => 150.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $serviceId = $service->id_service;
        $service->delete();

        $this->assertDatabaseMissing('services_prof', [
            'id_service' => $serviceId
        ]);
    }

    /** @test */
    public function professeur_can_have_multiple_services()
    {
        $professeur = $this->createProfesseur();
        $matiere1 = $this->createMatiere();
        $matiere2 = $this->createMatiere();
        $niveau = $this->createNiveau();

        ServiceProf::create([
            'titre' => 'Service 1',
            'prix_par_heure' => 100.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere1->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        ServiceProf::create([
            'titre' => 'Service 2',
            'prix_par_heure' => 150.00,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $matiere2->id_matiere,
            'niveau_id' => $niveau->id_niveau
        ]);

        $this->assertCount(2, $professeur->servicesProf);
    }
}