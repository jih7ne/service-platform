<?php

namespace App\Models\Babysitting;

use Illuminate\Database\Eloquent\Model;

class ExperienceBesoinSpeciaux extends Model
{
    protected $table = 'experience_besoins_speciaux';
    protected $primaryKey = 'idExperience';
    
    public $timestamps = false;
    
    protected $fillable = [
        'experience',
    ];

    public function babysitters()
    {
        return $this->belongsToMany(
            Babysitter::class,
            'choisir_experiences',
            'idExperience',
            'idBabysitter'
        );
    }
}