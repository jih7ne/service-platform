<?php

namespace App\Models\PetKeeping;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'animals';
    protected $primaryKey = 'idAnimale';

    protected $fillable = [
        'idDemande',
        'nomAnimal',
        'poids',
        'taille',
        'age',
        'sexe',
        'race',
        'espece',
        'statutVaccination',
        'note_comportementale',
    ];


    public const VACC_ONCE = 'ONCE';
    public const VACC_RECURRING = 'RECURRING';
    public const VACC_NEVER = 'NEVER';
    public const VACC_MULTIPLE = 'MULTIPLE';

    public const VACCINATION_STATUSES = [
        self::VACC_ONCE,
        self::VACC_RECURRING,
        self::VACC_NEVER,
        self::VACC_MULTIPLE,
    ];

    public function demande()
    {
        return $this->belongsTo(\App\Models\Shared\DemandesIntervention::class, 'idDemande', 'idDemande');
    }

    public function isVaccinated(): bool
    {
        return $this->statutVaccination !== self::VACC_NEVER;
    }
}
