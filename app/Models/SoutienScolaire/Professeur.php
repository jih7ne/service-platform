<?php

namespace App\Models\SoutienScolaire;

use App\Models\Shared\Intervenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Professeur extends Model
{
    public $timestamps = false;
    
    protected $table = 'professeurs';
    protected $primaryKey = 'id_professeur';

    protected $fillable = [
        'CIN',
        'surnom',
        'biographie',
        'diplome',
        'niveau_etudes',
        'intervenant_id',
    ];

    /**
     * Relation avec le modèle Intervenant
     */
    public function intervenant(): BelongsTo
    {
        return $this->belongsTo(Intervenant::class, 'intervenant_id', 'idIntervenant');
    }

    /**
     * Relation avec les services du professeur
     */
    public function servicesProf(): HasMany
    {
        return $this->hasMany(ServiceProf::class, 'professeur_id', 'id_professeur');
    }
}
