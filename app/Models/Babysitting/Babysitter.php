<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;
use App\Models\shared\Intervenant;
use App\Models\Babysitting\PreferenceDomicil;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;

class Babysitter extends Model
{
    protected $table = 'babysitters';
    protected $primaryKey = 'idBabysitter';
    
    protected $fillable = [
        'idBabysitter',
        'prixHeure',
        'expAnnee',
        'langues',
        'procedeJuridique',
        'coprocultureSelles',
        'certifAptitudeMentale',
        'radiographieThorax',
        'maladies',
        'estFumeur',
        'mobilite',
        'possedeEnfant',
        'permisConduite',
        'description',
        'niveauEtudes',
    ];

    protected $casts = [
        'estFumeur' => 'boolean',
        'mobilite' => 'boolean',
        'possedeEnfant' => 'boolean',
        'permisConduite' => 'boolean',
        'langues' => 'array',
    ];

    // Relations
    public function intervenant()
    {
        return $this->belongsTo(Intervenant::class, 'idBabysitter', 'IdIntervenant');
    }

    public function preferencesDomicil()
    {
        return $this->belongsToMany(
            PreferenceDomicil::class,
            'choisir_domicils',
            'idBabysitter',
            'idDomicil'
        );
    }

    public function superpourvoirs()
    {
        return $this->belongsToMany(
            Superpouvoir::class,
            'choisir_superpourvoirs',
            'idBabysitter',
            'idSuperpouvoir'
        );
    }

    public function formations()
    {
        return $this->belongsToMany(
            Formation::class,
            'choisir_formations',
            'idBabysitter',
            'idFormation'
        );
    }

    public function categoriesEnfants()
    {
        return $this->belongsToMany(
            CategorieEnfant::class,
            'choisir_categories',
            'idBabysitter',
            'idCategorie'
        );
    }

    public function experiencesBesoinsSpeciaux()
    {
        return $this->belongsToMany(
            ExperienceBesoinSpeciaux::class,
            'choisir_experiences',
            'idBabysitter',
            'idExperience'
        );
    }

    // Scopes
    public function scopeValide($query)
    {
        return $query->whereHas('intervenant', function($q) {
            $q->where('statut', 'VALIDE');
        });
    }

    public function scopeDisponible($query)
    {
        return $query->whereHas('intervenant.disponibilites');
    }

    public function scopeParPrix($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('prixHeure', '>=', $min);
        }
        if ($max) {
            $query->where('prixHeure', '<=', $max);
        }
        return $query;
    }

    public function scopeParExperience($query, $experience)
    {
        return $query->where('expAnnee', $experience);
    }

    public function scopeAvecLangue($query, $langue)
    {
        return $query->whereJsonContains('langues', $langue);
    }
    
}