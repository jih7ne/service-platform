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
    /**
 * Relation avec l'intervenant -> utilisateur (pour accéder à la note)
 */
public function utilisateur()
{
    return $this->hasOneThrough(
        \App\Models\Shared\Utilisateur::class,
        \App\Models\Shared\Intervenant::class,
        'IdIntervenant', // Foreign key sur intervenants (lié à utilisateurs)
        'idUser', // Foreign key sur utilisateurs (primary key)
        'intervenant_id', // Local key sur professeurs
        'idIntervenant' // Local key sur intervenants (lié à utilisateurs)
    );
}
}
