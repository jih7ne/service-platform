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
            'surnom' => 'Multi Prof',
            'intervenant_id' => $intervenant->IdIntervenant,
            'niveau_etudes' => 'PhD'
        ]);

        $this->assertIsObject($professeur->servicesProf);
    }
}