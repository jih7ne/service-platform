<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\SoutienScolaire\Professeur;
use App\Models\Shared\Intervenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfesseurModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_intervenant()
    {
        $intervenant = Intervenant::factory()->create();
        
        $professeur = Professeur::create([
            'CIN' => 'AB123456',  // ← AJOUTÉ ICI
            'surnom' => 'Professeur Cool',
            'biographie' => 'Bio test',
            'niveau_etudes' => 'Master',
            'intervenant_id' => $intervenant->IdIntervenant
        ]);

        $this->assertInstanceOf(Intervenant::class, $professeur->intervenant);
        $this->assertEquals($intervenant->IdIntervenant, $professeur->intervenant->IdIntervenant);
    }

    /** @test */
    public function professeur_can_have_multiple_services()
    {
        $intervenant = Intervenant::factory()->create();

        $professeur = Professeur::create([
            'CIN' => 'CD789012',  // ← AJOUTÉ ICI
            'surnom' => 'Multi Prof',
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'PhD'
        ]);

        $this->assertIsObject($professeur->servicesProf);
    }

    /** @test */
    public function it_can_be_created_with_required_fields()
    {
        $intervenant = Intervenant::factory()->create();

        $professeur = Professeur::create([
            'CIN' => 'EF345678',  // ← AJOUTÉ ICI
            'surnom' => 'Prof Test',
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'Licence'
        ]);

        $this->assertDatabaseHas('professeurs', [
            'CIN' => 'EF345678',
            'surnom' => 'Prof Test',
            'niveau_etudes' => 'Licence',
            'intervenant_id' => $intervenant->IdIntervenant
        ]);
    }

    /** @test */
    public function it_can_update_professeur_attributes()
    {
        $intervenant = Intervenant::factory()->create();

        $professeur = Professeur::create([
            'CIN' => 'GH901234',  // ← AJOUTÉ ICI
            'surnom' => 'Ancien Surnom',
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'Master'
        ]);

        $professeur->update([
            'surnom' => 'Nouveau Surnom',
            'biographie' => 'Nouvelle bio'
        ]);

        $this->assertEquals('Nouveau Surnom', $professeur->surnom);
        $this->assertEquals('Nouvelle bio', $professeur->biographie);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $intervenant = Intervenant::factory()->create();

        $professeur = Professeur::create([
            'CIN' => 'IJ567890',  // ← AJOUTÉ ICI
            'surnom' => 'Prof à supprimer',
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'Master'
        ]);

        $professeurId = $professeur->id_professeur;  // ← CORRIGÉ (pas 'id')
        $professeur->delete();

        $this->assertDatabaseMissing('professeurs', [
            'id_professeur' => $professeurId  // ← CORRIGÉ
        ]);
    }

    /** @test */
    public function it_stores_biographie_correctly()
    {
        $intervenant = Intervenant::factory()->create();
        $longBio = 'Ceci est une longue biographie avec plusieurs lignes de texte pour tester le stockage.';

        $professeur = Professeur::create([
            'CIN' => 'KL123456',  // ← AJOUTÉ ICI
            'surnom' => 'Prof Bio',
            'biographie' => $longBio,
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'PhD'
        ]);

        $this->assertEquals($longBio, $professeur->fresh()->biographie);
    }

    /** @test */
    public function it_can_retrieve_niveau_etudes()
    {
        $intervenant = Intervenant::factory()->create();
        $niveaux = ['Licence', 'Master', 'PhD', 'Doctorat'];

        foreach ($niveaux as $index => $niveau) {
            $professeur = Professeur::create([
                'CIN' => 'NV' . str_pad($index, 6, '0', STR_PAD_LEFT),  // ← AJOUTÉ ICI (CIN unique)
                'surnom' => "Prof $niveau",
                'intervenant_id' => $intervenant->IdIntervenant,
                'niveau_etudes' => $niveau
            ]);

            $this->assertEquals($niveau, $professeur->niveau_etudes);
        }
    }
    /** @test */
public function it_requires_cin_to_create_professeur()
{
    $this->expectException(\Illuminate\Database\QueryException::class);
    
    $intervenant = Intervenant::factory()->create();
    
    Professeur::create([
        'surnom' => 'Prof Sans CIN',
        'intervenant_id' => $intervenant->IdIntervenant,
        'niveau_etudes' => 'Master'
    ]);
}

/** @test */
public function it_requires_intervenant_id_to_create_professeur()
{
    $this->expectException(\Illuminate\Database\QueryException::class);
    
    Professeur::create([
        'CIN' => 'XY123456',
        'surnom' => 'Prof Sans Intervenant',
        'niveau_etudes' => 'Master'
    ]);
}

/** @test */
public function it_can_have_optional_biographie()
{
    $intervenant = Intervenant::factory()->create();
    
    $professeur = Professeur::create([
        'CIN' => 'ZA987654',
        'surnom' => 'Prof Sans Bio',
        'intervenant_id' => $intervenant->IdIntervenant,
        'niveau_etudes' => 'Licence'
    ]);
    
    $this->assertNull($professeur->biographie);
}

/** @test */
public function it_can_have_optional_diplome()
{
    $intervenant = Intervenant::factory()->create();
    
    $professeur = Professeur::create([
        'CIN' => 'BC456789',
        'surnom' => 'Prof Sans Diplome',
        'intervenant_id' => $intervenant->IdIntervenant,
        'niveau_etudes' => 'Master'
    ]);
    
    $this->assertNull($professeur->diplome);
}

/** @test */
public function multiple_professeurs_can_belong_to_different_intervenants()
{
    $intervenant1 = Intervenant::factory()->create();
    $intervenant2 = Intervenant::factory()->create();
    
    $prof1 = Professeur::create([
        'CIN' => 'DE111111',
        'surnom' => 'Prof 1',
        'intervenant_id' => $intervenant1->IdIntervenant,
        'niveau_etudes' => 'Master'
    ]);
    
    $prof2 = Professeur::create([
        'CIN' => 'FG222222',
        'surnom' => 'Prof 2',
        'intervenant_id' => $intervenant2->IdIntervenant,
        'niveau_etudes' => 'PhD'
    ]);
    
    $this->assertNotEquals($prof1->intervenant_id, $prof2->intervenant_id);
    $this->assertEquals($intervenant1->IdIntervenant, $prof1->intervenant_id);
    $this->assertEquals($intervenant2->IdIntervenant, $prof2->intervenant_id);
}



/** @test */
public function it_can_update_cin()
{
    $intervenant = Intervenant::factory()->create();
    
    $professeur = Professeur::create([
        'CIN' => 'OLD123456',
        'surnom' => 'Prof',
        'intervenant_id' => $intervenant->IdIntervenant,
        'niveau_etudes' => 'Master'
    ]);
    
    $professeur->update(['CIN' => 'NEW789012']);
    
    $this->assertEquals('NEW789012', $professeur->fresh()->CIN);
}

/** @test */
public function it_returns_empty_collection_when_no_services()
{
    $intervenant = Intervenant::factory()->create();
    
    $professeur = Professeur::create([
        'CIN' => 'HI333333',
        'surnom' => 'Prof Sans Services',
        'intervenant_id' => $intervenant->IdIntervenant,
        'niveau_etudes' => 'Master'
    ]);
    
    $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $professeur->servicesProf);
    $this->assertCount(0, $professeur->servicesProf);
}
}